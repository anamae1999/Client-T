@extends('layouts.layout')
@section('content')
<section class="error-banner">
    <div class="container wrapper">
        <div class="row align-items-center justify-content-end banner-content error-banner-content text-center">
            <div class="col-xl-6 col-md-6 col-sm-8">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif
                <h1>{{ __('Verify Your Email Address') }}</h1>
                <h5></h5>
                <p class="mb-0">{{ __('Before proceeding, please check your email (INBOX/SPAM FOLDER) for a verification link.') }}</p>
                <p class="mb-0">{{ __('If you did not receive the email click the button below to request another.') }}</p>
<br>
<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
    @csrf
	 <button type="submit" class="custom-btn btn-green">
        {{ __('Resend Link') }}
    </button>
		</form>
            </div>
        </div>
    </div>
</section>
@endsection
