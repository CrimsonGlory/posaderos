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
    var $storage_path = '../storage/app/assets/fileentries/';

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

    public function store(CreateFileEntryRequest $request)
    {
        $person_id = Request::input('person_id');
        if(is_null($person_id))
        {
            abort("$person_id is NULL at FileEntryController@index");
        }

        $person = Person::findOrFail($person_id);
        $files = Input::file('files');
        $message = "";
        foreach($files as $file)
        {
            $rules = array(
                'file' => 'required|max:8000|mimes:3gp,avi,bmp,csv,doc,docx,flac,gif,gz,gzip,jpeg,jpg,kml,kmz,m4a,mov,mp3,mp4,mpeg,mpg,odp,ods,odt,oga,ogg,ogv,pdf,png,pps,pptx,svg,swf,tar,text,tif,txt,wav,webm,wmv,xls,xlsx,xml,xsl,xsd,zip'
            );
            $validator = \Validator::make(array('file'=> $file), $rules);
            $ext = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);

            if($validator->passes() && $this->extension_is_valid($ext))
            {
                $entry = new FileEntry();
                $entry->upload($file);
                $entry->uploader_id = Auth::user()->id;
		$entry->size=$file->getClientSize();
		$entry->md5 = '0';//para poderlo guardar. No logro obtener el md5 antes de guardarlo.
                $entry->save();
		$entry->md5 = md5_file($this->storage_path.$entry->filename);
		$already_added=false;
		$old_file = $this->find_duplicate($entry);
		if(!is_null($old_file)) // if someone has the file
		{
			if($person->fileentries()->where('size','=',$entry->size)->where('md5','=',$entry->md5)->count() != 0 )//if current person already has the file
			{
				$already_added=true;
			}
			$this->hard_delete($entry);
			$entry = $old_file;
		}
                if($entry->isImage())
                {
                    $entry->avatar_of()->save($person);
                }
		if(!$already_added)
		{
	                $person->fileentries()->save($entry);//add relationship
		}
                $message.= $entry->original_filename.', ';
            }
            else
            { //Does not pass validation
                $errors = $validator->errors();
                if($file)
                    $message.= $file->getClientOriginalName().": ".implode(",",$errors->get("file")).'.';
                else
                    $message.= trans('messages.noAttachment');
            }
        }

	    if(!isset($errors))
        {
            $message = substr($message, 0, -2).' ';
            if (count($files) == 1)
                flash()->success($message.trans('messages.fileSaved'));
            else
                flash()->success($message.trans('messages.filesSaved'));
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
            $image = Image::make($this->storage_path.$filename);
            return $image->response();
        }
        else
        {
            $content = File::get($this->storage_path.$filename);
            return (new Response($content, 200))->header('Content-Type', $file->mime);
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
        $path = $this->storage_path;
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

    /* Funciones privadas */

    private function extension_is_valid($ext)
    {
        return in_array(strtolower($ext),['3gp','avi','bmp','csv','doc','docx','flac','gif','gz','gzip','jpeg','jpg','kml','kmz','m4a','mov','mp3','mp4','mpeg','mpg','odp','ods','odt','oga','ogg','ogv','pdf','png','pps','pptx','svg','swf','tar','text','tif','txt','wav','webm','wmv','xls','xlsx','xml','xsl','xsd','zip']);
    }

    /*
     * Returns duplicate file if it exists. NULL otherwise
     */
    private function find_duplicate($file)
    {
        if (is_null($file))
        {
            return NULL;
        }
        return FileEntry::where('size','=',$file->size)->where('md5','=',$file->md5)->where('id','<>',$file->id)->first();
    }

    private function hard_delete($file)
    {
        if (is_null($file))
        {
            return;
        }
        unlink($this->storage_path.$file->filename);
        $file->delete();
    }

}
