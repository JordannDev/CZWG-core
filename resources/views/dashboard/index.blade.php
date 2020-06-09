@extends('layouts.master')
@section('content')
<div class="card card-image rounded-0" style="background-image: url(/storage/cdn/radar.png); background-size: cover; background-position-y: center;">
    <div class="text-white text-left rgba-stylish-strong py-3 px-4">
        <div class="container">
            <div class="py-5">
                <h1 class="h1 my-4 py-2" style="font-size: 3em;">
                    <?php
                    function randomArrayVar($array)
                    {
                        if (!is_array($array)){
                            return $array;
                        }
                        return $array[array_rand($array)];
                    }

                    //list of grettings as arary

                    $greeting= array(
                        "aloha"=>"Aloha",
                        "ahoy"=>"Ahoy",
                        "bonjour"=>"Bonjour",
                        "gday"=>"G'day",
                        "hello"=>"Hello",
                        "hey"=>"Hey",
                        "hi"=>"Hi",
                        "hola"=>"Hola",
                        "howdy"=>"Howdy");

                    //echo greeting
                    echo (randomArrayVar($greeting));
                    ?>
                    {{Auth::user()->fullName('F')}}!
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="container py-4">
    <h1 data-step="1" data-intro="Welcome to the CZWG Dashboard! This is your central hub for all things Winnipeg. Here you can interact with our FIR, and manage your account." class="blue-text font-weight-bold">Dashboard</h1>
    <br class="my-2">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3 class="font-weight-bold blue-text pb-2">ATC Resources</h3>
                    <div class="list-group" style="border-radius: 0.5em !important">
                        @foreach($atcResources as $resource)
                        @if($resource->atc_only && Auth::user()->permissions < 1)
                            @continue
                        @else
                        <a href="{{$resource->url}}" target="_new" class="list-group-item list-group-item-action">
                            {{$resource->title}}
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <br>
            <div data-step="2" data-intro="Here is where you manage and view the data we store on you and your CZWG profile." class="card ">
                <div class="card-body">
                    <h3 class="font-weight-bold blue-text pb-2">Your Account</h3>
                    <div class="row">
                        <div class="col" data-step="3" data-intro="Here is an overview of your profile, including your CZWG roles. You can change the way your name is displayed by clicking on your name, at the top of the panel. (CoC A4(b))">
                            <h5 class="card-title">
                                <a href="" data-toggle="modal" data-target="#changeDisplayNameModal" class="text-dark text-decoration-underline">
                                    {{ Auth::user()->fullName('FLC') }}
                                </a>
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                {{Auth::user()->rating_GRP}} ({{Auth::user()->rating_short}})
                            </h6>
                            Role: {{Auth::user()->permissions()}}<br/>
                            @if(Auth::user()->staffProfile)
                            Staff Role: {{Auth::user()->staffProfile->position}}
                            @endif
                            <br/>
                            <div data-step="4" data-intro="Here you can link your Discord account to receive reminders for training sessions, and gain access to the CZWG Discord.">
                            <h5 class="mt-2">Discord</h5>
                            @if (!Auth::user()->hasDiscord())
                            <p class="mt-1">You don't have a linked Discord account.</p>
                            <a href="#" data-toggle="modal" data-target="#discordModal" class="mt-1">Link a Discord account</a>
                            @else
                            <p class="mt-1"><img style="border-radius:50%; height: 30px;" class="img-fluid" src="{{Auth::user()->getDiscordAvatar()}}" alt="">&nbsp;&nbsp;{{Auth::user()->getDiscordUser()->username}}<span style="color: #d1d1d1;">#{{Auth::user()->getDiscordUser()->discriminator}}</span></p>
                            @if(!Auth::user()->memberOfCZWGGuild())
                            <a href="#" data-toggle="modal" data-target="#joinDiscordServerModal" class="mt-1">Join The CZWG Discord</a><br/>
                            @endif
                            <a href="#" data-toggle="modal" data-target="#discordModal" class="mt-1">Unlink</a>
                            @endif
                            </div>

                        </div>
                        <div data-step="5" data-intro="You can change your avatar here. Your avatar is available when people view your account. This will likely only be staff members, unless you sign up for an event or similar activity." class="col">
                            <h5 class="card-title">Avatar</h5>
                            <div class="text-center">
                                <img src="{{Auth::user()->avatar()}}" style="width: 125px; height: 125px; margin-bottom: 10px; border-radius: 50%;">
                            </div>
                            <br/>
                            <center><a role="button" data-toggle="modal" data-target="#changeAvatar" class="btn btn-sm btn-outline-info"  href="#">Change</a></center>
                            @if (!Auth::user()->isAvatarDefault())
                                <center><a role="button" class="btn btn-sm btn-outline-danger"  href="{{route('users.resetavatar')}}">Reset</a></center>
                            @endif
                        </div>
                    </div>
                    <ul class="list-unstyled mt-2 mb-0">
                        <li class="mb-2">
                            <a href="" data-target="#viewBio" data-toggle="modal" style="text-decoration:none;">
                                <span class="blue-text">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                                &nbsp;
                                <span class="black-text">
                                    View your biography
                                </span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('me.preferences')}}" style="text-decoration:none;">
                                <span class="blue-text">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                                &nbsp;
                                <span class="black-text">
                                    Manage preferences
                                </span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('me.data')}}" style="text-decoration:none;">
                                <span class="blue-text">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                                &nbsp;
                                <span class="black-text">
                                    Manage your data
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <br/>
            @if (Auth::user()->permissions >= 1)


            <div class="card">
                <div class="card-body">
                    <h3 class="font-weight-bold blue-text pb-2">Events You Signed Up For</h3>
                    <div class="list-group">
                    @if (count($unconfirmedapp) < 1)
                        You have not applied to any Events yet (or you have been confirmed)!
                        <br>
                    @else
                    @foreach ($unconfirmedapp as $uapp)
                    @if ((substr($uapp->event_date, 5, 2)) == 01)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on January {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 02)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on February {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 03)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on March {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 04)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on April {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 05)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on May {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 06)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on June {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 07)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on July {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == '08')
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on August {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == '09')
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on September {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 10)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on October {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 11)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on November {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @elseif ((substr($uapp->event_date, 5, 2)) == 12)
                    <br>  <h5>  <b>{{$uapp->event_name}}</b> starts at {{substr($uapp->event_date, 11, 5)}}z on December {{substr($uapp->event_date, 8, 2)}}, {{substr($uapp->event_date, 0, 4)}}</h5>
                    @endif
                              <li>
                              <b>Time Available:</b> {{$uapp->start_availability_timestamp}}z - {{$uapp->end_availability_timestamp}}z <b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Position Requested:</b> {{$uapp->position}}
                            </li>


                            @endforeach
                            @endif






<br><br>
<h3 class="font-weight-bold blue-text pb-2">Confirmed Events</h3>

            @if (count($confirmedapp) < 1)
              You do not have any confirmed events!
                <br>
            @else
                @foreach ($confirmedevent as $cevent)
                    @if ((substr($cevent->start_timestamp, 5, 2)) == 01)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on January {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 02)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on February {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 03)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on March {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 04)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on April {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 05)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on May {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 06)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on June {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 07)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on July {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == '08')
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on August {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == '09')
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on September {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 10)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on October {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 11)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on November {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @elseif ((substr($cevent->start_timestamp, 5, 2)) == 12)
                    <br>  <h5>  <b>{{$cevent->name}}</b> starts at {{substr($cevent->start_timestamp, 11, 5)}}z on December {{substr($cevent->start_timestamp, 8, 2)}}, {{substr($cevent->start_timestamp, 0, 4)}}</h5>
                    @endif
                @foreach ($confirmedapp as $capp)

                  @if ($cevent->name == $capp->event_name)
                  <li>
                     <b> Position:</b> {{$capp->position}} from {{$capp->start_timestamp}}z - {{$capp->end_timestamp}}z
                  </li>

                  @endif
                  @endforeach
                  @if ($cevent->name != $capp->event_name)

                  You are not confirmed to control in this event!
                  <br>
                  @endif



                  @endforeach
                @endif
<br>
                </div>
            </div></div>

            <br/>
                @endif
                @if(Auth::user()->permissions >= 3)
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold blue-text pb-2">Instructor Panel</h3>
                        @if(Auth::user()->permissions >= 4)
                        <a href="" data-toggle="modal" data-target="#newStudent">Add new student</a>
                        @endif
                        <ul class="list-unstyled mt-2 mb-0">

                        </ul>
                    </div>
                </div>

        </div>
          @endif
        <div class="col">
            <div class="card" data-step="7" data-intro="Here you can view your certification status within CZWG.">
                <div class="card-body">
                    <h3 class="font-weight-bold blue-text pb-2">Certification and Training</h3>
                      @if(Auth::user()->permissions >= 1)
                    <h5 class="card-title">Status</h5>
                    <div class="card-text">
                        <div class="d-flex flex-row justify-content-left">
                        @if ($certification == "certified")
                            <h3>
                            <span class="badge  badge-success rounded shadow-none">
                                <i class="fa fa-check"></i>&nbsp;
                                CZWG Certified
                            </span>
                            </h3>
                        @elseif ($certification == "not_certified")
                            <h3>
                            <span class="badge badge-danger rounded shadow-none">
                                <i class="fa fa-times"></i>&nbsp;
                                Not Certified to Control
                            </span>
                            </h3>
                        @elseif ($certification == "training")
                            <h3>
                            <span class="badge badge-warning rounded shadow-none">
                                <i class="fa fa-book-open"></i>&nbsp;
                                In Training
                            </span>
                            </h3>
                        @elseif ($certification == "home")
                            <h3>
                            <span class="badge rounded shadow-none" style="background-color:#013162">
                                <i class="fa fa-user-check"></i>&nbsp;
                                CZWG Controller
                            </span>
                            </h3>
                        @elseif ($certification == "visit")
                            <h3>
                            <span class="badge badge-info rounded shadow-none">
                                <i class="fa fa-plane"></i>&nbsp;
                                    CZWG Visiting Controller
                            </span>
                            </h3>
                        @elseif ($certification == "instructor")
                            <h3>
                            <span class="badge badge-info rounded shadow-none">
                                <i class="fa fa-chalkboard-teacher"></i>&nbsp;
                                        CZWG Instructor
                            </span>
                            </h3>
                        @else
                            <h3>
                            <span class="badge badge-dark rounded shadow-none">
                                <i class="fa fa-question"></i>&nbsp;
                                Unknown
                            </span>
                            </h3>
                        @endif
                        @if ($active == 0)
                            <h3>
                            <span class="badge ml-2 badge-danger rounded shadow-none">
                                <i class="fa fa-times"></i>&nbsp;
                                Inactive
                            </span>
                            </h3>
                        @elseif ($active == 1)
                            <h3>
                            <span class="badge ml-2 badge-success rounded shadow-none">
                                <i class="fa fa-check"></i>&nbsp;
                                Active
                            </span>
                            </h3>
                        @endif
                        </div>
                          <span class="text-danger">
                        @if ($certification == "not_certified")
                        <h5>You are not a certified controller, please contact an instructor to begin training.</h5>
                        @endif
                          @if ($active == 0)
                          <h5>You are currently inactive, please contact the FIR Chief</h5>
                          <h5>You cannot control on the network while inactive!</h5>
                          @endif
                        </span>
                    </div>
<!--All users, no hours-->
                    @if (Auth::user()->rosterProfile)
                    @if (Auth::user()->rosterProfile->status == "not_certified")
                    @else
                    <h5 class="card-title mt-2">Activity</h5>
                        @if (Auth::user()->rosterProfile->currency < 0.1)
                        <h3><span class="badge rounded shadow-none red">
                            No hours recorded
                        </span></h3>
                        @endif
                    @endif

<!--Winnipeg Training Hrs-->
                    @if (Auth::user()->rosterProfile->status == "training")
                        @if (!Auth::user()->rosterProfile->currency == 0)
                          @if (Auth::user()->rosterProfile->currency < 2.0)
                          <h3><span class="badge rounded shadow-none blue">
                            {{Auth::user()->rosterProfile->currency}} hours recorded
                          </span></h3>
                          @elseif (Auth::user()->rosterProfile->currency >= 2.0)
                          <h3><span class="badge rounded shadow-none green">
                            {{Auth::user()->rosterProfile->currency}} hours recorded
                          </span></h3>
                          @endif
                          @endif
                              <p>You require <b>2 hours</b> of activity every month!</p>
                        @endif

<!--End Winnipeg Training Hours-->
<!--Winnipeg Cntrlr Hrs-->
                        @if (Auth::user()->rosterProfile->status == "home")
                        @if (!Auth::user()->rosterProfile->currency == 0)
                          @if (Auth::user()->rosterProfile->currency < 2.0)
                          <h3><span class="badge rounded shadow-none blue">
                            {{Auth::user()->rosterProfile->currency}} hours recorded
                          </span></h3>
                          @elseif (Auth::user()->rosterProfile->currency >= 2.0)
                          <h3><span class="badge rounded shadow-none green">
                            {{Auth::user()->rosterProfile->currency}} hours recorded
                          </span></h3>
                          @endif
                          @endif
                              <p>You require <b>2 hours</b> of activity every month!</p>
                        @endif
<!--End Winnipeg Cntrlr Hours-->

<!--Winnipeg Vstr Cntrlr Hrs-->
                        @if (Auth::user()->rosterProfile->status == "visit")
                        @if (!Auth::user()->rosterProfile->currency == 0)
                        @if (Auth::user()->rosterProfile->currency < 1.0)
                          <h3><span class="badge rounded shadow-none blue">
                              {{Auth::user()->rosterProfile->currency}} hours recorded
                          </span></h3>
                        @elseif (Auth::user()->rosterProfile->currency >= 1.0)
                          <h3><span class="badge rounded shadow-none green">
                              {{Auth::user()->rosterProfile->currency}} hours recorded
                          </span></h3>
                        @endif
                        @endif
                        <p>You require <b>1 hour</b> of activity every month!</p>
                        @endif

<!--End Winnipeg Cntrlr Hours-->

<!--Winnipeg Cntrlr Hrs-->
                        @if (Auth::user()->rosterProfile->status == "instructor")
                        @if (!Auth::user()->rosterProfile->currency == 0)
                            @if (Auth::user()->rosterProfile->currency < 5.0)
                                <h3><span class="badge rounded shadow-none blue">
                                {{Auth::user()->rosterProfile->currency}} hours recorded
                            </span></h3>
                            @elseif (Auth::user()->rosterProfile->currency >= 5.0)
                                <h3><span class="badge rounded shadow-none green">
                                {{Auth::user()->rosterProfile->currency}} hours recorded
                                </span></h3>
                            @endif
                            @endif
                            <p>You require <b>5 hours</b> of activity every 2 months!</p>
                        @endif
<!--End Winnipeg Instrctr Hours-->


                    @endif
                    @else
                    <ul class="list-unstyled mt-2 mb-0">
                        <li class="mb-2">
                            <a href="{{route('application.list')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">View Your Applications</span></a>
                        </li>{{--
                        <li class="mb-2">
                            <a href="{{route('application.list')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">Training Centre</span></a>
                        </li> --}}
                        @endif






                    </ul>
                </div>
            </div>
            <br/>
            <div data-step="10" data-intro="If you have any enquires or issues for the staff, feel free to make a ticket via the ticketing system." class="card">
                <div class="card-body">
                    <h3 class="font-weight-bold blue-text pb-2">Support</h3>
                    <h5 class="font-weight-bold blue-text pb-2">Tickets</h5>
                    @if (count($openTickets) < 1)
                        You have no open support tickets
                        <br>
                    @else
                        <h5 class="black-text" style="font-weight: bold">
                            @if (count($openTickets) == 1)
                                1 open ticket
                            @else
                                {{count($openTickets)}} open tickets
                            @endif
                        </h5>
                        <div class="list-group">
                            @foreach ($openTickets as $ticket)
                                <a href="{{url('/dashboard/tickets/'.$ticket->ticket_id)}}" class="list-group-item list-group-item-action black-text rounded-0 " style="background-color:#d9d9d9">{{$ticket->title}}<br/>
                                    <small title="{{$ticket->updated_at}} (GMT+0, Zulu)">Last updated {{$ticket->updated_at_pretty()}}</small>
                                </a>
                            @endforeach
                        </div>
                        <br>
                    @endif
                    @if(Auth::user()->permissions >= 4)
                        <br>
                        <h5 class="font-weight-bold blue-text pb-2">Staff Tickets</h5>

                        @if (count($staffTickets) < 1)
                            You have no open <b>staff</b> tickets
                            <br>
                        @else
                            <h5 class="black-text" style="font-weight: bold">
                                @if (count($staffTickets) == 1)
                                    1 open staff ticket
                                @else
                                    {{count($staffTickets)}} open staff tickets
                                @endif
                            </h5>
                            <div class="list-group">
                                @foreach ($staffTickets as $ticket)
                                    <a href="{{url('/dashboard/tickets/'.$ticket->ticket_id)}}" class="list-group-item list-group-item-action black-text rounded-0 " style="background-color:#d9d9d9">{{$ticket->title}}<br/>
                                        <small title="{{$ticket->updated_at}} (GMT+0, Zulu)">Last updated {{$ticket->updated_at_pretty()}}</small>
                                    </a>
                              @endforeach
                           </div>
                        @endif
                        <br>
                    @endif
                    <ul class="list-unstyled mt-2 mb-0">
                        <li class="mb-2">
                            <a href="{{route('feedback.create')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">Send feedback to staff</span></a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('tickets.index', ['create' => 'yes'])}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">Start a support ticket</span></a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('tickets.index')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">View previous support tickets</span></a>
                        </li>
                        @if(Auth::user()->permissions >= 4)
                        <li class="mb-2">
                            <a href="{{route('tickets.staff')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">View staff ticket inbox</span></a>
                        </li>
                        @endif
                        <!--<li class="mb-2">
                            <a href="https://kb.ganderoceanic.com" target="_blank" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">CZWG Knowledge Base</span></a>
                        </li>-->
                    </ul>
                </div>
            </div>
            <br/>
            @if (Auth::user()->permissions >= 4)
            <div class="card">
                <div class="card-body">
                    <h3 class="font-weight-bold blue-text pb-2">Staff</h3>
                    <ul class="list-unstyled mt-2 mb-0">
                        <li class="mb-2">
                            <a href="{{route('training.index')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">Controller Training</span></a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('roster.index')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">Controller Roster</span></a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('events.admin.index')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">Events</span></a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('news.index')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">News</span></a>
                        </li>
                            <li class="mb-2">
                                <a href="{{(route('users.viewall'))}}" style="text-decoration:none;">
                                    <span class="blue-text">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                    &nbsp;
                                    <span class="black-text">
                                        View users
                                    </span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{(route('dashboard.image'))}}" style="text-decoration:none;">
                                    <span class="blue-text">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                    &nbsp;
                                    <span class="black-text">
                                        Upload Image to WPG Server
                                    </span>
                                </a>
                            </li>
                    </ul>
                </div>
            </div>
            <br/>
            @endif
            @if (Auth::user()->permissions >= 5)
            <div class="card">
                <div class="card-body">
                    <h3 class="font-weight-bold blue-text pb-2">Site Admin</h3>
                    <ul class="list-unstyled mt-2 mb-0">
                        <li class="mb-2">
                            <a href="{{route('settings.index')}}" style="text-decoration:none;"><span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">Settings</span></a>
                        </li>
                        <li class="mb-2">
                            <a href="{{route('network.index')}}" style="text-decoration:none;">
                                <span class="blue-text">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                                &nbsp;
                                <span class="black-text">
                                    View network data
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
    <br/>
    <a href="javascript:void(0);" onclick="javascript:introJs().setOption('showProgress', true).start();">View the tutorial</a>
</div>

<!--Change avatar modal-->
<div class="modal fade" id="changeAvatar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Change avatar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{route('users.changeavatar')}}" enctype="multipart/form-data" class="" id="">
            <div class="modal-body">
                <p>Please ensure your avatar complies with the VATSIM Code of Conduct. This avatar will be visible to staff members, if you place a controller booking, and if you're a staff member yourself, on the staff page.</p>
                @csrf
                <div class="input-group pb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file">
                        <label class="custom-file-label">Choose file</label>
                    </div>
                </div>
                @if(Auth::user()->hasDiscord())
                    or use your Discord avatar (refreshes every 6 hours)<br/>
                    <p class="mt-1"><img style="border-radius:50%; height: 60px;" class="img-fluid" src="{{Auth::user()->getDiscordAvatar()}}" alt=""><a href="{{route('users.changeavatar.discord')}}" class="btn btn-outline-success bg-CZQO-blue-light mt-3">Use Discord Avatar</a>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                <input type="submit" class="btn btn-success" value="Upload">
            </div>
            </form>
        </div>
    </div>
</div>
<!--End change avatar modal-->

<!--Biography modal-->
<div class="modal fade" id="viewBio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">View your biography</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (Auth::user()->bio)
                    {{Auth::user()->bio}}
                @else
                    You have no biography.
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                <a href="{{route('me.editbioindex')}}" class="btn btn-primary" role="button">Edit Biography</a>
            </div>
        </div>
    </div>
</div>
<!--End biography modal-->

<!--Change display name modal-->
<div class="modal fade" id="changeDisplayNameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Change your display name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('users.changedisplayname')}}">
            <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Display first name</label>
                        <input type="text" class="form-control" value="{{Auth::user()->display_fname}}" name="display_fname" id="input_display_fname">
                        <br/>
                        <a class="btn bg-CZWG-blue-light btn-sm" role="button" onclick="resetToCertFirstName()"><span style="color: #000">Reset to CERT first name</span></a>
                        <script>
                            function resetToCertFirstName() {
                                $("#input_display_fname").val("{{Auth::user()->fname}}")
                            }
                        </script>
                    </div>
                    <div class="form-group">
                        <label>Format</label>
                        <select name="format" class="custom-select">
                            <option value="showall">Show first name, last name, and CID (e.g. {{Auth::user()->display_fname}} {{Auth::user()->lname}} {{Auth::id()}})</option>
                            <option value="showfirstcid">Show first name and CID (e.g. {{Auth::user()->display_fname}} {{Auth::id()}})</option>
                            <option value="showcid">Show CID only (e.g. {{Auth::id()}})</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                <input type="submit" class="btn btn-success" value="Save Changes">
            </div>
            </form>
        </div>
    </div>
</div>
<!--End change display name modal-->

<!--Link/unlink Discord modal-->
<div class="modal fade" id="discordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        @if (!Auth::user()->hasDiscord())
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Link your Discord account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img style="height: 50px;" src="{{asset('/img/discord/CZWGplusdiscord.png')}}" class="img-fluid mb-2" alt="">
                <p>Linking your Discord account with Winnipeg FIR allows you to:</p>
                <ul>
                    <li>Join our Discord community</li>
                    <li>Receive notifications for ticket replies, training updates, and more</li>
                    <li>Use your Discord avatar on the website</li>
                </ul>
                <p>To link your account, click the button below. You will be redirected to Discord to approve the link. Information on data stored through Discord OAuth is available in the <a href="{{route('privacy')}}">privacy policy.</a></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                <a role="button" type="submit" href="{{route('me.discord.link')}}" class="btn btn-primary">Link Account</a>
            </div>
        </div>
        @else
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unlink your Discord account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Unlinking your account will:</p>
                <ul>
                    <li>Remove you from the CZWG Discord, if you're a member</li>
                    <li>Remove a Discord avatar if you have it selected</li>
                    <li>Stop sending you notifications via Discord</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                <a role="button" type="submit" href="{{route('me.discord.unlink')}}" class="btn btn-danger">Unlink Account</a>
            </div>
        </div>
        @endif
    </div>
</div>
<script>
    //$("#discordModal").modal();
</script>
<!--End Discord modal-->
<!--Join guild modal-->
<div class="modal fade" id="joinDiscordServerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Join the Winnipeg FIR Discord server</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Joining the Winnipeg FIR Discord server allows you to join the Winnipeg FIR controller and pilot community.</p>
                <h5>Rules</h5>
                <ul>
                    <li>1. The VATSIM Code of Conduct applies.</li>
                    <li>2. Always show respect and common decency to fellow members.</li>
                    <li>3. Do not send server invites to servers unrelated to VATSIM without staff permission. Do not send ANY invites via DMs unless asked to.
                    </li>
                    <li>4. Do not send spam in the server, including images, text, or emotes.</li>
                </ul>
                <p>Clicking the 'Join' button will redirect you to Discord. We require the Join Server permission to add your Discord account to the server.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button>
                <a role="button" type="submit" href="{{route('me.discord.join')}}" class="btn btn-primary">Join</a>
            </div>
        </div>
    </div>
</div>
<!--End join guild modal

{{-- <div class="modal fade" id="ctpSignUpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cross the Pond October 2019 Sign-up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('ctp.signup.post')}}" method="POST">
                @csrf
            <div class="modal-body">
                <p>
                    If you wish to control Gander/Shanwick Oceanic for <a href="https://ctp.vatsim.net/">Cross the Pond Eastbound 2019</a>, you can sign up here!
                </p>
                <h5 class="font-weight-bold">Requirements</h5>
                <ul class="ml-3" style="list-style: disc">
                    <li>Be a C1 rated controller or above</li>
                    <li>A suitable amount of hours as a C1 (50+)</li>
                    <li>You <b>do not</b> have to be a Gander or Shanwick certified controller</li>
                </ul>
                <h5 class="font-weight-bold">Availability</h5>
                <p>Are you available to control CTP Eastbound on 26 October?</p>
                <select name="availability" id="" class="form-control">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                    <option value="standby">As a standby controller</option>
                </select>
                <h5 class="mt-2 font-weight-bold">Times</h5>
                <p>What times are you available (in zulu)? If left blank, we will assume you are available for the entire event.</p>
                <input maxlength="191" name="times" class="form-control" type="text" placeholder="e.g. Between 1100z and 2000z">
                <p class="mt-2">By pressing the "Confirm" button below, you agree to be available to control for the periods you have typed above. If you are no longer available, please contact the FIR Chief ASAP.</p>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Confirm">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
            </div>
            </form>
        </div>
    </div>

</div> --}}

@stop
