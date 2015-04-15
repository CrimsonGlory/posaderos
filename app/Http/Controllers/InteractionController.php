<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateInteractionRequest;
use App\Http\Controllers\Controller;
use App\Person;
use App\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller {

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
		$interaction=Interaction::create($input);
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
		return view('interaction.show',comptact('interaction'));	
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
