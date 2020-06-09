@extends('layouts.master')
@section('title', 'Error 404')

@section('content')
    <div class="container py-5">
        <h4 class="font-weight-bold">ERROR 404</h4>
        <div class="mt-4">
            <p style="font-size: 1.2em;">
                Looks like this page doesn't exist! Here's a funny VATSIM quote to pass the time...
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
                        "blue"=>"'What's your cruise speed?' 'Dunno, probably blue.'");

                    //echo greeting
                    echo (randomArrayVar($greeting));
                    ?>"</1></h3>
                    <br>
        </div>
        <a href="{{route('index')}}" class="btn bg-czqo-blue-light">Back to Homepage</a>
    </div>
@endsection