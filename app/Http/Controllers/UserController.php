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
	public function home($id)
	{
		$user=User::find($id);
		$interactions = Interaction::paginate(10);
		$persons = Person::paginate(10);
		//$datos = array('user' => $user, 'interactions' => $interactions,'persons' => $persons);
		if(is_null($user)){
			return "404";
		}
		return view('user.home',compact('user','interactions','persons'));
	}
	public function searchView($id)
	{
		$user=User::find($id);
		$datos = array('user' => $user);
		return view('user.searchView',compact('datos'));
	}
	public function search()
	{
		$data = array('toFind' => Input::get('toFind'),'keyWord' => Input::get('key'),'error' =>1);
		//$contents = View::make('user.resultadoBusqueda',$data)->render();
		//return "dsfds";
		$interactions = NULL;
		$persons = NULL;
		$users = NULL;
		if($data['toFind'] == "Interaccion")
		{
			//$results = Interaction::where('text', '=', '%'.$data['keyWord'].'%')->get();
			$interactions = Interaction::all();
			$data['error'] = 0;
		}
		else if($data['toFind'] == "Persona")
		{
			$persons = Person::all();
			$data['error'] = 0;
		}
		else if($data['toFind'] == "Usuario")
		{
			$users = User::all();
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
		return view('user.show',compact('user'));
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
