@extends('layouts.app')

@section('content')
    <h1 class="ui header">Reset Password</h1>

    <form class="ui form segment" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        @if (session('status'))
            <div class="ui success message visible" style="margin-top: 0">
                <p>{{ session('status') }}</p>
            </div>
        @endif

        @include('layouts.errors')

        <div class="field required">
            <label>E-Mail Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="ui field">
            <button type="submit" class="ui primary submit button">Send Password Reset Link</button>
        </div>
    </form>
@endsection
