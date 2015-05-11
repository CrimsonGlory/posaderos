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
		$interactions = Interaction::orderBy('id', 'desc')->paginate(10);
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
		$person = Person::findOrFail($id);
		
		return view('interaction.create',compact('person'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateInteractionRequest $request)
	{
        $mailError = 0; // En PersonController@show se pasa como parámetro para utilizar en la view

        $destinationMail = $request->destination;
        $asistido = Person::find($request->person_id);
        if ($destinationMail != null && $asistido != null)
        {
            $data = array('destination' => $destinationMail, 'asistido' => $asistido->name());
            try
            {
                Mail::send('emails.alert', $data, function($message) use($data)
                {
                    $message->to($data['destination'])->subject('Nueva derivación');
                });
            }
            catch (\Exception $e)
            {
                $mailError = 1;
            }
        }

		$input = $request->all();
		$interaction=new Interaction;
		$interaction->fill($input);
		$interaction->user_id=Auth::id();
		$interaction->save();

		flash()->success("Interacción creada.");
		return redirect('person/'.$interaction->person_id)->with('mailError', $mailError);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$interaction = Interaction::find($id);
		if(is_null($interaction)){
			return "404";
		}
		return redirect('person/'.$interaction->person_id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$interaction = Interaction::find($id);
        $person = Person::findOrFail($interaction->person_id);
		if(is_null($interaction)){
			return "404";
		}
		return view('interaction.edit',compact('person','interaction'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CreateInteractionRequest $request,$id)
	{
		$interaction = Interaction::findorFail($id);
		$interaction->update($request->all());
		$tags=array_filter(array_map('trim',explode(",",trim($request->tags))));//Create an array to tags + trim whitespaces
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
