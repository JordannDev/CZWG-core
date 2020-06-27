@extends('layouts.email')

@section('to-line', . $rosterMember->user->fullName('FLC') . 'Inactivity,')

@section('message-content')
<h2>Inactivity Alert!</h2>
<p>Here is a list of controllers who have <b>not</b> achieved the minimum hours required this month:</p>

<p>List controllers not active here</p>
@endsection

@section('from-line')
Sent automatically by ActivityBot
@endsection
