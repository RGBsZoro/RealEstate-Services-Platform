@extends('layouts/blankLayout')

@section('title', __('login.login_title') . ' - ' . __('sidebar.app_name'))

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card px-sm-6 px-0">
                <div class="card-body">
                    {{-- Logo & Brand --}}
                    <div class="app-brand justify-content-center mb-6">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">@include('_partials.macros')</span>
                            {{-- استخدمنا مفتاح اسم التطبيق من السايد بار لتوحيد الاسم --}}
                            <span class="app-brand-text demo text-heading fw-bold">{{ __('sidebar.app_name') }}</span>
                        </a>
                    </div>

                    {{-- Header --}}
                    <div class="text-center mb-6">
                        <h4 class="mb-1">{{ __('login.admin_dashboard') }} 👋</h4>
                        <p class="mb-0 text-muted">{{ __('login.login_subtitle') }}</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
                        @csrf
                        {{-- Email --}}
                        <div class="mb-6">
                            <label for="email" class="form-label">{{ __('login.email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('login.email_placeholder') }}" autofocus required />
                        </div>

                        {{-- Password --}}
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password">{{ __('login.password') }}</label>
                            <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                            </div>
                        </div>
                        
                        {{-- Submit Button --}}
                        <div class="mt-8">
                            <button class="btn btn-primary d-grid w-100" type="submit">
                                {{ __('login.sign_in') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
