<?php namespace App\Http\Controllers;

use App\User;
use App\Interaction;
use App\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Input;
use DB;

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
        $user = Auth::user();
        if ($user == null)
        {
            return "404";
        }

        if ($user->can('see-people-search-view') || $user->can('see-interactions-search-view') || $user->can('see-users-search-view'))
        {
            return view('search.searchView');
        }
        return Redirect::back();
    }

    public function search()
    {
        $user = Auth::user();
        if ($user == null)
        {
            return "404";
        }

        $data = array('toFind' => Input::get('toFind'),'keyWord' => trim(Input::get('key')),'error' => 1);
        $interactions = NULL;
        $people = NULL;
        $users = NULL;

        if ($data['keyWord'] != '')
        {
            if($data['toFind'] == "Asistidos")
            {
                if ($user->can('see-all-people'))
                {
                    if($data['keyWord'] ==  preg_replace("/[^0-9,.-_ +]/", "", $data['keyWord'])) // phone or dni
                    {
                        $number = preg_replace("/[^0-9]/","",$data['keyWord']);
                        $people = Person::where('dni','LIKE','%'.$number.'%')->
                                          orWhere('phone','=',parse_phone($number))->
                                          orderBy('id','desc')->limit(30)->get();
                    }
                    else // first_name, last_name or address
                    {
                        $people = Person::where(DB::raw('concat_ws(\' \',first_name,last_name)'),'LIKE','%'.$data['keyWord'].'%')->
                                          orWhere('first_name', 'LIKE', '%'.$data['keyWord'].'%')->
                                          orWhere('last_name', 'LIKE', '%'.$data['keyWord'].'%')->
                                          orWhere('address','LIKE','%'.$data['keyWord'].'%')->
                                          orderBy('id', 'desc')->limit(30)->get();
                    }

                }
                else if ($user->can('see-new-people'))
                {
                    if($data['keyWord'] ==  preg_replace("/[^0-9,.-_ +]/", "", $data['keyWord'])) // phone or dni
                    {
                        $number = preg_replace("/[^0-9]/","",$data['keyWord']);
                        $people = Person::where('created_by', $user->id)->
                                          where(function ($query) use($data, $number){
                                              $query->where(DB::raw('concat_ws(\' \',dni)'),'LIKE','%'.$data['keyWord'].'%')->
                                              orWhere('dni','LIKE',$number)->
                                              orWhere('phone','=',parse_phone($number));
                                          })->orderBy('id','desc')->limit(30)->get();
                    }
                    else // first_name, last_name or address
                    {
                        $people = Person::where('created_by', $user->id)->
                                          where(function ($query) use($data){
                                              $query->where(DB::raw('concat_ws(\' \',first_name,last_name)'),'LIKE','%'.$data['keyWord'].'%')->
                                              orWhere('first_name', 'LIKE', '%'.$data['keyWord'].'%')->
                                              orWhere('last_name', 'LIKE', '%'.$data['keyWord'].'%')->
                                              orWhere('address','LIKE','%'.$data['keyWord'].'%');
                                          })->orderBy('id', 'desc')->limit(30)->get();
                    }
                }
                $data['error'] = 0;
            }
            else if($data['toFind'] == "Interacciones")
            {
                if ($user->can('see-all-interactions'))
                {
                    $interactions = Interaction::where('text', 'LIKE', '%'.$data['keyWord'].'%')->orderBy('id', 'desc')->limit(30)->get();
                }
                else if ($user->can('see-new-interactions'))
                {
                    $interactions = Interaction::where('user_id', $user->id)->
                    where('text', 'LIKE', '%'.$data['keyWord'].'%')->
                    orderBy('id', 'desc')->limit(30)->get();
                }
                $data['error'] = 0;
            }
            else if($data['toFind'] == "Usuarios")
            {
                if ($user->can('see-users'))
                {
                    $users = User::where('name', 'LIKE', '%'.$data['keyWord'].'%')->
                    orWhere('email', 'LIKE', '%'.$data['keyWord'].'%')->
                    orderBy('id', 'desc')->limit(30)->get();
                }
                $data['error'] = 0;
            }
        }
        return view('search.resultadoBusqueda', compact('data','people','interactions','users'));
    }

}
