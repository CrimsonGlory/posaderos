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
        if (is_null($user))
        {
            abort(404);
        }

        if ($user->can('see-people-search-view') || $user->can('see-interactions-search-view') || $user->can('see-users-search-view'))
        {
            return view('search.searchView');
        }
        abort(403);
    }

    public function search()
    {
        $user = Auth::user();
        if (is_null($user))
        {
            abort(404);
        }

        $data = array('toFind' => Input::get('toFind'),'keyWord' => trim(Input::get('key')),'error' => trans('messages.searchErrorNumber'));
        $q = $data['keyWord'];
        $tags = $this->get_tags_from_query($q);
        $q = $this->clean_tags($q);
        $interactions = NULL;
        $people = NULL;
        $users = NULL;

        if ($q == '' && count($tags) == 0)
        {
            return view('search.searchResults', compact('data','people','interactions','users'));
        }

        if ($q != '' && $q == preg_replace('/[^0-9,.\-_ +]/', '', $q)) //phone or dni
        {
            $number = preg_replace('/[^0-9]/','',$q);
        }

        switch($data['toFind'])
        {
            case "Asistidos":
                if ($user->can('see-new-people'))
                {
                    if(isset($number))
                    {
                        $builder = Person::where('dni','LIKE', "%$number%")->
                        orWhere('phone','=',parse_phone($number));
                    }
                    else // first_name, last_name or address
                    {
                        $builder = Person::whereNested(function($sql) use($q){
                            $sql->where(DB::raw('concat_ws(\' \',first_name,last_name)'),'LIKE',"%$q%");
                            $sql->orWhere('first_name', 'LIKE',"%$q%");
                            $sql->orWhere('last_name', 'LIKE',"%$q%");
                            $sql->orWhere('address','LIKE',"%$q%");
                        });
                    }
                    if (!$user->can('see-all-people'))
                        $builder = $builder->where('created_by',$user->id);
                }
                break;

            case "Interacciones":
                if ($user->can('see-new-interactions'))
                {
                    $builder = Interaction::where('text', 'LIKE', "%$q%");
                    if (!$user->can('see-all-interactions')) //if the user can't see all people
                    {
                        $builder = $builder->where('user_id', $user->id);
                    }
                }
                break;

            case "Usuarios":
                if ($user->can('see-users'))
                {
                    $builder = User::where('name', 'LIKE', "%$q%")->
                    orWhere('email', 'LIKE', "%$q%");
                }
                break;
            default:
                break;
        }

        if(count($tags) > 0)
        {
            $builder = $builder->withAllTags($tags);
        }

        $results = $builder->orderBy('id','desc')->get();

        if(count($results) > trans('messages.maxSearchResults'))
        {
            $data['error'] = trans('messages.maxSearchResultsNumber');
            return view('search.searchResults', compact('data'));
        }
        else if($results)
        {
            $data['error'] = trans('messages.noErrorNumber');
        }

        switch($data['toFind'])
        {
            case trans('messages.people'):
                $people = $results;
                break;
            case trans('messages.interactions'):
                $interactions = $results;
                break;
            case trans('messages.users'):
                $users = $results;
                break;
        }
        return view('search.searchResults', compact('data','people','interactions','users'));
    }

    /* Funciones privadas */

    private function get_tags_from_query($query)
    {
        if(preg_match_all('/#\S+/',$query,$tags))
        {
            return str_replace('#','',$tags[0]);
        }
        return NULL;
    }

    private function clean_tags($input)
    {
        $tmp = preg_replace('/#\S+/','',$input); // saco los tags
        return trim(preg_replace('/\s+/',' ',$tmp));// saco los espacios que quedaron de más
    }

}
