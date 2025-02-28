@extends('layouts.errors')
@section('content')
<section class="error-banner">
	<div class="container wrapper">
		<div class="row align-items-center justify-content-end banner-content error-banner-content text-center">
			<div class="col-xl-6 col-md-6 col-sm-8">
				<h1>Oops!</h1>
				<h5>403 - FORBIDDEN</h5>
				<p class="mb-0">You're trying to open in your web browser is a resource that you're not allowed to access</p>
				<a href="/" class="custom-btn btn-green">Go to homepage</a>
				<h5 class="mb-2 mt-0">Here are some helpful links instead:</h5>
				<p class="mb-2"><a class="white" href="/about-us">About us</a></p>
				<p class="mb-2"><a class="white" href="/contact">Contact us</a></p>
			</div>
		</div>
	</div>
</section>
@endsection

