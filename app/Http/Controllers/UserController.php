<?php namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user = Auth::user();
        if ($user == null)
        {
            return "404";
        }

        if ($user->can('see-users'))
        {
            $users = User::orderBy('id', 'desc')->paginate(10);
            $paginator = $this->pagination->set($users, $request->getBaseUrl());
            return view('user.index', compact('users', 'paginator'));
        }
		return Redirect::back();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        //En principio los users se crean a sí mismos cuando se registran en el sistema.
        return "404";
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
	$request->replace(array('phone' => parse_phone($request->only('phone'))));
        $input = $request->all();
        $user = new User;
        $user->fill($input);

        if($user->save())
        {
            flash()->success('Usuario creado.');
        }
        else
        {
            flash()->error('Error al intentar crear el usuario.');
        }
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
        $user = Auth::user();
        $userShown = User::find($id);
        if ($user == null || $userShown == null)
        {
            return "404";
        }

        if ($user->can('see-users') || $userShown->id == $user->id)
        {
            $gravatar = Gravatar::get($userShown->email);
            $people = $userShown->people()->latest('id')->limit(10)->get();
            return view('user.show',compact('userShown','gravatar','people'));
        }
		return Redirect::back();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = Auth::user();
        $userShown = User::find($id);
        if ($user == null || $userShown == null)
        {
            return "404";
        }

        if ($user->can('edit-users') || $userShown->id == $user->id)
        {
            $gravatar = Gravatar::get($userShown->email);
            return view('user.edit',compact('userShown','gravatar'));
        }
        return Redirect::back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UserRequest $request,$id)
	{
        $rules = array(
            'name' => array('required', 'min:1'),
            'email' => array('required', 'min:1'),
        );
		$this->validate($request,$rules);

		$user = User::findOrFail($id);
        $newRole = DB::table('roles')->where('name', $request->role)->first();

        $user->name = $request->name;
        $user->email = $request->email;
	$user->phone = parse_phone($request->phone);

        if ($newRole != null)
        {
            $roleKey = (array)$newRole->id;
            $user->roles()->sync($roleKey);
        }
		$user->update();
        
		flash()->success('Usuario actualizado.');
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
