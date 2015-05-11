<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Person;
use App\FileEntry;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CreateFileEntryRequest;
use Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Intervention\Image\ImageManagerStatic as Image;

class FileEntryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $uploadError = 0; //Se maneja desde App\Exceptions\Handler.php para los archivos que superan los 8 MB.
        $person=Person::findOrFail($id);
        return view('fileentries.index', compact('person','uploadError'));
    }

    public function store(CreateFileEntryRequest $request)
    {
        $entry = new FileEntry();
        $file = Request::file('filename');
        $entry->upload($file);
        $person_id = Request::input('person_id');
        if($person_id == NULL)
        {
            abort("$person_id is NULL at FileEntryController@add");
        }
        $person=Person::findOrFail($person_id);
        $entry->save();
        $person->fileentries()->save($entry);

        return redirect('person/'.$person_id);
    }

    public function show($id)
    {
        $file=FileEntry::find($id);
        $filename=$file->filename;
        $image = Image::make("../storage/app/assets/fileentries/$filename");
        return $image->response();
    }

}

