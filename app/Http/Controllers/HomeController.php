<?php namespace App\Http\Controllers;

use App\User;
use App\Interaction;
use App\Person;
use Auth;
use App\Lib\Pagination\Pagination;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller {

    private $pagination;

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Pagination $pagination)
	{
        $this->middleware('auth');
        $this->middleware('check.setup', ['only' => ['index']]);
        $this->pagination = $pagination;
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $user = Auth::user();
        if(is_null($user))
        {
            abort(404);
        }

        if ($user->hasRole('admin'))
        {
            $people = Person::orderBy('id', 'desc')->paginate(10);
            $interactions = Interaction::orderBy('id', 'desc')->paginate(10);
            return view('home', compact('user','people','interactions'));
        }
        else if ($user->hasRole('posadero'))
        {
            $userShown = $user;
            $interactions = Interaction::withAnyTag($user->tagNames())->where('fixed', '=', 0)->orderBy('id', 'desc')->paginate(10);
            $paginator = $this->pagination->set($interactions, $request->getBaseUrl());
            return view('derivations', compact('userShown','interactions','paginator'));
        }
        else if ($user->hasRole('explorer') || $user->hasRole('new-user'))
        {
            return view('search/searchView');
        }
        abort(403);
	}

}
