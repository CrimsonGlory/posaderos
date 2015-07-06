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
            abort(404);
        }

        $person = Person::findOrFail($id);
        if ($user->can('edit-all-people') || ($user->can('edit-new-people') && $person->created_by == $user->id))
        {
            return view('fileentries.create', compact('person','uploadError'));
        }
        abort(403);
    }

    public function store(CreateFileEntryRequest $request)
    {
        $person_id = Request::input('person_id');
        $person = Person::findOrFail($person_id);

        $files = Input::file('files');
        $messageSuccess = '';
        $messageErrors = '';
        foreach($files as $file)
        {
            $rules = array(
                'file' => 'required|max:8000|mimes:3gp,avi,bmp,csv,doc,docx,flac,flv,gif,gz,gzip,jpeg,jpg,kml,kmz,m4a,mov,mp3,mp4,mpeg,mpg,odp,ods,odt,oga,ogg,ogv,pdf,png,pps,pptx,svg,swf,tar,text,tif,txt,wav,webm,wmv,xls,xlsx,xml,xsl,xsd,zip'
            );
            $validator = \Validator::make(array('file'=> $file), $rules);

            $ext = (($file)? pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION) : null);
            if ($validator->passes() && $this->extension_is_valid($ext))
            {
                $entry = new FileEntry();
                $entry->upload($file);
                $entry->uploader_id = Auth::user()->id;
                $entry->size = $file->getClientSize();
                $entry->md5 = '0';//para poderlo guardar. No logro obtener el md5 antes de guardarlo.
                $entry->save();
                $entry->md5 = md5_file($this->storage_path.$entry->filename);
                $already_added = false;
                $old_file = $this->find_duplicate($entry);
                if(!is_null($old_file)) // if someone has the file
                {
                    if($person->fileentries()->where('size','=',$entry->size)->where('md5','=',$entry->md5)->count() != 0 )//if current person already has the file
                    {
                        $already_added = true;
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
                $messageSuccess.= $entry->original_filename.', ';
            }
            else
            { //Does not pass validation
                $errors = $validator->errors();
                if($file)
                {
                    if (!$this->extension_is_valid($ext))
                        $messageErrors.= $file->getClientOriginalName().' '.trans('messages.invalidExtension').', ';
                    else
                        $messageErrors.= $file->getClientOriginalName().': '.implode(',',$errors->get("file")).', ';
                }
                else
                {
                    $messageErrors.= trans('messages.noAttachment').', ';
                }
            }
        }

	    if(!isset($errors))
        {
            if (strlen($messageSuccess) > 2)
            {
                $messageSuccess = substr($messageSuccess, 0, -2).' ';
            }

            if (count($files) == 1)
                flash()->success($messageSuccess.trans('messages.fileSaved'));
            else
                flash()->success($messageSuccess.trans('messages.filesSaved'));

        	return redirect('person/'.$person_id);
	    }
	    else
        {
            if (strlen($messageErrors) > 2)
            {
                $messageErrors = substr($messageErrors, 0, -2).'.';
            }

            flash()->error($messageErrors)->important();
		    return redirect('person/'.$person_id.'/fileentries/photos');
	    }
    }

    public function show($id)
    {
        $file = FileEntry::find($id);
        if (is_null($file) || is_null(Auth::user()))
        {
            abort(404);
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

    public function resize($size,$id)
    {
        if (is_null(Auth::user()))
        {
            abort(404);
        }
	    return $this->showWithSize($size,$id,false);
    }

    public function thumb($size,$id)
    {
        if (is_null(Auth::user()))
        {
            abort(404);
        }
	    return $this->showWithSize($size,$id,true);
    }

    /* Funciones privadas */

    private function showWithSize($size, $id,$outbound)
    {
        if (!is_numeric($size) || ($size != 50 && $size != 72 && $size != 150 && $size != 205 && $size != 320 && $size != 720))
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
        list($width, $height) = getimagesize($path.$filename);
        if($width < $size && $height < $size)
        {
            $image = Image::make($path.$filename);
            return $image->response();
        }
        if($outbound)
        {
            $separator = "thumb";
        }
        else
        {
            $separator = "resize";
        }

        $original = $path.$filename;
        $filename_without_extension = pathinfo($original)['filename'];
        $extension = pathinfo($original)['extension'];
        $destination = $path.$filename_without_extension.".$separator".$size.".".$extension;
        if (!File::exists($destination))
        {
            $this->create_image($original,$destination,$size,$outbound);
        }
        $result = Image::make($destination);
        return $result->response();
    }

    private function create_image($path_origin,$path_destination,$size,$outbound = true)
    {
        $width  = $size;
        $height = $size;
        if($outbound)
        {
            $mode = ImageInterface::THUMBNAIL_OUTBOUND;
        }
        else
        {
            $mode = ImageInterface::THUMBNAIL_INSET;
        }
        $box   = new Box($width, $height);

        $image   = Imagine::open($path_origin)->thumbnail($box, $mode);
        $image->save($path_destination);
    }


    private function extension_is_valid($ext)
    {
        return in_array(strtolower($ext),['3gp','avi','bmp','csv','doc','docx','flac','flv','gif','gz','gzip','jpeg','jpg','kml','kmz','m4a','mov','mp3','mp4','mpeg','mpg','odp','ods','odt','oga','ogg','ogv','pdf','png','pps','pptx','svg','swf','tar','text','tif','txt','wav','webm','wmv','xls','xlsx','xml','xsl','xsd','zip']);
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
