@extends('layouts.master')

@section('navbarprim')

    @parent

@stop

@section('title', 'ATC Roster - Winnipeg FIR')
@section('description', "Winnipeg FIR's Controller Roster")

@section('content')
<div class="container" style="margin-top: 20px;">
        <h1 class="blue-text font-weight-bold">Controller Roster</h1>
        <hr>
        <p>Please note that the 'full name' field on this roster is dependant on the controller's name settings on the CZWG Core. As such, it is best to rely on the CID to determine whether they are on the roster.</p>
<h4 align="center">Winnipeg Controllers</h2>

<!--WINNIPEG CONTROLLERS ROSTER-->
        <table id="rosterTable" class="table table-hover" style="position:relative; left:-70px; top:2px; width:116%">
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

                </tr>
            </thead>
            <tbody>
            @foreach ($roster as $controller)
                <tr>
                    <th scope="row"><b>{{$controller->cid}}</b></th>
                    <td align="center" >
                        {{$controller->user->fullName('FL')}}
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
                    <td align="center" style="width:15%">
                        {{$controller->remarks}}
                    </td>
<!--Active Status-->

                </tr>
            @endforeach
            </tbody>
        </table>
    <script>
        $(document).ready(function() {
            $('#rosterTable').DataTable( {
                "order": [[ 1, "asc" ]]
            } );
        } );
    </script>
<br></br>
<h4 align="center">Visiting Controllers</h4>

<!--WINNIPEG VISITING CONTROLLERS ROSTER-->
        <table id="visitRosterTable" class="table table-hover"  style="position:relative; left:-70px; top:2px; width:116%">
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
                    <th style="text-align:center" scope="col">Home FIR</th>

                </tr>
            </thead>
            <tbody>
            @foreach ($visitroster as $visitcontroller)
                <tr>
                    <th scope="row"><b>{{$visitcontroller->cid}}</b></th>
                    <td align="center" >
                        {{$visitcontroller->user->fullName('FL')}}
                    </td>
                    <td align="center">
                        {{$visitcontroller->user->rating_short}}
                    </td>

<!--WINNIPEG Controller Position Ratings from Db -->
<!--Delivery-->
                    @if ($visitcontroller->del == "1")
                        <td align="center" class="bg-danger text-white">Not Certified</td>
                    @elseif ($visitcontroller->del == "2")
                        <td align="center" style="background-color:#ffe401" class="text-black">Training</td>
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
                    
<!--HOME FIR-->
                    <td align="center">
                        {{$visitcontroller->homefir}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    <script>
        $(document).ready(function() {
            $('#rosterTable', 'visitRosterTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );
        } );
    </script>

</div>
@stop
