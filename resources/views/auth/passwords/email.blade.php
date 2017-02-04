@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
    <div class="jumbotron">
        <h2 class='text-left' style='margin: 0 0 20px 0;'>RESET PASSWORD</h2>
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
        <div class="form-group text-left">
            <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
        </div>
    </div>
</form>
@endsection
