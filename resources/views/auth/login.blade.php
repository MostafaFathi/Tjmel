@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6">
                <a class="text-center d-block mb-3" href="{{ url('/') }}">
                    <img width="150" src="{{ asset('/portal/assets/images/logo.svg') }}" alt="">
                </a>
                <div class="card">
                    <div class="card-header h5 text-uppercase text-center">{{ __('تسجيل الدخول') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-2"></div>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-left">{{ __('البريد الالكتروني') }}</label>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-left">{{ __('كلمة السر') }}</label>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-2"></div>

                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('تذكرني') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">

                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success"
                                            style="background: #593b6b;border: 0px">
                                        {{ __('تسجيل الخول') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-secondary" href="{{ route('password.request') }}">
                                            {{ __('نسيت كلمة المرور؟') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-md-2"></div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
