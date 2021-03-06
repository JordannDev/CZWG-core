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
        $roster = RosterMember::where('visit', '0')->get();
        $visitroster = RosterMember::where('visit', '1')->get();


        return view('roster', compact('roster', 'visitroster'));
    }


    public function index()
    {
        $roster = RosterMember::where('visit', '0')->get();
        $visitroster2 = RosterMember::where('visit', '1')->get();
        $users = User::all();




        return view('dashboard.roster.index', compact('roster', 'visitroster2', 'users'));
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
      $roster = RosterMember::findorFail($id);
      $session = SessionLog::where('roster_member_id', $id);
        $session->delete();
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
            'visit' => '0',
        ]);

      return redirect('/dashboard/roster')->withSuccess('Successfully added '.$users->fullName('FL').' CID: '.$users->id.' to roster!');
        }

        public function addVisitController(Request $request)
        {


            //here we are getting the data from the table
            $users = User::findOrFail($request->input('newcontroller'));
            $visitroster = RosterMember::create([
                'cid' => $users->id,
                'user_id' => $users->id,
                'full_name' => $users->fullName('FL'),
                'rating' => $users->rating_short,
                'home_fir' => $request->input('homefir'),
                'visit' => '1',
            ]);

          return redirect('/dashboard/roster')->withSuccess('Successfully added '.$users->fullName('FL').' CID: '.$users->id.' to roster!');
            }

          public function editControllerForm($cid)
            {
              $roster = RosterMember::where('cid', $cid)->first();


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
                    if ($request->input('rating_hours') == "true") {
                        $roster->rating_hours = 0;
                    }
                    $roster->active = $request->input('active');
                    $roster->save();
    }


              return redirect('/dashboard/roster')->withSuccess('Successfully edited!');
            }


}
