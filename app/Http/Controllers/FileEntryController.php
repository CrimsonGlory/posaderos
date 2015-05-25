<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Person;
use App\FileEntry;
use Illuminate\Support\Facades\Auth;
use Input;
use App\Http\Requests\CreateFileEntryRequest;
use Illuminate\Support\Facades\Redirect;
use Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Intervention\Image\ImageManagerStatic as Image;
use Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

class FileEntryController extends Controller {

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $uploadError = 0; //Se maneja desde App\Exceptions\Handler.php para los archivos que superan los 8 MB.
        $user = Auth::user();
        if ($user == null)
        {
            return "404";
        }

        $person = Person::findOrFail($id);
        if ($user->can('edit-all-people') || ($user->can('edit-new-people') && $person->created_by == $user->id))
        {
            return view('fileentries.create', compact('person','uploadError'));
        }
        return Redirect::back();
    }

    public function store(CreateFileEntryRequest $request)
    {

        $person_id = Request::input('person_id');
        if($person_id == NULL)
        {
            abort("$person_id is NULL at FileEntryController@index");
        }

        $person = Person::findOrFail($person_id);
        $message="";
        foreach(Input::file('files') as $file){
            $rules = array(
                'file' => 'required|max:8000|mimes:jpg,jpeg,png'
            );
            $validator = \Validator::make(array('file'=> $file), $rules);
            if($validator->passes())
            {
                $ext = $file->guessClientExtension(); // (Based on mime type)
                $entry = new FileEntry();
                $entry->upload($file);
                $entry->save();
                $entry->avatar_of()->save($person);
                $person->fileentries()->save($entry);
                $message.=$entry->original_filename." OK. ";
            }
            else
            { //Does not pass validation
                $errors = $validator->errors();
                if($file)
                    $message.=$file->getClientOriginalName().": ".implode(",",$errors->get("file")). ". ";
                else
                    $message.="No se adjuntó ningun archivo. ";
            }
        }

	    if(!isset($errors))
        {
            flash()->success($message);
        	return redirect('person/'.$person_id);
	    }
	    else
        {
            flash()->error($message)->important();
		    return redirect('person/'.$person_id.'/fileentries/photos');
	    }
    }

    public function show($id)
    {
        $file = FileEntry::find($id);
        $filename = $file->filename;
        $image = Image::make("../storage/app/assets/fileentries/$filename");
        return $image->response();
    }
   public function showThumb($size,$id)
   {
	if($size!=50 && $size!=150)
		return "invalid size";
	$img = FileEntry::findOrFail($id);
	if(substr($img->mime, 0, 5) != 'image') {
		return "not an image";
	}
	if(count($img)==0)
		return "404";
	$filename = $img->filename;
	$path = "../storage/app/assets/fileentries/";
	$path_parts = pathinfo($path.$filename);	
	$thumb_path=$path.$path_parts['filename'].".thumb".$size.".".$path_parts['extension'];
	if (!File::exists($thumb_path))
		$this->create_thumbnail($path,$path_parts['filename'],$path_parts['extension'],$size);
	$result =  Image::make($thumb_path);
	return $result->response();


   }

   private function create_thumbnail($path, $filename, $extension,$pixelsize)
   {
    $width  = $pixelsize;
    $height = $pixelsize;
    $mode   = ImageInterface::THUMBNAIL_OUTBOUND;
    $size   = new Box($width, $height);

    $thumbnail   = Imagine::open($path.$filename.".".$extension)->thumbnail($size, $mode);
    $destination = "{$filename}.thumb$pixelsize.{$extension}";

    $thumbnail->save("{$path}/{$destination}");
   }

}

