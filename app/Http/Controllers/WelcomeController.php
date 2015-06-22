<?php namespace App\Http\Controllers;

class SetupController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
    {
        if($this->setup_done())
        {
            abort(404);
        }
        else
        {
            return view('setup.show');
        }

    }

    private function setup_done()
    {
        return false;
    }

}
