<?php

namespace App\Http\Controllers\AtcTraining;

use App\Http\Controllers\Controller;
use App\Models\AtcTraining\Application;
use App\Models\Settings\AuditLogEntry;
use App\Models\Settings\CoreSettings;
use App\Models\AtcTraining\InstructingSession;
use App\Models\AtcTraining\Instructor;
use App\Mail\ApplicationAcceptedStaffEmail;
use App\Mail\ApplicationAcceptedUserEmail;
use App\Mail\ApplicationDeniedUserEmail;
use App\Mail\ApplicationStartedStaffEmail;
use App\Mail\ApplicationStartedUserEmail;
use App\Mail\ApplicationWithdrawnEmail;
use App\Models\AtcTraining\RosterMember;
use App\Models\AtcTraining\Student;
use App\Models\AtcTraining\InstructorStudents;
use App\Models\Users\User;
use App\Models\Users\UserNotification;
use Auth;
use Calendar;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Mail;

class TrainingController extends Controller
{
public function assignStudent(Request $request)
{
  $fullnameuser = User::findOrFail($request->input('student_id'));
  $fullnameinstructor = User::findorFail($request->input('instructor_id'));
  $assignstudent = InstructorStudents::create([
      'student_id' => $request->input('student_id'),
      'student_name' => $fullnameuser->fullName('FL'),
      'instructor_id' => $request->input('instructor_id'),
      'instructor_name' => $fullnameinstructor->fullName('FL'),
      'instructor_email' => User::where('id', $request->input('instructor_id'))->firstOrFail()->email,
      'assigned_by' => Auth::id(),
  ]);

return redirect('/dashboard')->withSuccess('Successfully paired Student!');
}

public function deleteStudent($id)
{
  $student = InstructorStudents::where('student_id', $id)->first();
  if ($student === null) {
    return redirect('/dashboard')->withError('CID '.$id.' does not exist as a student!');
  }
  else
  $student->delete();

  return redirect('/dashboard')->withSuccess('Deleted Student!');
}
}
