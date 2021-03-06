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
use App\FileEntry;

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
            abort(404);
        }

        $peopleCount = 0;
        $people = null;
        if ($user->can('see-all-people') && !$user->hasRole('new-user'))
        {
            $peopleCount = Person::count();
            $people = Person::orderBy('id', 'desc')->paginate(10);
        }
        else if ($user->can('see-new-people'))
        {
            $peopleCount = Person::where('created_by', $user->id)->count();
            $people = Person::orderBy('id', 'desc')->where('created_by', $user->id)->paginate(10);
        }
        else
        {
            abort(403);
        }

        $paginator = $this->pagination->set($people, $request->getBaseUrl());
		return view('person.index', compact('people', 'paginator','peopleCount'));
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
            abort(404);
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
        abort(403);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreatePersonRequest $request)
	{
        $tagNames = $request->tags;
        $tags = array();
        if ($tagNames != null)
        {
            foreach ($tagNames as $tagName)
            {
                $tagName = removeAccents(strtr(trim($tagName), array(' ' => '-')));
                if (!preg_match('/^[a-zA-Z0-9-]+$/i', $tagName))
                {
                    return Redirect::back()->withErrors(trans('messages.tagCharacterError'));
                }
                array_push($tags, $tagName);
            }
        }

        $person = new Person;
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
			flash()->success(trans('messages.personCreated'));
		}
		else
        {
			flash()->error(trans('messages.personFailed'));
		}
        return redirect('person/'.$person->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, Request $request)
	{
        $user = Auth::user();
        $person = Person::find($id);
        if (is_null($user) || is_null($person))
        {
            abort(404);
        }

        $interactions = null;
        if ($user->can('see-all-people') || ($user->can('see-new-people') && $person->created_by == $user->id))
        {
            if ($user->can('see-all-interactions'))
            {
                $interactions = $person->interactions()->latest('id')->paginate(10);
            }
            else if ($user->can('see-new-interactions'))
            {
                $interactions = $person->interactions()->where('user_id', $user->id)->latest('id')->paginate(10);
            }
            $paginator = $this->pagination->set($interactions, $request->getBaseUrl());

            $images_counter = $person->fileentries()->image()->count();
	        $builder = $person->fileentries()->orderBy('id', 'desc')->notImage();
            if (!$user->can('see-not-image-files'))
            {
                $builder = $builder->where('uploader_id', $user->id);
            }
            $files = $builder->get();
            return view('person.show',compact('person','interactions','images_counter','files','paginator'));
        }
        abort(403);
	}

    public function photos($id)
    {
        $user = Auth::user();
        $person = Person::find($id);
        if (is_null($user) || is_null($person))
        {
            abort(404);
        }

        if ($user->can('see-all-people') || ($user->can('see-new-people') && $person->created_by == $user->id))
        {
            $images = $person->fileentries()->image()->get();
            return view('person.photos',compact('person','images'));
        }
        abort(403);
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
            abort(404);
        }

        if ($user->can('edit-all-people') || ($user->can('edit-new-people') && $person->created_by == $user->id))
        {
            return view('person.edit',compact('person'));
        }
        abort(403);
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

        $tagNames = $request->tags;
        $tags = array();
        if ($tagNames != null)
        {
            foreach ($tagNames as $tagName)
            {
                $tagName = removeAccents(strtr(trim($tagName), array(' ' => '-')));
                if (!preg_match('/^[a-zA-Z0-9-]+$/i', $tagName))
                {
                    return Redirect::back()->withErrors(trans('messages.tagCharacterError'));
                }
                array_push($tags,$tagName);
            }
        }

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

        flash()->success(trans('messages.personUpdated'));
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
            abort(404);
        }

        if ($user->hasRole('admin'))
        {
            foreach ($person->interactions()->get() as $interaction)
            {
                $interaction->delete();
            }
            $person->delete();
            flash()->success(trans('messages.personDeleted'));
            return redirect('person');
        }
        abort(403);
	}

	public function setAvatar(Request2 $request,$id)
    {
        $input = $request->all();
		$image=FileEntry::findOrFail($input["fileentry_id"]);
		$person=Person::findOrFail($id);
		$image->avatar_of()->save($person);
		return redirect('person/'.$id);
	}

    public function addFavorite($id)
    {
        $user = Auth::user();
        $person = Person::find($id);
        if (is_null($user) || is_null($person))
        {
            abort(404);
        }

        if (($user->can('see-all-people') || ($user->can('see-new-people') && $person->created_by == $user->id)))
        {
            $person->like($user->id);
            flash()->success(trans('messages.favoriteAdded'));
            return redirect('person/'.$person->id);
        }
        abort(403);
    }

    public function removeFavorite($id)
    {
        $user = Auth::user();
        $person = Person::find($id);
        if (is_null($user) || is_null($person))
        {
            abort(404);
        }

        if ($user->can('see-all-people') || ($user->can('see-new-people') && $person->created_by == $user->id))
        {
            $person->unlike($user->id);
            flash()->warning(trans('messages.favoriteRemoved'));
            return redirect('person/'.$person->id);
        }
        abort(403);
    }

}
