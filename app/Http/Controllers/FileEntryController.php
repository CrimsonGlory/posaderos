<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Person;
use App\FileEntry;
use Illuminate\Support\Facades\Log;
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
        $person=Person::findOrFail($id);
        //$entries = Fileentry::all();
        return view('fileentries.index', compact('person'));
    }
    public function add(CreateFileEntryRequest $request)
    {
	$entry = new FileEntry();
	$file = Request::file('filename');
	$entry->upload($file);
        $person_id = Request::input('person_id');
	if($person_id==NULL)
		abort("$person_id is NULL at FileEntryContrller@add");
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
