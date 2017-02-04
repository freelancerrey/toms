@extends('layouts.guest')

@section('title', 'Login')

@section('sidelinks')
<a href="{{ url('/password/reset') }}">Forgot Password?</a>
<a href="{{ url('/register') }}">Register</a>
@endsection

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
    <div class="jumbotron">
        <h2 class='text-left' style='margin: 0 0 20px 0;'>LOG IN</h2>
        {{ csrf_field() }}
        <!-- <div role="alert" class="alert alert-danger well-sm text-left"><strong>Opps!</strong> Invalid Email or Password!</div> -->
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} text-left">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} text-left">
            <label for="password">Password</label>
            <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
         <div class="form-group text-left">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
        </div>
        <div class="form-group text-left">
            <button type="submit" class="btn btn-primary">Log In</button>
        </div>
    </div>
</form>
@endsection
