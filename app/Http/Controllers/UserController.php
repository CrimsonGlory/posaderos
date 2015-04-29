<?php namespace App\Http\Controllers;

use App\User;
use App\Interaction;
use App\Person;
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
	public function searchView()
	{
		return view('user.searchView');
	}
	public function search() //pasar a otro controlador?
	{
		$data = array('toFind' => Input::get('toFind'),'keyWord' => Input::get('key'),'error' =>1);
		//$contents = View::make('user.resultadoBusqueda',$data)->render();
		//return "dsfds";
		$interactions = NULL;
		$persons = NULL;
		$users = NULL;
		if($data['toFind'] == "Interaccion")
		{
			$interactions = Interaction::where('text', 'LIKE', '%'.$data['keyWord'].'%')->get();
			//$interactions = Interaction::all();
			$data['error'] = 0;
		}
		else if($data['toFind'] == "Persona")
		{
			//$persons = Person::all();
			$persons = Person::where('first_name', 'LIKE', '%'.$data['keyWord'].'%')->
			orWhere('last_name', 'LIKE', '%'.$data['keyWord'].'%')->get();
			$data['error'] = 0;
		}
		else if($data['toFind'] == "Usuario")
		{
			//$users = User::all();
			$users = User::where('name', 'LIKE', '%'.$data['keyWord'].'%')->
			orWhere('email', 'LIKE', '%'.$data['keyWord'].'%')->get();
			$data['error'] = 0;
		}
		return view('user.resultadoBusqueda',compact('data','interactions','persons','users'));		
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
		$gravatar=Gravatar::get($user->email);
		return view('user.edit',compact('user','gravatar'));
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
        'email' => array('required', 'min:1'),
        );
		$this->validate($request,$rules);
		$user = User::findOrFail($id);
		$user->update(Input::all());
		return redirect('user/'.$id);
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
