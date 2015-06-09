<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateInteractionRequest;
use App\Http\Controllers\Controller;
use App\Person;
use App\Interaction;
use App\User;
use Conner\Tagging\Tag;
use Conner\Tagging\TaggingUtil;
use Illuminate\Http\Request;
use \Conner\Tagging\TaggableTrait;
use Conner\Tagging\Tagged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Lib\Pagination\Pagination;

class TagController extends Controller {

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

        if ($user->can('see-tags'))
        {
            $tags = Tag::groupBy('name')->paginate(10);
            $paginator = $this->pagination->set($tags, $request->getBaseUrl());
            return view('tag.index',compact('tags','paginator'));
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
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->hasRole('admin'))
        {
            return view('tag.addTag');
        }
        return Redirect::back();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $rules = array(
            'tag' => array('required'),
        );
        $this->validate($request,$rules);

        $tagName = removeAccents(strtr(trim($request->tag), array(' ' => '-')));
        if (!preg_match('/^[a-zA-Z0-9-]+$/i', $tagName))
        {
            return Redirect::back()->withErrors(trans('messages.tagCharacterError'));
        }

        $tag = array('name' => $tagName);
        Tag::create($tag);

        flash()->success(trans('messages.tagCreated'));
        return redirect('tag');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($tagName)
	{
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->can('see-tags'))
        {
            $people = null;
            $interactions = null;

            if ($user->can('see-all-people'))
            {
                $people = Person::withAnyTag($tagName)->latest('id')->limit(10)->get();
            }
            else if ($user->can('see-new-people'))
            {
                $people = Person::withAnyTag($tagName)->where('created_by', $user->id)->latest('id')->limit(10)->get();
            }

            if ($user->can('see-all-interactions'))
            {
                $interactions = Interaction::withAnyTag($tagName)->latest('id')->limit(10)->get();
            }
            else if ($user->can('see-new-interactions'))
            {
                $interactions = Interaction::withAnyTag($tagName)->where('user_id', $user->id)->latest('id')->limit(10)->get();
            }

            return view('tag.show',compact('tagName','people','interactions'));
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
        $tag = Tag::find($id);
        if (is_null($user) || is_null($tag))
        {
            return "404";
        }

        if ($user->hasRole('admin'))
        {
            return view('tag.editTag', compact('tag'));
        }
        return Redirect::back();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
        $tagToDelete = Tag::findOrFail($id);
        $rules = array(
            'tag' => array('required'),
        );
        $this->validate($request,$rules);

        $tagName = removeAccents(strtr(trim($request->tag), array(' ' => '-')));
        if (!preg_match('/^[a-zA-Z0-9-]+$/i', $tagName))
        {
            return Redirect::back()->withErrors(trans('messages.tagCharacterError'));
        }

        $oldTag = array(strtolower($tagToDelete->name));
        $newTag = array(strtolower($tagName));

        if ($oldTag != $newTag)
        {
            $people = Person::withAnyTag($oldTag)->get();
            foreach ($people as $person)
            {
                $tagNames = $person->tagSlugs();
                $person->retag(array_merge(array_diff($tagNames, $oldTag),$newTag));
            }

            $interactions = Interaction::withAnyTag($oldTag)->get();
            foreach ($interactions as $interaction)
            {
                $tagNames = $interaction->tagSlugs();
                $interaction->retag(array_merge(array_diff($tagNames, $oldTag),$newTag));
            }

            $users = User::withAnyTag($oldTag)->get();
            foreach ($users as $user)
            {
                $tagNames = $user->tagSlugs();
                $user->retag(array_merge(array_diff($tagNames, $oldTag),$newTag));
            }
            $tagToDelete->delete();
        }

        flash()->success(trans('messages.tagUpdated'));
        return redirect('tag');
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
        $tag = Tag::find($id);
        if (is_null($user) || is_null($tag))
        {
            return "404";
        }

        if ($user->hasRole('admin'))
        {
            $tagName = array(strtolower($tag->name));

            $people = Person::withAnyTag($tag->name)->get();
            foreach ($people as $person)
            {
                $tagNames = $person->tagSlugs();
                $person->untag();
                $person->retag(array_diff($tagNames, $tagName));
            }

            $interactions = Interaction::withAnyTag($tag->name)->get();
            foreach ($interactions as $interaction)
            {
                $tagNames = $interaction->tagSlugs();
                $interaction->retag(array_diff($tagNames, $tagName));
            }

            $users = User::withAnyTag($tag->name)->get();
            foreach ($users as $user)
            {
                $tagNames = $user->tagSlugs();
                $user->retag(array_diff($tagNames, $tagName));
            }

            $tag->delete();
            flash()->success(trans('messages.tagDeleted'));
            return redirect('tag');
        }

        return Redirect::back();
	}

}
