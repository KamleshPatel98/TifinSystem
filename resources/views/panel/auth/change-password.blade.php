@extends('layouts.panel')
@section('title', 'Change Password')

@section('content')
    {{-- Page Header Card (Keep Rounded) --}}
    <div class="card border-0 shadow bg-white mb-2">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-1 py-md-3 px-2 px-md-4">
            <div>
                <h5 class="mb-0 fw-semibold">Change Password</h5>
                <small class="text-muted">Change your account password.</small>
            </div>
        </div>
    </div>

    {{-- Change Password Form Card (No Rounded Corners) --}}
    <div class="card border-0 shadow bg-white">
        <div class="card-body p-4">
            <form action="{{ route('auth.change-password-submit') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="old_password" class="form-label">Old Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="old_password" name="old_password" required placeholder="Enter old password" value="{{ old('old_password') }}">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Enter new password" value="{{ old('password') }}">
                        <small class="text-muted">
                            Minimum 10 characters, at least 1 number & 1 symbol.
                        </small>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>   
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Enter new password again" value="{{ old('password_confirmation') }}">
                    </div>

                </div>

                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-success px-4">
                        Change Password
                    </button>
                    <button type="reset" class="btn btn-secondary px-4">
                        Reset
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection