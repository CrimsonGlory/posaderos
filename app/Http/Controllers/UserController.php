<?php namespace App\Http\Controllers;

use App\Interaction;
use App\Person;
use App\User;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Input;
use PhpParser\Node\Expr\Array_;
use Validator;
use Illuminate\Http\Request;
use Gravatar;
use App\Lib\Pagination\Pagination;
use Conner\Tagging\Tag;

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
        if (is_null($user))
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
        if (is_null($user) || is_null($userShown))
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
        if (is_null($user) || is_null($userShown))
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
	public function update(UserRequest $request, $id)
	{
        $rules = array(
            'name' => array('required', 'min:1'),
            'email' => array('required', 'min:1'),
        );
		$this->validate($request,$rules);

		$user = User::findOrFail($id);
        $tags = $request->tags;
        $newRole = DB::table('roles')->where('name', $request->role)->first();
        $user->name = $request->name;
        $user->email = $request->email;
	    $user->phone = parse_phone($request->phone);
        if (!is_null($newRole))
        {
            $roleKey = (array)$newRole->id;
            $user->roles()->sync($roleKey);
        }
		$user->update();
        if (!is_null($tags) && allowed_to_tag(Auth::user(),$tags))
        {
            $user->retag(str_replace('#','',$tags));
        }
        else
        {
            $user->untag();
        }

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

    public function favorites($id, \Symfony\Component\HttpFoundation\Request $request)
    {
        $user = Auth::user();
        $userShown = User::find($id);
        if (is_null($user) || is_null($userShown))
        {
            return "404";
        }

        if ($userShown->id == $user->id)
        {
            $people = Person::whereLiked($userShown->id)->orderBy('id', 'desc')->paginate(10);
            $paginator = $this->pagination->set($people, $request->getBaseUrl());
            return view('user.favorites', compact('userShown','people','paginator'));
        }
        return Redirect::back();
    }

    public function derivations($id, \Symfony\Component\HttpFoundation\Request $request)
    {
        $user = Auth::user();
        $userShown = User::find($id);
        if (is_null($user) || is_null($userShown))
        {
            return "404";
        }

        if ($userShown->id == $user->id && ($userShown->hasRole('admin') || $userShown->hasRole('posadero') || $userShown->hasRole('explorer')))
        {
            if ($userShown->hasRole('admin'))
            {
                $interactions = Interaction::where('fixed', '=', 0)->orderBy('id', 'desc')->paginate(10);
            }
            else
            {
                $interactions = Interaction::withAnyTag($userShown->tagNames())->where('fixed', '=', 0)->orderBy('id', 'desc')->paginate(10);
            }
            $paginator = $this->pagination->set($interactions, $request->getBaseUrl());
            return view('derivations', compact('userShown','interactions','paginator'));
        }
        return Redirect::back();
    }

}
