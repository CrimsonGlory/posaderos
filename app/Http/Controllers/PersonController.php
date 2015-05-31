<?php namespace App\Http\Controllers;

use App\Person;
use App\Http\Requests;
use App\Http\Requests\CreatePersonRequest;
use App\Http\Controllers\Controller;
use Auth;
use App\Lib\Pagination\Pagination;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Http\Request as Request2;

class PersonController extends Controller {

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
	    $this->middleware('cleanfields', ['only' => ['update', 'store']]);
        $this->pagination = $pagination;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
    {
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        $people = null;
        if ($user->can('see-all-people'))
        {
            $people = Person::orderBy('id', 'desc')->paginate(10);
        }
        else if ($user->can('see-new-people'))
        {
            $people = Person::orderBy('id', 'desc')->where('created_by', $user->id)->paginate(10);
        }
        else
        {
            return Redirect::back();
        }

        $paginator = $this->pagination->set($people, $request->getBaseUrl());
		return view('person.index', compact('people', 'paginator'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->can('add-person'))
        {
            $firstName = null;
            $dni = null;
            if ($_REQUEST != null)
            {
                $param = $_REQUEST['param'];
                if ($param == preg_replace('/[^0-9,.\-_ +]/', '', $param))
                {
                    $dni = strtr($param, array(' ' => '', ',' => '', '.' => '', '-' => '', '_' => '', '+' => ''));
                }
                else
                {
                    $firstName = $param;
                }
            }
            return view('person.create', compact('firstName','dni'));
        }
        return Redirect::back();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreatePersonRequest $request)
	{
        $person = new Person;
        $tags = $request->tags;
        $input = $request->all();
        $person->fill($input);
        $request->replace(array('phone' => parse_phone($request->only('phone'))));
        $person->phone = $request->phone;
        $person->created_by = Auth::id();
        $person->updated_by = Auth::id();
        $success = $person->save();
        if (!is_null($tags) && allowed_to_tag(Auth::user(),$tags))
        {
            $person->retag($tags);
        }

		if($success)
        {
			flash()->success('Asistido creado.');
		}
		else
        {
			flash()->error('Error al intentar crear el asistido.');
		}
        return redirect('person/'.$person->id);
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
        $person = Person::find($id);
        if (is_null($user) || is_null($person))
        {
            return "404";
        }

        $interactions = null;
        if ($user->can('see-all-people') || ($user->can('see-new-people') && $person->created_by == $user->id))
        {
            if ($user->can('see-all-interactions'))
            {
                $interactions = $person->interactions()->latest('id')->limit(10)->get();
            }
            else if ($user->can('see-new-interactions'))
            {
                $interactions = $person->interactions()->where('user_id', $user->id)->latest('id')->limit(10)->get();
            }
            $fileentries = $person->fileentries()->latest('id')->limit(10)->get();
            return view('person.show',compact('person','interactions','fileentries'));
        }
        return Redirect::back();
	}


    public function photos($id)
    {
        $user = Auth::user();
        $person = Person::find($id);
        if (is_null($user) || is_null($person))
        {
            return "404";
        }

        if ($user->can('see-all-people') || ($user->can('see-new-people') && $person->created_by == $user->id))
        {
            $fileentries = $person->fileentries()->get();
            return view('person.photos',compact('person','fileentries'));
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
        $person = Person::find($id);
        if (is_null($user) || is_null($person))
        {
            return "404";
        }

        if ($user->can('edit-all-people') || ($user->can('edit-new-people') && $person->created_by == $user->id))
        {
            return view('person.edit',compact('person'));
        }
        return Redirect::back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreatePersonRequest $request, $id)
	{
		$person = Person::findOrFail($id);
        $tags = $request->tags;
        $input = $request->all();
        $person->fill($input);
        $request->replace(array('phone' => parse_phone($request->only('phone'))));
        $person->phone = $request->phone;
        $person->updated_by = Auth::id();
        $person->update();
        if (!is_null($tags) && allowed_to_tag(Auth::user(),$tags))
        {
            $person->retag($tags);
        }
        else
        {
            $person->untag();
        }

        flash()->success('Asistido actualizado.');
		return redirect('person/'.$person->id);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $user = Auth::user();
        $person = Person::find($id);
        if (is_null($user) || is_null($person))
        {
            return "404";
        }

        if ($user->hasRole('admin'))
        {
            foreach ($person->interactions()->get() as $interaction)
            {
                $interaction->delete();
            }
            $person->delete();
            flash()->success('Asistido eliminado.');
            return redirect('person');
        }
        return Redirect::back();
	}

	public function setAvatar(Request2 $request,$id)
    {
		$input = $request->all();
		return $input;
		$image=FileEntry::findOrFail($input->fileentry_id);
		$person=Person::findOrFail($id);
		$image->avatar_of()->save($person);
		return redirect('person/'.$input->person_id);
	}

    public function addFavorite($id)
    {
        $user = Auth::user();
        $person = Person::find($id);
        if (is_null($user) || is_null($person) || Session::token() != csrf_token())
        {
            return "404";
        }

        if (($user->can('see-all-people') || ($user->can('see-new-people') && $person->created_by == $user->id)))
        {
            $person->like($user->id);
            flash()->success('Se agregó el asistido a su lista de favoritos.');
        }
        return Redirect::back();
    }

    public function removeFavorite($id)
    {
        $user = Auth::user();
        $person = Person::find($id);
        if (is_null($user) || is_null($person) || Session::token() != csrf_token())
        {
            return "404";
        }

        if ($user->can('see-all-people') || ($user->can('see-new-people') && $person->created_by == $user->id))
        {
            $person->unlike($user->id);
            flash()->warning('Se quitó el asistido de su lista de favoritos.');
        }
        return Redirect::back();
    }

}

