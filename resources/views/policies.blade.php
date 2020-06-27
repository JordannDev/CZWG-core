@extends('layouts.master')

@section('navbarprim')

    @parent

@stop

@section('title', 'Policies')
@section('description', 'Policies and Guidelines from the Winnipeg FIR')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <h1 class="font-weight-bold blue-text">Policies</h1>
        <hr>
        @if (Auth::check() && Auth::user()->permissions == 5)
            <div class="card w-50">
                <div class="card-body">
                    <h5 class="card-title">Policy Admin</h5>
                    <a href="#" data-toggle="modal" data-target="#addPolicyModal" class="btn btn-primary">Add New Policy</a>
                </div>
            </div>
        @endif
        <br class="my-2">
        @foreach ($policies as $policy)
            <div id="accordion">
                <div aria-expanded="true"  class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#policy{{$policy->id}}" aria-expanded="true" aria-controls="policy{{$policy->id}}">
                                {{ $policy->name }}
                            </button>
                        </h5>
                    </div>
                    <div id="policy{{$policy->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            @if (Auth::check() && Auth::user()->permissions >= 4)
                                <div class="border" style="padding: 10px;">
                                    <a href="{{url('/policies/'.$policy->id.'/delete')}}" class="btn btn-danger">Delete Policy</a>
                                    &nbsp;
                                    <b>Effective Date: {{$policy->releaseDate }}</b>
                                </div>
                            @endif
                            <p>{{$policy->details}}</p>
                            @if ($policy->staff_only == 1)
                                <p>
                                    <b>This is a private staff-only policy.</b>
                                </p>
                            @endif
                            <a target="_blank" href="{{$policy->link}}">Download the .PDF file HERE.</a>
                            @if ($policy->embed == 1)
                                <iframe width="100%" style="height: 600px; border: none;" src="{{$policy->link}}"></iframe>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <hr>
        <div class="modal fade" id="addPolicyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Policy</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="{{route('policies.create')}}" class="form-group">

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name of Author</label>
                            <input type="text" name="name" class="form-control"></input>

                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Details (Max 250 Char.)</label>
                            <textarea name="details" class="form-control"></textarea>

                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">URL</label>
                            <input type="text" name="link" class="form-control"></input>

                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Display Options</label>
                            <select name="embed" class="form-control">
                              <option value="0">Do Not Display</option>
                              <option value="1">Display</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Privacy</label>
                            <select name="staff_only" class="form-control">
                              <option value="0">Public</option>
                              <option value="1">Private to staff only</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Publishing Notification</label>
                            <select name="email" class="form-control">
                              <option value="all">Email ALL Users & Publish News Article</option>
                              <option value="emailcert">Email Certified Controllers and News Article</option>
                              <option value="newsonly">Only News Article</option>
                              <option value="none">Do Nothing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Effective Date</label>
                            <input type="datetime" id="date" name="date" placeholder="Choose a Date" class="form-control flatpickr"></input>
                        </div>
                        <script>
                            flatpickr('#date', {
                                enableTime: false,
                                noCalendar: false,
                                dateFormat: "Y-m-d",
                                time_24hr: true,
                            });
                        </script>
                        @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
