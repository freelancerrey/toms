@extends('layouts.guest')

@section('title', 'Register')
@section('customcss')
<link href="/css/register.css" rel="stylesheet">
@endsection

@section('sidelinks')
<a href="{{ url('/login') }}">Login</a>
@endsection

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
    <div class="jumbotron">
        <h2 class='text-left' style='margin: 0 0 20px 0;'>REGISTER</h2>
        {{ csrf_field() }}
        <!-- <div role="alert" class="alert alert-danger well-sm text-left"><strong>Opps!</strong> Invalid Email or Password!</div> -->
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} text-left">
            <label for="name">Name</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} text-left">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class='row'>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} text-left">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group text-left">
                    <label for="confirm-password">Confirm Password</label>
                    <input id="confirm-password" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                </div>
            </div>
        </div>
        <div class="form-group text-left">
            <button type="submit" class="btn btn-primary">Create Account</button>
        </div>
    </div>
</form>
@endsection
