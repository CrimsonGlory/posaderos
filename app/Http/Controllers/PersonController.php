<?php namespace App\Http\Controllers;

use App\Person;
use App\Http\Requests;
use App\Http\Requests\CreatePersonRequest;
use App\Http\Controllers\Controller;
use Auth;
//use Illuminate\Http\Request;
//use Illuminate\Http\Response;


class PersonController extends Controller {

    /**
     * Función para que verifique autenticación al ingresar a una página
     *
     * Si se pusiera $this->middleware('auth', ['only' => 'create']); sólo pide login para crear uno nuevo
     * Si se pusiera $this->middleware('auth', ['except' => 'create']); hace lo inverso al punto anterior
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$people=Person::latest('id')->get();
		return view('person.index', compact('people'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('person.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreatePersonRequest $request)
	{
		$input = $request->all();
		$person = new Person;
		$person->fill($input);
		$person->created_by=Auth::id();
		$person->updated_by=Auth::id();
		$person->save();
        return redirect('person/'.$person->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$person=Person::find($id);
		
		if(is_null($person))
        {
			return "404";
		}
		$interactions=$person->interactions()->latest('id')->get();
        $fileentries=$person->fileentries()->latest('id')->limit(10)->get();
		return view('person.show',compact('person','interactions','fileentries'));
	}


    public function photos($id)
    {
        $person=Person::find($id);

        if(is_null($person))
        {
            return "404";
        }
        $interactions=$person->interactions()->latest('id')->get();
        $fileentries=$person->fileentries()->get();
        return view('person.photos',compact('person','interactions','fileentries'));
    }


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$person=Person::find($id);
		if(is_null($person))
        {
			return "404";
		}
		return view('person.edit',compact('person'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreatePersonRequest $request,$id)
	{
		$person = Person::findOrFail($id);
		$tags=array_filter(array_map('trim',explode(",",trim($request->tags))));//Create an array to tags + trim whitespaces
		$person->retag($tags);
		$person->updated_by=Auth::id();
		$person->update($request->all());
		return redirect('person/'.$person->id);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
