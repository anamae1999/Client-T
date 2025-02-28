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
		@if($showSection['cookie-statement'] == 'show')
		<div class="container wrapper">
			<div class="row">
				<div class="col-xl-12 section-title-content">
					@if($passedContents['cs-heading'])
					<h1 class="section-title text-center">{{ $passedContents['cs-heading'] }}</h1>
					@endif
					{!! $passedContents['cs-content'] !!}	
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