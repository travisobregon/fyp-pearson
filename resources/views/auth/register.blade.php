@extends('layouts.app')

@section('content')
    <h1 class="ui header">Register</h1>

    <form class="ui form segment" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        @include('layouts.errors')

        <div class="two fields">
            <div class="field required">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="field required">
                <label>E-Mail Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="two fields">
            <div class="field required">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="field required">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
        </div>

        <div class="ui segments">
            <div class="ui secondary segment">
                <h4 class="ui header">Address</h4>
            </div>

            <div class="ui segment">
                <div class="two fields">
                    <div class="field required">
                        <label>Name</label>
                        <input type="text" name="address_name" value="{{ old('address_name') }}" required>
                    </div>

                    <div class="field required">
                        <label>City</label>

                        <div class="ui search normal selection dropdown">
                            <input type="hidden" name="city" value="{{ old('city') }}" required>

                            <i class="dropdown icon"></i>

                            <div class="default text">Select City</div>

                            <div class="menu">
                                @foreach ($cities as $city)
                                    <div class="item" data-value="{{ $city->id }}">{{ $city->name }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="three fields">
                    <div class="field required">
                        <label>District</label>
                        <input type="text" name="district" value="{{ old('district') }}" required>
                    </div>

                    <div class="field required">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" required>
                    </div>

                    <div class="field required">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui field">
            <button type="submit" class="ui primary submit button">Register</button>
        </div>
    </form>
@endsection
