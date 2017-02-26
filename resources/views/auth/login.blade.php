@extends('layouts.app')

@section('content')
    <h1 class="ui header">Login</h1>

    <form class="ui form segment" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        @include('layouts.errors')

        <div class="field required">
            <label>E-Mail Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field required">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" id="remember" class="hidden" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember Me</label>
            </div>
        </div>

        <div class="ui field">
            <button type="submit" class="ui primary submit button">Login</button>

            <a href="{{ route('password.request') }}">Forgot Your Password?</a>
        </div>
    </form>
@endsection
