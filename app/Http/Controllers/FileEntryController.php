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
        if (is_null($user))
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

    private function extension_is_valid($ext){
	return in_array(strtolower($ext),['3gp','avi','bmp','csv','doc','docx','flac','gif','gz','gzip','jpeg','jpg','kml','kmz','m4a','mov','mp3','mp4','mpeg','mpg','odp','ods','odt','oga','ogg','ogv','pdf','png','pps','pptx','svg','swf','tar','text','tif','txt','wav','webm','wmv','xls','xlsx','xml','xsl','xsd','zip']);
    }

    public function store(CreateFileEntryRequest $request)
    {
        $person_id = Request::input('person_id');
        if(is_null($person_id))
        {
            abort("$person_id is NULL at FileEntryController@index");
        }

        $person = Person::findOrFail($person_id);
        $message="";
        foreach(Input::file('files') as $file){
            $rules = array(
                'file' => 'required|max:8000|mimes:3gp,avi,bmp,csv,doc,docx,flac,gif,gz,gzip,jpeg,jpg,kml,kmz,m4a,mov,mp3,mp4,mpeg,mpg,odp,ods,odt,oga,ogg,ogv,pdf,png,pps,pptx,svg,swf,tar,text,tif,txt,wav,webm,wmv,xls,xlsx,xml,xsl,xsd,zip'
            );
            $validator = \Validator::make(array('file'=> $file), $rules);
	    $ext = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
            if($validator->passes() && $this->extension_is_valid($ext))
            {
                $entry = new FileEntry();
                $entry->upload($file);
                $entry->save();
		if($entry->isImage())
		{
                	$entry->avatar_of()->save($person);
                }
		$person->fileentries()->save($entry);
                $message.=$entry->original_filename." OK. ";
            }
            else
            { //Does not pass validation
                $errors = $validator->errors();
                if($file)
                    $message.=$file->getClientOriginalName().": ".implode(",",$errors->get("file")). ". ";
                else
                    $message.=trans('messages.noAttachment');
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
        if (is_null($file))
        {
            return "404";
        }
        $filename = $file->filename;
	if($file->isImage())
	{
	        $image = Image::make("../storage/app/assets/fileentries/$filename");
        	return $image->response();
	}
	else
	{
		$content = File::get("../storage/app/assets/fileentries/$filename");
		return (new Response($content, 200))
	              ->header('Content-Type', $file->mime);
	}
    }

    public function showThumb($size, $id)
    {
        if ($size != 50 && $size != 150)
        {
            return "invalid size";
        }

        $img = FileEntry::findOrFail($id);
        if(substr($img->mime, 0, 5) != 'image')
        {
            return "not an image";
        }
        if(count($img) == 0)
        {
            return "404";
        }

        $filename = $img->filename;
        $path = "../storage/app/assets/fileentries/";
        $path_parts = pathinfo($path.$filename);
        $thumb_path = $path.$path_parts['filename'].".thumb".$size.".".$path_parts['extension'];
        if (!File::exists($thumb_path))
        {
            $this->create_thumbnail($path,$path_parts['filename'],$path_parts['extension'],$size);
        }
        $result = Image::make($thumb_path);
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
