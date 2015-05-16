<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Person;
use App\FileEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CreateFileEntryRequest;
use Illuminate\Support\Facades\Redirect;
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
        $user = Auth::user();
        if ($user == null)
        {
            return "404";
        }

        $person = Person::findOrFail($id);
        if ($user->can('edit-all-people') || ($user->can('edit-new-people') && $person->created_by == $user->id))
        {
            return view('fileentries.index', compact('person','uploadError'));
        }
        return Redirect::back();
    }

    public function store(CreateFileEntryRequest $request)
    {
        $entry = new FileEntry();
        $file = Request::file('filename');
        $entry->upload($file);

        $person_id = Request::input('person_id');
        if($person_id == NULL)
        {
            abort("$person_id is NULL at FileEntryController@index");
        }

        $person = Person::findOrFail($person_id);
        $entry->save();

	    if(count($person->fileentries) == 0)
        {
            $entry->avatar_of()->save($person);
        }

        if ($person->fileentries()->save($entry))
        {
            flash()->success('Foto agregada.');
        }
        else
        {
            flash()->error('Error al intentar agregar la foto del asistido.');
        }
        return redirect('person/'.$person_id);
    }

    public function show($id)
    {
        $file = FileEntry::find($id);
        $filename = $file->filename;
        $image = Image::make("../storage/app/assets/fileentries/$filename");
        return $image->response();
    }

}

