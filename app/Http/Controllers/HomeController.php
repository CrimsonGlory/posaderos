<?php namespace App\Http\Controllers;

use App\User;
use App\Interaction;
use App\Person;
use Auth;

class HomeController extends Controller {

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
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $user = Auth::user();
        if(is_null($user))
        {
            return "404";
        }

        if ($user->hasRole('admin') || $user->hasRole('posadero'))
        {
            $people = null;
            $interactions = null;
            if ($user->can('see-all-people'))
            {
                $people = Person::orderBy('id', 'desc')->paginate(10);
            }
            else if ($user->can('see-new-people'))
            {
                $people = Person::orderBy('id', 'desc')->where('created_by', $user->id)->paginate(10);
            }

            if ($user->can('see-all-interactions'))
            {
                $interactions = Interaction::orderBy('id', 'desc')->paginate(10);
            }
            else if ($user->can('see-new-interactions'))
            {
                $interactions = Interaction::orderBy('id', 'desc')->where('user_id', $user->id)->paginate(10);
            }

            return view('home', compact('user','people','interactions'));
        }
        else if ($user->hasRole('explorer') || $user->hasRole('new-user'))
        {
            return view('search/searchView');
        }

        return "404";
	}

}
