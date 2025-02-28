@extends('layouts.layout')

@section('title', $page->meta_titles)
@section('description', $page->meta_descriptions)
@section('keywords', $page->meta_keywords)

@if(!empty($settings->headhtml))
	@section('headhtml')
		@php
			$dom = new DOMDocument;
			$dom->loadHTML($settings->headhtml);
			$html = $dom->saveHTML();

			echo $html;
		@endphp
	@endsection
@endif

@section('content')

@if($settings->cookie == 1)
	@include('cookieConsent::index')
@endif

	<section class="padTB80">
		@if($showSection['privacy-policy'] == 'show')
		<div class="container wrapper">
			<div class="row">
				<div class="col-xl-12 section-title-content">
					@if($passedContents['pp-heading'])
					<h1 class="section-title text-center">{{ $passedContents['pp-heading'] }}</h1>
					@endif					
					{!! $passedContents['pp-content'] !!}	
				</div>
			</div>
		</div>
		@endif
	</section>
	
@endsection

@if(!empty($settings->foothtml))
	@section('foothtml')
		@php
			$dom = new DOMDocument;
			$dom->loadHTML($settings->foothtml);
			$html = $dom->saveHTML();

			echo $html;
		@endphp
	@endsection
@endif