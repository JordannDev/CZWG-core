<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Events\ControllerApplication;
use App\Models\Users\User;
use App\Models\Events\Event;
use App\Models\Events\EventConfirm;
use App\Models\Events\EventUpdate;
use App\Models\AtcTraining\RosterMember;
use App\Models\AtcTraining\VisitRosterMember;
use App\Models\Publications\UploadedImage;
use App\Models\Settings\AuditLogEntry;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventControllerbckup extends Controller
{
    /*
    View all events
    */
    public function index()
    {
        $events = Event::cursor()->filter(function ($event) {
            return !$event->event_in_past();
        })->sortByDesc('start_timestamp');
        $pastEvents = Event::cursor()->filter(function ($event) {
            return $event->event_in_past();
        })->sortByDesc('start_timestamp');
        return view('events.index', compact('events', 'pastEvents'));
    }

    public function test($icao)
    {
        function getBetween($string, $start = "", $end = ""){
            if (strpos($string, $start)) { // required if $start not exist in $string
                $startCharCount = strpos($string, $start) + strlen($start);
                $firstSubStr = substr($string, $startCharCount, strlen($string));
                $endCharCount = strpos($firstSubStr, $end);
                if ($endCharCount == 0) {
                    $endCharCount = strlen($firstSubStr);
                }
                return substr($firstSubStr, 0, $endCharCount);
            } else {
                return '';
            }
        }
            $url = 'https://www.airport-data.com/api/ap_info.json?icao='.$icao;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json = curl_exec($ch);
            $contains = Str::contains(json_decode($json)->name, ['(', ')']);
            if ($contains == true) {
                $code = getBetween(json_decode($json)->name, '(', ')');
            } else {
            $code = json_decode($json)->name;
            }
        curl_close($ch);
        return view('events.test', compact('code'));
    }

    public function viewEvent($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $updates = $event->updates;
        if (Auth::check() && ControllerApplication::where('user_id', Auth::id())->where('event_id', $event->id))
        {
            $app = ControllerApplication::where('user_id', Auth::id())->where('event_id', $event->id)->first();
            return view('events.view', compact('event', 'updates', 'app'));
        }
        return view('events.view', compact('event', 'updates'));
    }


    public function controllerApplicationAjaxSubmit(Request $request)
    {
        $this->validate($request, [
            'availability_start' => 'required',
            'availability_end' => 'required'
        ]);
        $application = new ControllerApplication([
            'user_id' => Auth::id(),
            'event_id' => $request->get('event_id'),
            'start_availability_timestamp' => $request->get('availability_start'),
            'end_availability_timestamp' => $request->get('availability_end'),
            'position' => $request->get('position'),
            'comments' => $request->get('comments'),
            'submission_timestamp' => date('Y-m-d H:i:s'),
            'event_name' => $request->get('event_name'),
            'event_date' => $request->get('event_date')
        ]);
        $application->save();
        $webhook = $application->discord_webhook();
        if (!$webhook) {
            AuditLogEntry::insert(Auth::user(), 'Webhook failed', Auth::user(), 0);
        }
        return redirect()->back()->with('success', 'Submitted!');
    }

    public function viewApplications($id)
    {

      $event = Event::where('id', $id)->firstOrFail();
      $applications = $event->controllerApplications;

      return view('admin.events.applications', compact('applications', 'event'));
    }

    public function confirmController(Request $request, $id)
    {
      $this->validate($request, [
          'start_timestamp' => 'required',
          'end_timestamp' => 'required',
          'position' => 'required'
      ]);
      $event = Event::where('id', $id)->firstorFail();
      $controllerconfirm = EventConfirm::create([
          'event_id' => $request->input('event_id'),
          'event_name' => $request->input('event_name'),
          'event_date' => $request->input('event_date'),
          'user_cid' => $request->input('user_cid'),
          'user_name' => $request->input('user_name'),
          'start_timestamp' => $request->input('start_timestamp'),
          'end_timestamp' => $request->input('end_timestamp'),
          'position' => $request->input('position'),
      ]);
      $applications = ControllerApplication::where('user_id', $request->input('user_cid'))->firstorFail();
      $applications->delete();

      return redirect()->route('events.admin.view', $event->slug)->with('success', 'Controller Confirmed for Event!');
    }

    public function addController(Request $request, $id)
    {
      $this->validate($request, [
          'start_timestamp' => 'required',
          'end_timestamp' => 'required',
          'position' => 'required'
      ]);
      $event = Event::where('id', $id)->firstorFail();
      $user = User::where('id', $request->input('newcontroller'))->first();
      $controllerconfirm = EventConfirm::create([
          'event_id' => $request->input('event_id'),
          'event_name' => $request->input('event_name'),
          'event_date' => $request->input('event_date'),
          'user_cid' => $request->input('newcontroller'),
          'user_name' => $user->fullName('FL'),
          'start_timestamp' => $request->input('start_timestamp'),
          'end_timestamp' => $request->input('end_timestamp'),
          'position' => $request->input('position'),
      ]);

      return redirect()->route('events.admin.view', $event->slug)->with('success', 'Controller Confirmed for Event!');
    }

    public function deleteController(Request $request, $cid)
    {
      $controller = EventConfirm::where([
        ['user_cid', $cid],
        ['event_id', $request->input('id')]
      ])->firstorFail();
      $controller->delete();

      return redirect()->back()->with('success', 'Controller has been removed from the event!');
}

    public function adminIndex()
    {
        $events = Event::all()->sortByDesc('created_at');
        return view('admin.events.index', compact('events'));
    }
    public function adminViewEvent($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $applications = $event->controllerApplications;
        $updates = $event->updates;
        $eventroster = EventConfirm::where('event_id', $event->id)->get();
        $users = User::all();
      return view('admin.events.view', compact('event', 'applications', 'updates', 'eventroster', 'users'));
    }
    public function adminCreateEvent()
    {
        return view('admin.events.create');
    }
    public function adminCreateEventPost(Request $request)
    {
        //Define validator messages
        $messages = [
            'name.required' => 'A name is required.',
            'name.max' => 'A name may not be more than 100 characters long.',
            'image.mimes' => 'An image file must be in the jpg png or gif formats.',
            'description.required' => 'A description is required.',
        ];
        //Validate
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'image' => 'mimes:jpeg,jpg,png,gif',
            'description' => 'required',
            'start' => 'required',
            'end' => 'required'

        ], $messages);
        //Redirect if fails
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'createEventErrors');
        }
        //Create event object
        $event = new Event();
        //Assign name
        $event->name = $request->get('name');
        //Assign start/end date/time
        $event->start_timestamp = $request->get('start');
        $event->end_timestamp = $request->get('end');
        //Assign description
        $event->description = $request->get('description');
        //Assign user
        $event->user_id = Auth::id();
        //Upload image if it exists
        if ($request->file('image')) {
            $basePath = 'public/files/'.Carbon::now()->toDateString().'/'.rand(1000,2000);
            $path = $request->file('image')->store($basePath);
            $event->image_url = Storage::url($path);
        }
        //Create slug
        $event->slug = Str::slug($request->get('name').'-'.Carbon::now()->toDateString());
        //Assign departure icao and arrival icao if they exist
        if ($request->get('departure_icao') && $request->get('arrival_icao')) {
            $event->departure_icao = $request->get('departure_icao');
            $event->arrival_icao = $request->get('arrival_icao');
        }
        //If controller apps are open then lets make them open
        if ($request->has('openControllerApps')) {
            $event->controller_applications_open = true;
        }
        //Save it
        $event->save();
        //Redirect
        return redirect()->route('events.admin.view', $event->slug)->with('success', 'Event created!');
    }
    public function adminDeleteEvent($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $updates = EventUpdate::where('event_id', $event->id);
        $updates->delete();
        $event->delete();
        return redirect()->route('events.admin.index')->with('info', 'Event deleted.');
    }

    public function adminEditEventPost(Request $request, $event_slug)
    {
        //Define validator messages
        $messages = [
            'name.required' => 'A name is required.',
            'name.max' => 'A name may not be more than 100 characters long.',
            'image.mimes' => 'An image file must be in the jpg png or gif formats.',
            'description.required' => 'A description is required.',
        ];

        //Validate
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'image' => 'mimes:jpeg,jpg,png,gif',
            'description' => 'required',
            'start' => 'required',
            'end' => 'required'
        ], $messages);

        //Redirect if fails
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'editEventErrors');
        }

        //Get event object
        $event = Event::where('slug', $event_slug)->firstOrFail();

        //Assign name
        $event->name = $request->get('name');

        //Assign start/end date/time
        $event->start_timestamp = $request->get('start');
        $event->end_timestamp = $request->get('end');

        //Assign description
        $event->description = $request->get('description');

        //Upload image if it exists
        if ($request->file('image')) {
            $basePath = 'public/files/'.Carbon::now()->toDateString().'/'.rand(1000,2000);
            $path = $request->file('image')->store($basePath);
            $event->image_url = Storage::url($path);

            //Add to uploaded images
            $uploadedImg = new UploadedImage();
            $uploadedImg->path = Storage::url($path);
            $uploadedImg->user_id = Auth::id();
            $uploadedImg->save();
        }

        //If there is a uplaoded image selected lets put it on there
        if ($request->get('uploadedImage')) {
            $event->image_url = UploadedImage::whereId($request->get('uploadedImage'))->first()->path;
        }

        //Assign departure icao and arrival icao if they exist
        if ($request->get('departure_icao') && $request->get('arrival_icao')) {
            $event->departure_icao = $request->get('departure_icao');
            $event->arrival_icao = $request->get('arrival_icao');
        }

        //If controller apps are open then lets make them open
        if ($request->has('openControllerApps')) {
            $event->controller_applications_open = true;
        }

        //Save it
        $event->save();

        //Audit it
        AuditLogEntry::insert(Auth::user(), 'Edited event '.$event->name, User::find(1), 0);

        //Redirect
        return redirect()->route('events.admin.view', $event->slug)->with('success', 'Event edited!');
    }

    public function adminCreateUpdatePost(Request $request, $event_slug)
    {
        //Define validator messages
        $messages = [
            'updateTitle.required' => 'A title is required.',
            'updateTitle.max' => 'A title may not be more than 100 characters long.',
            'updateContent.required' => 'Content is required.',
        ];

        //Validate
        $validator = Validator::make($request->all(), [
            'updateTitle' => 'required|max:100',
            'updateContent' => 'required'
        ], $messages);

        //Redirect if fails
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'createUpdateErrors');
        }

        //Create update object
        $update = new EventUpdate([
            'event_id' => Event::where('slug', $event_slug)->firstOrFail()->id,
            'user_id' => Auth::id(),
            'title' => $request->get('updateTitle'),
            'content' => $request->get('updateContent'),
            'created_timestamp' => Carbon::now(),
            'slug' => Str::slug($request->get('updateTitle').'-'.Carbon::now()->toDateString()),
        ]);

        //Save it
        $update->save();

        //Redirect
        return redirect()->route('events.admin.view', $event_slug)->with('success', 'Update created!');
    }

    public function adminDeleteControllerApp($event_slug, $cid)
    {
        //Find the controller app
        $app = ControllerApplication::where('user_id', $cid)->where('event_id', Event::where('slug', $event_slug)->firstOrFail()->id)->FirstOrFail();

        //Delete it? Delete it!
        $app->delete();

        //Redirect
        return redirect()->route('events.admin.view', $event_slug)->with('info', 'Controller application from '.$app->user_id. ' has been deleted!');
    }

    public function adminDeleteUpdate($event_slug, $update_id)
    {
        //Find the update
        $update = EventUpdate::whereId($update_id)->where('event_id', Event::where('slug', $event_slug)->firstOrFail()->id)->FirstOrFail();

        //Delete it? Delete it!
        $update->delete();

        //Redirect
        return redirect()->route('events.admin.view', $event_slug)->with('info', 'Update \''.$update->title. '\' has been deleted!');
    }
}
