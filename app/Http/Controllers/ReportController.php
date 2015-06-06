<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\Request;
use App\Interaction;
use App\Person;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Facades\Agent;

class ReportController extends Controller {

    public function peopleList()
    {
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->hasRole('admin') && Agent::isDesktop())
        {
            return view('report.peopleList');
        }
        return redirect('home');
    }

    public function downloadPeopleList(CreateReportRequest $request)
    {
        $rules = array(
            'fromDate' => array('required', 'date'),
            'toDate' => array('required', 'date'),
        );
        $this->validate($request,$rules);

        // Campos
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $gender = $request->gender;
        $users = $request->users;
        $tags = $request->tags;
        $exportTypes = $request->exportTypes;

        $builder = Person::where('created_at', '>=', $request->fromDate." 00:00:00")->where('created_at', '<=', $request->toDate." 23:59:59");

        // Filtros
        if ($gender != 'select')
        {
            $builder = $builder->where('gender', $gender);
        }
        if (count($users) > 0)
        {
            $builder = $builder->whereIn('created_by', $users);
        }
        if (count($tags) > 0)
        {
            $builder = $builder->withAnyTag($tags);
        }

        $people = $builder->orderBy('id','desc')->get();

        if ($exportTypes == 'pdf')
        {
            $fromDate = date("d/m/Y", strtotime($fromDate));
            $toDate = date("d/m/Y", strtotime($toDate));

            $pdf = PDF::loadView('report.peopleListPDF', array(), compact('people', 'gender', 'users', 'tags', 'fromDate','toDate'))->setPaper('A4')->setOrientation('landscape');
            return $pdf->download(trans('messages.peopleReportName').'.pdf');
        }
        else if ($exportTypes == 'csv')
        {
            return downloadPeopleCSVFile($people);
        }
        return view('report.peopleList');
    }

    public function interactionsList()
    {
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->hasRole('admin') && Agent::isDesktop())
        {
            return view('report.interactionsList');
        }
        return redirect('home');
    }

    public function downloadInteractionsList(CreateReportRequest $request)
    {
        $rules = array(
            'fromDate' => array('required', 'date'),
            'toDate' => array('required', 'date'),
        );
        $this->validate($request,$rules);

        // Campos
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $people = $request->people;
        $users = $request->users;
        $fixed = $request->fixed;
        $tags = $request->tags;
        $exportTypes = $request->exportTypes;

        $builder = Interaction::where('date', '>=', $request->fromDate." 00:00:00")->where('date', '<=', $request->toDate." 23:59:59");

        // Filtros
        if ($fixed != -1)
        {
            $builder = $builder->where('fixed', $fixed);
        }
        if (count($people) > 0)
        {
            $builder = $builder->whereIn('person_id', $people);
        }
        if (count($users) > 0)
        {
            $builder = $builder->whereIn('user_id', $users);
        }
        if (count($tags) > 0)
        {
            $builder = $builder->withAnyTag($tags);
        }

        $interactions = $builder->orderBy('id','desc')->get();

        if ($exportTypes == 'pdf')
        {
            $fromDate = date("d/m/Y", strtotime($fromDate));
            $toDate = date("d/m/Y", strtotime($toDate));

            $pdf = PDF::loadView('report.interactionsListPDF', array(), compact('interactions', 'fixed', 'people', 'users', 'tags', 'fromDate','toDate'))->setPaper('A4')->setOrientation('landscape');
            return $pdf->download(trans('messages.interactionsReportName').'.pdf');
        }
        else if ($exportTypes == 'csv')
        {
            return downloadInteractionsCSVFile($interactions);
        }
        return view('report.interactionsList');
    }

    public function usersList()
    {
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->hasRole('admin') && Agent::isDesktop())
        {
            return view('report.usersList');
        }
        return redirect('home');
    }

    public function downloadUsersList(CreateReportRequest $request)
    {
        $rules = array(
            'fromDate' => array('required', 'date'),
            'toDate' => array('required', 'date'),
        );
        $this->validate($request,$rules);

        // Campos
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $role = $request->role;
        $tags = $request->tags;
        $exportTypes = $request->exportTypes;

        $builder = User::where('created_at', '>=', $request->fromDate." 00:00:00")->where('created_at', '<=', $request->toDate." 23:59:59");

        // Filtros
        if ($role != 'select')
        {
            $builder = $builder->whereHas('roles', function($q) use($role){
                                     $q->where('name', $role);
                                 });
        }
        if (count($tags) > 0)
        {
            $builder = $builder->withAnyTag($tags);
        }

        $users = $builder->orderBy('id','desc')->get();

        if ($exportTypes == 'pdf')
        {
            $fromDate = date("d/m/Y", strtotime($fromDate));
            $toDate = date("d/m/Y", strtotime($toDate));

            $pdf = PDF::loadView('report.usersListPDF', array(), compact('users', 'role', 'tags', 'fromDate','toDate'))->setPaper('A4')->setOrientation('landscape');
            return $pdf->download(trans('messages.usersReportName').'.pdf');
        }
        else if ($exportTypes == 'csv')
        {
            return downloadUsersCSVFile($users);
        }
        return view('report.usersList');
    }

}
