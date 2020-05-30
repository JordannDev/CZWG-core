
@extends('layouts.master')

@section('navbarprim')

    @parent

@stop

@section('title', 'ATC Roster - ')
@section('description', "Gander Oceanic's Oceanic Controller Roster")

@section('content')

<div class="container" style="margin-top: 20px;">
    <a href="{{route('dashboard.index')}}" class="blue-text" style="font-size: 1.2em;"> <i class="fas fa-arrow-left"></i> Dashboard</a>
    <div class="container" style="margin-top: 20px;">
            <h1 class="blue-text font-weight-bold">Controller Roster</h1>
            <hr>
            <p>Please note that the 'full name' field on this roster is dependant on the controller's name settings on the CZWG Core. As such, it is best to rely on the CID to determine whether they are on the roster.</p>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <h4 class="font-weight-bold blue-text">Actions</h4>
            <ul class="list-unstyled mt-2 mb-0">
                <li class="mb-2">
                    <a href="" data-target="#addController" data-toggle="modal" style="text-decoration:none;">
                        <span class="blue-text">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        &nbsp;
                        <span class="black-text">
                            Add a controller to roster
                        </span>
                    </a>
                </li>
            </ul>
        </div>
      </div>

        <h4 align="center">Winnipeg Controllers</h4>

        <!--WINNIPEG CONTROLLERS ROSTER-->
        <table id="rosterTable" class="table table-hover">
            <thead>

                <tr>
                    <th style="text-align:center" scope="col"><b>CID</b></th>
                    <th style="text-align:center" scope="col">Controller Name</th>
                    <th style="text-align:center" scope="col">Rating</th>
                    <th style="text-align:center" scope="col">DEL</th>
                    <th style="text-align:center" scope="col">GND</th>
                    <th style="text-align:center" scope="col">TWR</th>
                    <th style="text-align:center" scope="col">DEP</th>
                    <th style="text-align:center" scope="col">APP</th>
                    <th style="text-align:center" scope="col">CTR</th>
                    <th style="text-align:center" scope="col">Remarks</th>
                    <th style="text-align:center" scope="col">Status</th>
                    <th style="text-align:center" class="text-danger" scope="col"><b>Actions</b></th>

                </tr>
            </thead>

            <tbody>
            @foreach ($roster as $controller)
                <tr>
                    <th scope="row"><b>{{$controller->cid}}</b></th>
                    <td align="center" >
                        {{$controller->full_name}}
                    </td>
                    <td align="center">
                        {{$controller->user->rating_short}}
                    </td>

<!--WINNIPEG Controller Position Ratings from Db -->
<!--Delivery-->
                    @if ($controller->del == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($controller->del == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($controller->del == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($controller->del == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Ground-->
                    @if ($controller->gnd == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($controller->gnd == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($controller->gnd == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($controller->gnd == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Tower-->
                    @if ($controller->twr == "1")
                      <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($controller->twr == "2")
                      <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($controller->twr == "3")
                      <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($controller->twr == "4")
                      <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Departure-->
                    @if ($controller->dep == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($controller->dep == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($controller->dep == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($controller->dep == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Approach-->
                    @if ($controller->app == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($controller->app == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($controller->app == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($controller->app == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Centre-->
                    @if ($controller->ctr == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($controller->ctr == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($controller->ctr == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($controller->ctr == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Remarks-->
                    <td align="center">
                        {{$controller->remarks}}
                    </td>
<!--Active Status-->
                    @if ($controller->active == "0")
                        <td align="center" class="bg-danger text-white">Not Active</td>
                    @elseif ($controller->active == "1")
                        <td align="center" class="bg-success text-white">Active</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
                    <!--Edit controller-->
                    <td align="center">
                      <a href="{{route('roster.editcontrollerform', [$controller->cid]) }}">
                          <button>Edit</button>
                      </a>

                              </li>
                          </ul>


<!--END OF EDIT CONTROLLER-->
<!--DELETE CONTROLLER-->

                    <form method="POST" action="{{ route('roster.deletecontroller', [$controller->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <button type="submit">Delete</button>
                    </form>
                  </div></div>
                  </td>
                </tr>

            @endforeach
            </tbody>
        </table>
        <hr>
<h4 align="center">Visiting Controllers</h4>

<div class="row">
    <div class="col-md-3">
        <h4 class="font-weight-bold blue-text">Actions</h4>
        <ul class="list-unstyled mt-2 mb-0">
            <li class="mb-2">
                <a href="" data-target="#addVisitController" data-toggle="modal" style="text-decoration:none;">
                  <span class="blue-text"><i class="fas fa-chevron-right"></i></span> &nbsp; <span class="black-text">Add controller to roster</span></a>
            </li>

        </ul>
    </div>
<!--WINNIPEG VISITING CONTROLLERS ROSTER-->
        <table id="rosterVisitTable" class="table table-hover">
            <thead>

                <tr>
                    <th style="text-align:center" scope="col"><b>CID</b></th>
                    <th style="text-align:center" scope="col">Controller Name</th>
                    <th style="text-align:center" scope="col">Rating</th>
                    <th style="text-align:center" scope="col">DEL</th>
                    <th style="text-align:center" scope="col">GND</th>
                    <th style="text-align:center" scope="col">TWR</th>
                    <th style="text-align:center" scope="col">DEP</th>
                    <th style="text-align:center" scope="col">APP</th>
                    <th style="text-align:center" scope="col">CTR</th>
                    <th style="text-align:center" scope="col">Remarks</th>
                    <th style="text-align:center" scope="col">Status</th>
                    <th style="text-align:center" scope="col">Home FIR</th>
                    <th style="text-align:center" class="text-danger" scope="col"><b>Actions</b></th>

                </tr>
            </thead>

            <tbody>
            @foreach ($visitroster as $visitcontroller)
                <tr>
                    <th scope="row"><b>{{$visitcontroller->cid}}</b></th>
                    <td align="center" >
                        {{$visitcontroller->full_name}}
                    </td>
                    <td align="center">
                        {{$visitcontroller->user->rating_short}}
                    </td>

<!--WINNIPEG Controller Position Ratings from Db -->
<!--Delivery-->
                    @if ($visitcontroller->del == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($visitcontroller->del == "2")
                        <td align="center" style="background-color:#ffe401" class="text-white">Training</td>
                    @elseif ($visitcontroller->del == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($visitcontroller->del == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Ground-->
                    @if ($visitcontroller->gnd == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($visitcontroller->gnd == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($visitcontroller->gnd == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($visitcontroller->gnd == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Tower-->
                    @if ($visitcontroller->twr == "1")
                      <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($visitcontroller->twr == "2")
                      <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($visitcontroller->twr == "3")
                      <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($visitcontroller->twr == "4")
                      <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Departure-->
                    @if ($visitcontroller->dep == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($visitcontroller->dep == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($visitcontroller->dep == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($visitcontroller->dep == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Approach-->
                    @if ($visitcontroller->app == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($visitcontroller->app == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($visitcontroller->app == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($visitcontroller->app == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Centre-->
                    @if ($visitcontroller->ctr == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($visitcontroller->ctr == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
                    @elseif ($visitcontroller->ctr == "3")
                        <td align="center" style="background-color:#e29500" class="text-white">Solo</td>
                    @elseif ($visitcontroller->ctr == "4")
                        <td align="center" class="bg-success text-white">Certified</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--Remarks-->
                    <td align="center">
                        {{$visitcontroller->remarks}}
                    </td>
<!--Active Status-->
                    @if ($visitcontroller->active == "0")
                        <td align="center" class="bg-danger text-white">Not Active</td>
                    @elseif ($visitcontroller->active == "1")
                        <td align="center" class="bg-success text-white">Active</td>
                    @else
                        <td align="center" class="bg-danger text-white">ERROR</td>
                    @endif
<!--HOME FIR-->
                    <td align="center">
                        {{$visitcontroller->homefir}}
                    </td>

<!--Delete controller-->
                    <td align="center">

                      <form method="POST" action="{{ route('roster.deletevisitcontroller', [$visitcontroller->id]) }}">
                          {{ csrf_field() }}
                          {{ method_field('GET') }}
                          <button type="submit">Delete</button>
                      </form>

                </tr>

            @endforeach
            </tbody>
        </table>

    <script>
        $(document).ready(function() {
            $('#rosterTable', '#rosterVisitTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );
        } );
    </script>

</div>

                  <!--MODALS-->

<!--Add Winnipeg controller modal-->
<div class="modal fade" id="addController" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Controller to roster</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

              <div align="center" class="modal-body">

                    <div class="form-group row">
                        <label for="dropdown" class="col-sm-4 col-form-label text-md-right">{{ __('Controllers') }}</label>

                        <div class="col-md-12">
                            <form method="POST" action="{{ route('roster.addcontroller' )}}">
                            <select class="custom-select" name="newcontroller">
                              @foreach($users as $user)
                              <option value="{{ $user->id}}">{{$user->id}} - {{$user->fname}} {{$user->lname}}</option>
                              @endforeach
                            </select>

                            @if ($errors->has('dropdown'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dropdown') }}</strong>
                                </span>
                            @endif
                            <td align="center">
                                  @csrf
                                  <button type="submit">Add User</button>

                            </td>
                             </form>
                        </div>
                    </div>

            </div>

            <div align="center" class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button></form>
            </div>
        </div>
    </div>
</div>
<!--End add Winnipeg controller modal-->

<!--Add Visitor controller modal-->
<div class="modal fade" id="addVisitController" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Controller to roster</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

              <div align="center" class="modal-body">

                    <div class="form-group row">
                        <label for="dropdown" class="col-sm-4 col-form-label text-md-right">{{ __('Controllers') }}</label>

                        <div class="col-md-12">
                            <form method="POST" action="{{ route('roster.addvisitcontroller' )}}">
                            <select class="custom-select" name="newcontroller">
                              @foreach($users as $user)
                              <option value="{{ $user->id}}">{{$user->id}} - {{$user->fname}} {{$user->lname}}</option>
                              @endforeach
                            </select>

                            @if ($errors->has('dropdown'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('dropdown') }}</strong>
                                </span>
                            @endif

                            <td align="center">
                                  @csrf

                                  <button type="submit">Add User</button>

                            </td>
                             </form>
                        </div>
                    </div>

            </div>

            <div align="center" class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button></form>
            </div>
        </div>
    </div>
</div>
<!--End add Visitor controller modal-->

<!--Edit Controller Modal-->
<div class="modal fade" id="editControllerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Controller</h5><br>
                <b>Warning:</b><br>May not function correctly, still in development.
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="/dashboard/roster" id="editControllerForm">
              <div class="modal-body">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <style>
            * {
              box-sizing: border-box;
            }

            /* Create two equal columns that floats next to each other */
            .column {
              float: left;
              width: 50%;
              padding: 10px;
            }

            /* Clear floats after the columns */
            .row:after {
              content: "";
              display: table;
              clear: both;
            }
            </style>
            </head>

            <div align="center">
              <div class="form-group">
            <label for="cid">CID:</label><br>
            <input type="text" id="id" class="form-control" readonly>
          </div>
            <br>
            <div align="center" class="row">
              <div align="center" class="column">
                <label for="del">Delivery:</label><br>
                <select style="width: 100px;" id="del" name="del">
                  <option value="1">Not Certified</option>
                  <option value="2">Training</option>
                  <option value="3">Solo</option>
                  <option value="4">Certified</option>
                </select>

                <br><br>
                <label for="gnd">Ground:</label><br>
                <select style="width: 100px;" id="gnd" name="gnd">
                  <option value="1">Not Certified</option>
                  <option value="2">Training</option>
                  <option value="3">Solo</option>
                  <option value="4">Certified</option>
                </select>
                <br><br>
                <label for="twr">Tower:</label><br>
                <select style="width: 100px;" id="twr" name="twr" style="width: 120px;">
                  <option value="1">Not Certified</option>
                  <option value="2">Training</option>
                  <option value="3">Solo</option>
                  <option value="4">Certified</option>
                </select>
              </div>
              <div align="center" class="column">
                <label for="dep">Departure:</label><br>
                <select style="width: 100px;" id="dep" name="dep">
                  <option value="1">Not Certified</option>
                  <option value="2">Training</option>
                  <option value="3">Solo</option>
                  <option value="4">Certified</option>
                </select>
                <br><br>
                <label for="app">Approach:</label><br>
                <select style="width: 100px;" id="app" name="app">
                  <option value="1">Not Certified</option>
                  <option value="2">Training</option>
                  <option value="3">Solo</option>
                  <option value="4">Certified</option>
                </select><br>
                <br>
                <label for="ctr">Center:</label><br>
                <select style="width: 100px;" id="ctr" name="ctr">
                  <option value="1">Not Certified</option>
                  <option value="2">Training</option>
                  <option value="3">Solo</option>
                  <option value="4">Certified</option>
                </select><br>
                <br>
              </div>

                <label style="width: 100px;" for="remarks">Remarks</label><br>
                <textarea id="remarks" rows="4" cols="30">
                </textarea>
                        <br><br><br>
                        <input type="submit" value="Edit Controller">
                        </form></div>
                        </div>
                      </div>

            <div align="center" class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Dismiss</button></form>
            </div>
        </div>

<!--Edit Winnipeg controller modal-->

<!--SCRIPTS-->


<script type="text/javascript">
	$(document).ready(function () {
		var table = $('#rosterTable').DataTable();

		//Start Edit Record
		table.on('click', '.editcontroller', function () {
			$tr = $(this).closest('tr');
			if ($(tr).hasClass('child')) {
			    $tr = $tr.prev('.parent');
			}
		var data = table.row($tr).data();
		console.log(data);
		$('#remarks').val(data[9]);

		$(#editControllerForm').attr('action', '/dashboard/roster/'+data[0]);
		$('#editControllerModal').modal('show');
		});
		//End Edit Record

	});
</script>
<!--End of Scripts-->
@stop
