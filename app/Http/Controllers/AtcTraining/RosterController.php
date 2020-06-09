<?php

namespace App\Http\Controllers\AtcTraining;

use App\Http\Controllers\Controller;
use App\Models\Settings\AuditLogEntry;
use App\Models\AtcTraining\LegacyUser;
use App\Mail\RosterStatusMail;
use App\Models\AtcTraining\RosterMember;
use App\Models\Network\SessionLog;
use App\Models\AtcTraining\VisitRosterMember;
use App\Models\Users\User;
use App\Models\Users\UserNotification;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;


class RosterController extends Controller
{
    public function showPublic()
    {
        $roster = RosterMember::all();
        $visitroster = VisitRosterMember::all();


        return view('roster', compact('roster', 'visitroster'));
    }


    public function index()
    {
        $roster = RosterMember::all();
        $visitroster = VisitRosterMember::all();
        $users = User::all();




        return view('dashboard.roster.index', compact('roster', 'visitroster', 'users'));
    }

    public function deleteController($id)
    {
      $roster = RosterMember::findorFail($id);
      $session = SessionLog::where('roster_member_id', $id);
        $session->delete();
        $roster->delete();

  return redirect('/dashboard/roster')->withSuccess('Successfully deleted from roster!');
    }

    public function deletevisitController($id)
    {
      $roster = VisitRosterMember::findorFail($id);

      $roster->delete();

      return redirect('/dashboard/roster')->withSuccess('Successfully deleted from roster!');
    }
    public function addController(Request $request)
    {
        //here we are getting the data from the table
        $users = User::findOrFail($request->input('newcontroller'));
        $roster = RosterMember::create([
            'cid' => $users->id,
            'user_id' => $users->id,
            'full_name' => $users->fullName('FL'),
            'rating' => $users->rating_short,
        ]);

      return redirect('/dashboard/roster')->withSuccess('Successfully added '.$users->fullName('FL').' CID: '.$users->id.' to roster!');
        }

        public function addVisitController(Request $request)
        {


            //here we are getting the data from the table
            $users = User::findOrFail($request->input('newcontroller'));
            $visitroster = VisitRosterMember::create([
                'cid' => $users->id,
                'user_id' => $users->id,
                'full_name' => $users->fullName('FL'),
                'rating' => $users->rating_short,
                'homefir' => $request->input('homefir'),
            ]);

          return redirect('/dashboard/roster')->withSuccess('Successfully added '.$users->fullName('FL').' CID: '.$users->id.' to roster!');
            }

          public function editControllerForm($cid)
            {
              $roster = RosterMember::where('cid', $cid)->first();
              if ($roster === null) {
              $roster = VisitRosterMember::where('cid', $cid)->first();
            }


              return view('dashboard.roster.edituser', compact('roster'))->with('cid',$cid);
                }

                public function editController(Request $request,$cid)
                  {

                    $roster = RosterMember::where('cid', $cid)->first();
                    if($roster != null) {
                    $roster->del = $request->input('del');
                    $roster->gnd = $request->input('gnd');
                    $roster->twr = $request->input('twr');
                    $roster->dep = $request->input('dep');
                    $roster->app = $request->input('app');
                    $roster->ctr = $request->input('ctr');
                    $roster->remarks = $request->input('remarks');
                    $roster->active = $request->input('active');
                    $roster->save();
    }
                    $visitroster = VisitRosterMember::where('cid', $cid)->first();
                    if($visitroster != null) {
                    $visitroster->del = $request->input('del');
                    $visitroster->gnd = $request->input('gnd');
                    $visitroster->twr = $request->input('twr');
                    $visitroster->dep = $request->input('dep');
                    $visitroster->app = $request->input('app');
                    $visitroster->ctr = $request->input('ctr');
                    $visitroster->remarks = $request->input('remarks');
                    $visitroster->active = $request->input('active');
                    $visitroster->homefir = $request->input('homefir');
                    $visitroster->save();

                  }


              return redirect('/dashboard/roster')->withSuccess('Successfully edited user!');
            }


}
