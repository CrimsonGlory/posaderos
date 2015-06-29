<?php namespace App\Http\Controllers;
use Artisan;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\DB;

class SetupController extends Controller {

	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest');
    }

	public function index(Request $request)
    {
        if (schema_already_setup() && User::count() != 0)
        {
            abort(404);
        }

        if(!schema_already_setup())
        {
            return view('setup.schema');
        }

        if(User::count() == 0)
        {
            return view('setup.create_admin');
        }
    }

    public function schema(Request $request)
    {
        if(schema_already_setup())
        {
            abort(404);
        }
        Artisan::call('migrate');
        return view('setup.schema_created');
    }

    public function createAdmin()
    {
        if(User::count() == 0)
        {
            return view('setup.create_admin');
        }
        else
        {
            abort(404);
        }
    }

    public function admin(Request $request)
    {
        if(schema_already_setup() && User::count() != 0)
        {
            abort(404);

        }
        //Create user
        $validator = $this->registrar->validator($request->all());
        if($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $this->auth->login($this->registrar->create($request->all()));

        if(DB::table('roles')->where('name','admin')->count() == 0)
        {
            create_roles_and_permissions();
        }

        //Add admin role
        $authUser = Auth::user();
        $roleNewUser = DB::table('roles')->where('name', 'admin')->first();
        if (!is_null($authUser) && !is_null($roleNewUser))
        {
            $authUser->attachRole($roleNewUser->id);
        }

        //Create admin
        return redirect("/home");
    }

}
