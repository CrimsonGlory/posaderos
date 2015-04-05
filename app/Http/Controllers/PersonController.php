<?php namespace App\Http\Controllers;

use App\Person;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$people=Person::all();
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
	public function store()
	{
		$input = Request::all();
		$person=Person::create($input);
		return redirect('person');
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
		
		if(is_null($person)){
			return "404";
		}
		return view('person.show',compact('person'));
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
		if(is_null($person)){
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
	public function update($id)
	{
		$person = Person::findOrFail($id);
		$person->update($request->all());
		return redirect('person');

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
