<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Person;
use App\Fileentry;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CreateFileEntryRequest;
use Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class FileEntryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $person=Person::findOrFail($id);
        //$entries = Fileentry::all();
        return view('fileentries.index', compact('person'));
    }
    public function add(CreateFileEntryRequest $request)
    {
        $file = Request::file('filename');
        $person = Request::input('person_id');
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
        move_uploaded_file($file, public_path().'/'.$file->getFilename().'.'.$extension);
        $entry = new Fileentry();
        $entry->mime = $file->getClientMimeType();
        $entry->original_filename = $file->getClientOriginalName();
        $entry->filename = $file->getFilename().'.'.$extension;
        $entry->person_id = $person;
        $entry->save();
        return redirect('person/'.$entry->person_id);

    }

}
