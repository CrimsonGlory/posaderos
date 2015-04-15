<?php namespace App\Http\Controllers;


use App\NeedsArea;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;
use Validator;
use Illuminate\Http\Request;

class NeedsAreaController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$needsArea=NeedsArea::all();
		return view('needsArea.index', compact('needsArea'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('needsArea.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$rules = array(
        'name' => array('required', 'min:4'),
        'description'=> array('required'));
		$this->validate($request,$rules);
		NeedsArea::create(Input::all());
		return redirect('needsArea');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$needsArea=NeedsArea::find($id);
		
		if(is_null($needsArea)){
			return "404";
		}
		return view('needsArea.show',compact('needsArea'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$needsArea=NeedsArea::find($id);
		if(is_null($needsArea)){
			return "404";
		}
		return view('needsArea.edit',compact('needsArea'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		 $rules = array(
        'name' => array('required', 'min:4'),
        'description'=> array('required'));
		$this->validate($request,$rules);
		$needsArea = NeedsArea::findOrFail($id);
		$needsArea->update(Input::all());
		return redirect('needsArea');
        /*$validation = Validator::make(Input::all(), $rules);
        if ($validation->passes())
    	{
			$needsArea = NeedsArea::findOrFail($id);
			$needsArea->update(Input::all());
			return redirect('needsArea');
		}
		else
		{
			return Redirect::to('needsArea/edit')->with_errors($validation);
		}*/

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
