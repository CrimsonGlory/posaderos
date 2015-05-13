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
        $user = User::find(Auth::id());
        if(is_null($user))
        {
            return "404";
        }

        if ($user->hasRole('admin'))
        {
            $interactions = Interaction::latest()->paginate(10);
            $persons = Person::latest()->paginate(10);
            return view('home', compact('user', 'interactions', 'persons'));
        }
        else if ($user->hasRole('new-user'))
        {
            return view('search/searchView'); // En el futuro debería ser return view('home/homeNewUser');
        }

        return "404";
	}

}
