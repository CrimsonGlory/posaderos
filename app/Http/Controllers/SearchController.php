<?php namespace App\Http\Controllers;

use App\User;
use App\Interaction;
use App\Person;
use Input;

class SearchController extends Controller {

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

    public function searchView()
    {
        return view('search.searchView');
    }

    public function search()
    {
        $data = array('toFind' => Input::get('toFind'),'keyWord' => Input::get('key'),'error' => 1);

        $interactions = NULL;
        $persons = NULL;
        $users = NULL;

        if($data['toFind'] == "Asistidos")
        {
            $persons = Person::where('first_name', 'LIKE', '%'.$data['keyWord'].'%')->
                               orWhere('last_name', 'LIKE', '%'.$data['keyWord'].'%')->get();
            $data['error'] = 0;
        }
        else if($data['toFind'] == "Interacciones")
        {
            $interactions = Interaction::where('text', 'LIKE', '%'.$data['keyWord'].'%')->get();
            $data['error'] = 0;
        }
        else if($data['toFind'] == "Usuarios")
        {
            $users = User::where('name', 'LIKE', '%'.$data['keyWord'].'%')->
                          orWhere('email', 'LIKE', '%'.$data['keyWord'].'%')->get();
            $data['error'] = 0;
        }
        return view('search.resultadoBusqueda', compact('data','persons','interactions','users'));
    }

}
