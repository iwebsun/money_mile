@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Profile</div>
 
                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    <form class="form-horizontal" method="POST" action="{{ route('profile') }}">
                        {{ csrf_field() }}
 
                        <p>We just require a few details to setup your personalized experience</p>
                        <div class="form-group">
                            <label for="new-password" class="col-md-4 control-label">How old are you?</label>
 
                            <div class="col-md-6">
                                <input id="age" type="radio" class="form-control" value="21-25" name="age[21-25]">21-25
                                <input id="age" type="radio" class="form-control" value="26-30" name="age[26-30]">26-30
                                <input id="age" type="radio" class="form-control" value="31-35" name="age[31-35]">31-35
                                <input id="age" type="radio" class="form-control" value="36-40" name="age[36-40]">36-40
                                <input id="age" type="radio" class="form-control" value="41-45" name="age[41-45]">41-45
                                <input id="age" type="radio" class="form-control" value="45+" name="age[45+]">45+ 
                            </div>
                        </div>  
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection