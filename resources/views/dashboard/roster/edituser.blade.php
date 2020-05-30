
@extends('layouts.master')

@section('navbarprim')

    @parent

@stop

@section('title', 'ATC Roster - ')
@section('description', "Gander Oceanic's Oceanic Controller Roster")

@section('content')

<div class="container" style="margin-top: 20px;">
    <a href="{{route('roster.index')}}" class="blue-text" style="font-size: 1.2em;"> <i class="fas fa-arrow-left"></i>Roster</a>
<br>
<head>
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
<form method="post" action="{{route('roster.editcontroller', [$cid]) }}"<br>
  <form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Edit Controller on Roster</legend>


<div class="form-group">
  <label>Controller CID:</label><br>
  {{$cid}}<br><br>

  <!--Delivery-->

    <input type="hidden" name="cid" value="{{ $cid }}">
</div>
<div class="form-row">
  <div class="col-md-3">
  </div>
<div class="form-group col-md-2">
  <div align="center">
  <label class="control-label" for="del">Delivery</label>
    <select name="del" class="form-control">
      <option value="1">Not Certified</option>
      <option value="2">Training</option>
      <option value="3">Solo</option>
      <option value="4">Certified</option>
    </select>
</div>
</div>


<!-- Ground -->
<div class="form-group col-md-2">
  <label class="control-label" for="gnd">Ground</label>

    <select name="gnd" class="form-control">
      <option value="1">Not Certified</option>
      <option value="2">Training</option>
      <option value="3">Solo</option>
      <option value="4">Certified</option>
    </select>
</div>


<!-- Tower -->

<div class="form-group col-md-2">
  <label class="control-label" for="twr">Tower</label>
    <select name="twr" class="form-control">
      <option value="1">Not Certified</option>
      <option value="2">Training</option>
      <option value="3">Solo</option>
      <option value="4">Certified</option>
    </select>

</div>
</div>

<br><br>

<!-- Departure -->
<div class="form-row">
  <div class="col-md-3">
  </div>
<div class="form-group col-md-2">
  <label class="control-label" for="dep">Departure</label>
    <select name="dep" class="form-control">
      <option value="1">Not Certified</option>
      <option value="2">Training</option>
      <option value="3">Solo</option>
      <option value="4">Certified</option>
    </select>
  </div>

<br><br>
<!-- Approach -->
<div class="form-group col-md-2">
  <label class="control-label" for="app">Approach</label>
    <select name="app" class="form-control">
      <option value="1">Not Certified</option>
      <option value="2">Training</option>
      <option value="3">Solo</option>
      <option value="4">Certified</option>
    </select>
  </div>

<br><br>
<!-- Center -->
<div class="form-group col-md-2">
  <label class="control-label" for="ctr">Center</label>
    <select name="ctr" class="form-control">
      <option value="1">Not Certified</option>
      <option value="2">Training</option>
      <option value="3">Solo</option>
      <option value="4">Certified</option>

    </select>
  </div>
</div>


<!--Remarks-->
<div class="form-group">
  <label class="control-label" for="remarks">Remarks</label><br>
  <textarea name="remarks" rows="4" cols="30" class="form-control">{{ $roster->remarks }}
  </textarea></div>


  <!--Active Status-->
  <div class="form-group">
    <label class="control-label" for"active">Active</label><br>
    <div class="col-md-2">
      <select name="active" class="form-control">
        <option value="1">Active</option>
        <option value="0">Not Active</option>
      </select>
    </div>
  </div>
@csrf
<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button name="submit" class="btn btn-success">Submit</button>
  </div>
</div>
</div>
</fieldset>
</form>
@stop
