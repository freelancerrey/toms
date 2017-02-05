@extends('layouts.guest')

@section('title', 'Reset Password')

@section('sidelinks')
<a href="{{ url('/login') }}">Login</a>
@endsection

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
    <div class="jumbotron">
        <h2 class='text-left' style='margin: 0 0 20px 0;'>RESET PASSWORD</h2>
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} text-left">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus placeholder="Email">
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
        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} text-left">
            <label for="confirm-password">Confirm Password</label>
            <input id="confirm-password" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group text-left">
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </div>
    </div>
</form>
@endsection
