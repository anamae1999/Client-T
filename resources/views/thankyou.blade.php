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
	
	@if($showSection['thank-you'] == 'show')
		<section class="padTB80 banner" @if($passedContents['ty-background']) style="background-image: url({{ $passedContents['ty-background'] }});" @endif>
			<div class="container wrapper">
				<div class="row">
					<div class="col-xl-12 section-title-content">
						@if($passedContents['ty-heading'])
						<h1 class="section-title text-center">{{ $passedContents['ty-heading'] }}</h1>
						@endif					
						{!! $passedContents['ty-content'] !!}	
					</div>

					@if(Auth::check() && (Auth::user()->role == 'sitter' || Auth::user()->role == 'parent'))
					<div class="col-12 text-center">
						@if($passedContents['ty-cta-btn-text'])
							@if(Auth::user()->role == 'sitter')
								<a href="/nannies/settings" class="custom-btn btn-white">
							@elseif(Auth::user()->role == 'parent')
								<a href="/parents/settings" class="custom-btn btn-white">
							@endif
							{{ $passedContents['ty-cta-btn-text'] }}</a>
						@endif						
					</div>
					@endif
				</div>
			</div>		
		</section>
	@endif
	
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