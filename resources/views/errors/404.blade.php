@extends('layouts.master')
@section('title', 'Error 404')

@section('content')
    <div class="container py-5">
        <h2 class="font-weight-bold"><i class="fa fa-cogs"></i>  ERROR 404</h2>
        <div class="mt-4">
            <p style="font-size: 1.2em;">
                Looks like this page doesn't exist! Here's a funny Winnipeg FIR quote to pass the time...
                <br>
            </p>
            <h3><i>"<?php 
                function randomArrayVar($array)
                {
                    if (!is_array($array)){
                        return $array;
                    }
                    return $array[array_rand($array)];
                }
                $greeting= array(
                        "identiflied"=>"ACA427, radar identiflyied, correction, IDENTIFIED FL350, welcome aboard!",
                        "opy"=>"QFA567, did you opy my last?",
                        "simon"=>"Hello Simon. My name is Daniel and I am a VATSIM Supervisor. A controller has complained that you are not terminating flight following. This is a notice to inform you that your VATSIM Pilots License is hereby perminantly revoked. You may now only control and drive boats on the network.",
                        "sayit"=>"Say the f-word on my frequency... say it... 'F*CK!' YES!",
                        "week"=>"Roger, see ya, have a great... week, I guess?",
                        "trudeau"=>"I’m a part of #GenerationTrudeau. Check it out and commit to vote in #elxn42: http://lpc.ca/ans3",
                        "dollars"=>"I have twenty, and ten, and three five dollars",
                        "itworks"=>"OMG this is sooo awesome!",
                        "bill"=>"w h o n k",
                        "denver"=>"When I handoff to Denver, is it automatic?",
                        "drunk"=>"Centre, we've had too many alcohols to stay on frequency, we're gonna go ahead and go to UNICOM 122.8 now, will be terminating our radar services, and we WILL have a good flight.",
                        "blue"=>"'What's your cruise speed?' 'Dunno, probably blue.'");

                    //echo greeting
                    echo (randomArrayVar($greeting));
                    ?>"</i></h3>
                    <br>
        </div>
        <a href="{{route('index')}}" class="btn btn-primary">Back to Homepage</a>
    </div>
@endsection