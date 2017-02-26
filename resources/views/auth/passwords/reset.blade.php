@extends('layouts.app')

@section('content')
    <h1 class="ui header">Reset Password</h1>

    <form class="ui form segment" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}

        @if (session('status'))
            <div class="ui success message visible" style="margin-top: 0">
                <p>{{ session('status') }}</p>
            </div>
        @endif

        @include('layouts.errors')

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field required">
            <label>E-Mail Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field required">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="field required">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div class="ui field">
            <button type="submit" class="ui primary submit button">Reset Password</button>
        </div>
    </form>
@endsection
