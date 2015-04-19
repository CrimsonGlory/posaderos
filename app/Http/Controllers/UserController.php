<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;
use Validator;
use Illuminate\Http\Request;
use Gravatar;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users=User::all();
		return view('user.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('user.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$rules = array(
        'name' => array('required', 'min:1')
        );
		$this->validate($request,$rules);
		User::create(Input::all());
		return redirect('user');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user=User::find($id);
		
		if(is_null($user)){
			return "404";
		}
		$gravatar=Gravatar::get($user->email);
		return view('user.show',compact('user','gravatar'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user=User::find($id);
		if(is_null($user)){
			return "404";
		}
		return view('user.edit',compact('user'));
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
        'name' => array('required', 'min:1'),
        );
		$this->validate($request,$rules);
		$user = User::findOrFail($id);
		$user->update(Input::all());
		return redirect('user');
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
