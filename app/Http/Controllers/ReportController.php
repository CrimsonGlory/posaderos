<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\Request;
use App\Interaction;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ReportController extends Controller {

    public function peopleBetweenDays()
    {
        $user = Auth::user();
        if (is_null($user))
        {
            return "404";
        }

        if ($user->hasRole('admin'))
        {
            return view('report.peopleBetweenDays');
        }
        Redirect::back();
    }

    public function downloadPeopleBetweenDays(CreateReportRequest $request)
    {
        $rules = array(
            'fromDate' => array('required', 'date'),
            'toDate' => array('required', 'date'),
        );
        $this->validate($request,$rules);

        // Campos
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        $users = $request->users;
        $fixed = $request->fixed;
        $tags = $request->tags;

        $builder = Interaction::where('date', '>=', $fromDate)->where('date', '<=', $toDate);

        // Filtros
        if (count($users) > 0)
        {
            $builder = $builder->whereIn('user_id', $users);
        }
        if ($fixed != -1)
        {
            $builder = $builder->where('fixed', $fixed);
        }
        if (count($tags) > 0)
        {
            $builder = $builder->withAnyTag($tags);
        }

        $interactions = $builder->orderBy('id','desc')->get();
        $fromDate = date("d/m/Y", strtotime($fromDate));
        $toDate = date("d/m/Y", strtotime($toDate));

        $pdf = PDF::loadView('report.peopleBetweenDaysPDF', array(), compact('interactions', 'users', 'fromDate','toDate'))->setPaper('A4')->setOrientation('landscape');
        return $pdf->download('InteraccionesConAsistidos.pdf');
    }

}

