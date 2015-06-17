<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateInteractionRequest;
use App\Http\Controllers\Controller;
use App\Person;
use App\Interaction;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Lib\Pagination\Pagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class InteractionController extends Controller {

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
	    $this->middleware('cleanfields',['only' => ['store','update']]);
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
            abort(404);
        }

        $interactions = null;
        if ($user->can('see-all-interactions'))
        {
            $interactions = Interaction::orderBy('id', 'desc')->paginate(10);
        }
        else if ($user->can('see-new-interactions'))
        {
            $interactions = Interaction::orderBy('id', 'desc')->where('user_id', $user->id)->paginate(10);
        }
        else
        {
            abort(403);
        }

        $paginator = $this->pagination->set($interactions, $request->getBaseUrl());
        return view('interaction.index',compact('interactions', 'paginator'));
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
            abort(404);
        }

        if ($user->can('add-interaction'))
        {
            $person = Person::findOrFail($id);
            return view('interaction.create',compact('person'));
        }
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateInteractionRequest $request)
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

        $person = Person::find($request->person_id);
        $interaction = new Interaction;
        $destinationMail = $request->destination;
        $input = $request->all();
        $interaction->fill($input);
        $interaction->user_id = Auth::id();
        $success = $interaction->save();

        $seEnviaronMails = false;
        if (!is_null($tags))
        {
            $interaction->retag($tags);
        }

        // El usuario puede elegir un correo electrónico para enviar el mail de derivación
        if ($destinationMail != '' && !is_null($person))
        {
            $seEnviaronMails = true;
            try
            {
                sendMail($destinationMail,$person);
                flash()->success(trans('messages.mailSuccess'));
            }
            catch (\Exception $e)
            {
                flash()->error(trans('messages.mailFailed'))->important();
            }
        }

        // Si hay tags se envian mails a todos los usuarios que tengan alguno de los tags seleccionados
        if (!is_null($tags) && allowed_to_tag(Auth::user(),$tags) && !$interaction->fixed && !$seEnviaronMails)
        {
            $users = User::withAnyTag($tags)->get();
            if ($users != null && count($users) > 0)
            {
                $seEnviaronMails = true;
                try
                {
                    sendMailToUsers($users,$person);
                    flash()->success(trans('messages.mailsSuccess'));
                }
                catch (\Exception $e)
                {
                    flash()->error(trans('messages.mailsFailed'))->important();
                }
            }

        }

        if (!$seEnviaronMails)
        {
            if ($success)
            {
                flash()->success(trans('messages.interactionCreated'));
            }
            else
            {
                flash()->error(trans('messages.interactionFailed'));
            }
        }

        return redirect('person/'.$interaction->person_id);
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
        $interaction = Interaction::find($id);
        if (is_null($user) || is_null($interaction))
        {
            abort(404);
        }

        if ($user->can('see-all-interactions') || ($user->can('see-new-interactions') && $interaction->user_id == $user->id))
        {
            return redirect('person/'.$interaction->person_id);
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
        $interaction = Interaction::find($id);
        if(is_null($user) || is_null($interaction))
        {
            abort(404);
        }

        if ($user->can('edit-all-interactions') || ($user->can('edit-new-interactions') && $interaction->user_id == $user->id))
        {
            $person = Person::findOrFail($interaction->person_id);
            return view('interaction.edit',compact('person','interaction'));
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(CreateInteractionRequest $request, $id)
    {
        $interaction = Interaction::findorFail($id);

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
        $interaction->fill($input);
        $interaction->update();

        if (!is_null($tags) && allowed_to_tag(Auth::user(),$tags))
        {
            $interaction->retag($tags);
        }
        else
        {
            $interaction->untag();
        }

        flash()->success(trans('messages.interactionUpdated'));
        return redirect('person/'.$interaction->person_id);
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
        $interaction = Interaction::find($id);
        if (is_null($user) || is_null($interaction))
        {
            abort(404);
        }

        if ($user->hasRole('admin'))
        {
            $interaction->delete();
            flash()->success(trans('messages.interactionDeleted'));
        }
        abort(403);
    }

}
