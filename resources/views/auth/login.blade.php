@extends('layouts.app')

@section('content')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <h2 style="color: #b66dff; font-weight: bold;">Imara</h2>
                        </div>
                        {{-- <h4>Hello! let's get started</h4> --}}
                        <h6 class="font-weight-light">Sign in to continue.</h6>
                        <form class="pt-3" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus placeholder="Username">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password" placeholder="Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mt-3 d-grid gap-2">
                                <button
                                    class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                                    type="submit">SIGN IN</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        Keep me signed in </label>
                                </div>
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-link text-primary">Forgot
                                    password?</a>
                                @endif
                            </div>
                            {{-- <div class="mb-2 d-grid gap-2">
                                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                        <i class="mdi mdi-facebook me-2"></i>Connect using facebook </button>
                                </div> --}}
                            <div class="text-center mt-4 font-weight-light"> Don't have an account? <a
                                    href="{{ route('register') }}" class="text-primary">Create</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection