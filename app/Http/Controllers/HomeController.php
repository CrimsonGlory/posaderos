<?php namespace App\Http\Controllers;
use App\User;
use App\Interaction;
use App\Person;
//use App\Http\Requests;
//use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Redirect;
//use Input;
//use Validator;
//use Illuminate\Http\Request;
use Gravatar;
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
       		$user=User::find(Auth::id());
                $interactions = Interaction::latest()->paginate(10);
                $persons = Person::latest()->paginate(10);
		$gravatar=Gravatar::get($user->email);
                if(is_null($user)){
                        return "404";
                }
                return view('user.userHome',compact('user','interactions','persons','gravatar'));
        
	}

}
