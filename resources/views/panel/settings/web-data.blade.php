@extends('layouts.panel')

@section('title', 'Web Data')

@section('content')
<div class="card border-0 shadow rounded-4 bg-white mb-3">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-1 py-md-3 px-2 px-md-4">
        <div>
            <h5 class="mb-0 fw-semibold">Web Data</h5>
            <small class="text-muted">Change your web data details.</small>
        </div>
    </div>
</div>

<div class="row">
    {{-- Left Profile --}}
    <div class="col-lg-4 mb-2">
        <div class="card shadow border-0 ">
            <div class="card-body">
                <div class="text-center mt-3">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="Profile Image"
                        class="rounded-circle shadow mb-3" width="120" height="120">

                    <h5 class="fw-bold">{{ getSetting('app_name') ?? '' }}</h5>
                    <p class="mb-1">{{ Auth::user()?->roles?->pluck('name')->implode(', ') ?? '' }}</p>
                    <p class="mb-1 text-muted"><i class="fa-solid fa-phone"></i> {{ Auth::user()->mobile ?? '' }}</p>
                </div>

                <hr class="mt-5">
                <div class="d-flex justify-content-between m-3">
                    <b>Website :</b>
                    <span>{{ getSetting('app_url') ?? '' }}</span>
                </div>
                <div class="d-flex justify-content-between m-3">
                    <b>Web Version :</b>
                    <span>{{ getSetting('web_version') ?? '' }}</span>
                </div>
            </div>
        </div>

    </div>


    {{-- Right Side --}}
    <div class="col-lg-8">
        <div class="card shadow border-0">
            <div class="card-body">
                <form action="{{ route('settings.web-data-submit') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Website Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="app_name" value="{{ getSetting('app_name') ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Website URL</label>
                            </div>
                            <div class="col-md-9">
                                <input type="url" name="app_url" value="{{ getSetting('app_url') ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Mobile No</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="app_phone" value="{{ getSetting('app_phone') ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Alt Mobile No</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="app_alt_phone" value="{{ getSetting('app_alt_phone') ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Email</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="app_email" value="{{ getSetting('app_email') ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Address</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="app_address" value="{{ getSetting('app_address') ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Footer Text</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="app_footer_text" value="{{ getSetting('app_footer_text') ?? '' }}" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Page Limit</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="page_limit" value="{{ getSetting('page_limit') ?? '' }}" class="form-control">
                            </div>
                        </div>

                        {{-- Submit and reset --}}
                        <div class="row">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-9 mt-3">
                                <button type="submit" class="btn btn-success px-4 me-1">
                                    Save Changes
                                </button>
                                <button type="reset" class="btn btn-secondary px-4">
                                    Reset
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection