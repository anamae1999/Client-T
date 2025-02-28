@extends('layouts.errors')
@section('content')
<section class="error-banner">
	<div class="container wrapper">
		<div class="row align-items-center justify-content-end banner-content error-banner-content text-center">
			<div class="col-xl-6 col-md-6 col-sm-8">
				<h1>Oops!</h1>
				<h5>404 - PAGE NOT FOUND</h5>
				<p class="mb-0">The page you are looking for might have been removed<br/>Had its name changed or is temporarily unavailable</p>
				<a href="/" class="custom-btn btn-green">Go to homepage</a>
				<h5 class="mb-2 mt-0">Here are some helpful links instead:</h5>
				<p class="mb-2"><a class="white" href="/about-us">About us</a></p>
				<p class="mb-2"><a class="white" href="/contact">Contact us</a></p>
			</div>
		</div>
	</div>
</section>
@endsection