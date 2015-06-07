<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateInteractionRequest;
use App\Http\Controllers\Controller;
use App\Person;
use App\Interaction;
use Illuminate\Http\Request;
use \Conner\Tagging\TaggableTrait;
use Conner\Tagging\Tagged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TagController extends Controller {

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
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->can('see-tags'))
        {
            $tags = Tagged::all()->groupBy('tag_slug')->keys()->toArray();
            return view('tag.index',compact('tags'));
        }
		return Redirect::back();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->can('add-tag'))
        {
            return "TagController@create pending";
        }
	    return Redirect::back();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateInteractionRequest $request)
	{
	    return "TagController@store pending";
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($name)
	{
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        $people = null;
        $interactions = null;
        if ($user->can('see-all-people'))
        {
            $people = Person::withAnyTag($name)->latest('id')->limit(10)->get();
        }
        else if ($user->can('see-new-people'))
        {
            $people = Person::withAnyTag($name)->where('created_by', $user->id)->latest('id')->limit(10)->get();
        }

        if ($user->can('see-all-interactions'))
        {
            $interactions = Interaction::withAnyTag($name)->latest('id')->limit(10)->get();
        }
        else if ($user->can('see-new-interactions'))
        {
            $interactions = Interaction::withAnyTag($name)->where('user_id', $user->id)->latest('id')->limit(10)->get();
        }

        if ($user->can('see-tags'))
        {
            return view('tag.show',compact('people','interactions','name'));
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
        if (is_null($user))
        {
            return "404";
        }

        if ($user->can('edit-tags'))
        {
            return "TagController@edit pending";
        }
		return Redirect::back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateInteractionRequest $request,$id)
	{
		return "TagController@update pending";
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
