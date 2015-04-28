<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateInteractionRequest;
use App\Http\Controllers\Controller;
use App\Person;
use App\Interaction;
use Illuminate\Http\Request;
use Auth;
class InteractionController extends Controller {

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
		$interactions=Interaction::latest('id')->get();
		return view('interaction.index',compact('interactions'));	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$person=Person::findOrFail($id);
		
		return view('interaction.create',compact('person'));	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateInteractionRequest $request)
	{
		$input = $request->all();
		$interaction=new Interaction;
		$interaction->fill($input);
		$interaction->user_id=Auth::id();
		$interaction->save();
		return redirect('person/'.$interaction->person_id);	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$interaction=Interaction::find($id);
		if(is_null($interaction)){
			return "404";
		}
		return view('interaction.show',compact('interaction'));	
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$interaction=Interaction::find($id);
		if(is_null($interaction)){
			return "404";
		}
		return view('interaction.edit',compact('interaction'));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateInteractionRequest $request,$id)
	{
		$interaction=Interaction::findorFail($id);
		$interaction->update($request->all());
		$tags=array_filter(array_map('trim',explode(",",trim($request->tags))));//Create an array to tags + trim whitespaces
                $interaction->retag($tags);
		return redirect('person/'.$interaction->person_id);	
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
