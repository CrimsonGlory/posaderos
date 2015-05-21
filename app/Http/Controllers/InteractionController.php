<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateInteractionRequest;
use App\Http\Controllers\Controller;
use App\Person;
use App\Interaction;
use Illuminate\Http\Request;
use Auth;
use App\Lib\Pagination\Pagination;
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
            return Redirect::back();
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
        if ($user == null)
        {
            return "404";
        }

        if ($user->can('add-interaction'))
        {
            $person = Person::findOrFail($id);
            return view('interaction.create',compact('person'));
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
        $person = Person::find($request->person_id);
        $input = $request->all();
        $interaction = new Interaction;
        $destinationMail = $request->destination;
        $tags = $request->tags;
        $interaction->fill($input);
        $interaction->fixed = 0;
        $interaction->user_id = Auth::id();
        $success = $interaction->save();
        $interaction->retag($tags);

        if ($destinationMail != null && $person != null)
        {
            $data = array('destination' => $destinationMail, 'asistido' => $person->name());
            try
            {
                Mail::send('emails.alert', $data, function($message) use($data)
                {
                    $message->to($data['destination'])->subject('Nueva derivación');
                });
                flash()->success('Se ha enviado un email notificando la derivación del asistido.');
            }
            catch (\Exception $e)
            {
                flash()->error('No se pudo enviar el email notificando la derivación del asistido.')->important();
            }
        }
        else
        {
            if ($success)
            {
                flash()->success('Interacción creada.');
            }
            else
            {
                flash()->error('Error al intentar crear la interacción.');
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
        if ($user == null || $interaction == null)
        {
            return "404";
        }

        if ($user->can('see-all-interactions') || ($user->can('see-new-interactions') && $interaction->user_id == $user->id))
        {
            return redirect('person/'.$interaction->person_id);
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
        $interaction = Interaction::find($id);
        if($user == null || $interaction == null)
        {
            return "404";
        }

        if ($user->can('edit-all-interactions') || ($user->can('edit-new-interactions') && $interaction->user_id == $user->id))
        {
            $person = Person::findOrFail($interaction->person_id);
            return view('interaction.edit',compact('person','interaction'));
        }
        return Redirect::back();
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
        $tags = $request->tags;
        $interaction->text = $request->text;
        $interaction->date = $request->date;
        $interaction->fixed = $request->fixed;
        $interaction->update();
        $interaction->retag($tags);

        flash()->success("Interacción actualizada.");
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
        //
    }

}
