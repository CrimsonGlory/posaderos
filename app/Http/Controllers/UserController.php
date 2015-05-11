<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Input;
use Validator;
use Illuminate\Http\Request;
use Gravatar;
use App\Lib\Pagination\Pagination;

class UserController extends Controller {

    private $pagination;

    /**
     * Función para que verifique autenticación al ingresar a una página
     *
     * Si se pusiera $this->middleware('auth', ['only' => 'create']); sólo pide login para crear uno nuevo
     * Si se pusiera $this->middleware('auth', ['except' => 'create']); hace lo inverso al punto anterior
     */
    public function __construct(Pagination $pagination)
    {
        $this->middleware('auth');
        $this->pagination = $pagination;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(\Symfony\Component\HttpFoundation\Request $request)
	{
		$users=User::orderBy('id', 'desc')->paginate(10);
        $paginator = $this->pagination->set($users, $request->getBaseUrl());
		return view('user.index', compact('users', 'paginator'));
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
		$user = User::find($id);
        $gravatar = Gravatar::get($user->email);
        $people = $user->people()->latest('id')->limit(10)->get();
		if(is_null($user)){
			return "404";
		}
		return view('user.show',compact('user','gravatar','people'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		if(is_null($user)){
			return "404";
		}
		$gravatar = Gravatar::get($user->email);
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

		flash()->success("Usuario actualizado.");
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
