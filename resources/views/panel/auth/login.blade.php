@extends('layouts.auth')
@section('title', 'Login Page')

@section('content')

<div class="p-4 p-md-5">

    <img src="{{ asset('assets/images/logo.jpg') }}" class="mb-4" alt="Logo" width="50" height="50">

    <h6 class="fw-bold mb-2">Hello & Welcome!</h6>
    <p class="text-muted mb-4">Please enter your phone number to sign in.</p>

    <form action="{{ route('auth.login.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Phone Number</label>

            <div class="input-group">
                <input type="text"
                    class="form-control"
                    name="mobile"
                    placeholder="Enter phone number"
                    value="{{ old('mobile') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password"
                class="form-control"
                name="password"
                placeholder="**********">
        </div>

        <button type="submit" class="btn btn-orange w-100 mt-3">
            Login
        </button>

    </form>

</div>
@endsection