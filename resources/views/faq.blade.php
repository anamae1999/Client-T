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

<section class="">
	@if($showSection['faq-main'] == 'show')
	<div class="container wrapper padT50">
		<div class="row">
			<div class="col-xl-12 text-center section-title-content">
				<h2 class="section-title">{{ $passedContents['faq-main-title'] }}</h2>
				{!! $passedContents['faq-main-content'] !!}
			</div>
		</div>
	</div>
	@endif
	<div class="container wrapper padB50">
		<div class="row faq-tabs">
			<div class="col-xl-4 col-md-4 pb-3">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<ul class="full nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item full text-center">
					    <a class="nav-link active" id="v-pills-nanny-tab" data-toggle="pill" href="#v-pills-nanny" role="tab" aria-controls="v-pills-nanny" aria-selected="true">For Nanny</a>
					  </li>
					  <li class="nav-item full text-center">
					    <a class="nav-link" id="v-pills-parent-tab" data-toggle="pill" href="#v-pills-parent" role="tab" aria-controls="v-pills-parent" aria-selected="false">For Parent</a>
					  </li>
					  <li class="nav-item full text-center">
				  		<a class="nav-link" id="v-pills-about-tab" data-toggle="pill" href="#v-pills-about" role="tab" aria-controls="v-pills-about" aria-selected="false">About Tiny Steps</a>
					  </li>
					  <li class="nav-item full text-center">
					    <a class="nav-link" id="v-pills-account-privacy-tab" data-toggle="pill" href="#v-pills-account-privacy" role="tab" aria-controls="v-pills-account-privacy" aria-selected="false">Account and Privacy</a>
					  </li>
					</ul>
				</div>
			</div>
			<div class="col-xl-8 col-md-8">
				<div class="tab-content" id="v-pills-tabContent">
				  <div class="tab-pane fade show active" id="v-pills-nanny" role="tabpanel" aria-labelledby="v-pills-nanny-tab">
				  	<h4 class="text-center">For Nanny</h4>
			  		<div id="nann-accordion">

			  			@if(count($faqsNanny) > 0)
		                    @foreach($faqsNanny as $faqNanny)
		                    	<div class="card">
								    <div class="card-header" id="heading{{ $faqNanny->id }}">
								      <h5 class="mb-0">
								        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $faqNanny->id }}" aria-expanded="true" aria-controls="collapse{{ $faqNanny->id }}">
								          {{ $faqNanny->question }}
								        </button>
								      </h5>
								    </div>
								    <div id="collapse{{ $faqNanny->id }}" class="collapse" aria-labelledby="heading{{ $faqNanny->id }}" data-parent="#nann-accordion">
								      	<div class="card-body">
								        	{!! $faqNanny->answer !!}
								      	</div>
								    </div>
								</div>
		                    @endforeach
	                    @endif
						  
						  
					</div>
				  </div>
				  <div class="tab-pane fade" id="v-pills-parent" role="tabpanel" aria-labelledby="v-pills-parent-tab">
				  	<h4 class="text-center">For Parent</h4>
			  		<div id="parent-accordion">
			  			@if(count($faqsParent) > 0)
		                    @foreach($faqsParent as $faqParent)
		                    	<div class="card">
								    <div class="card-header" id="heading{{ $faqParent->id }}">
								      <h5 class="mb-0">
								        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $faqParent->id }}" aria-expanded="true" aria-controls="collapse{{ $faqParent->id }}">
								          {{ $faqParent->question }}
								        </button>
								      </h5>
								    </div>
								    <div id="collapse{{ $faqParent->id }}" class="collapse" aria-labelledby="heading{{ $faqParent->id }}" data-parent="#parent-accordion">
								      	<div class="card-body">
								        	{!! $faqParent->answer !!}
								      	</div>
								    </div>
								</div>
		                    @endforeach
	                    @endif				  
					</div>
				  </div>
				  <div class="tab-pane fade" id="v-pills-about" role="tabpanel" aria-labelledby="v-pills-about-tab">
				  	<h4 class="text-center">About Tiny Steps</h4>
			  		<div id="about-accordion">
						@if(count($faqsAbout) > 0)
		                    @foreach($faqsAbout as $faqAbout)
		                    	<div class="card">
								    <div class="card-header" id="heading{{ $faqAbout->id }}">
								      <h5 class="mb-0">
								        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $faqAbout->id }}" aria-expanded="true" aria-controls="collapse{{ $faqAbout->id }}">
								          {{ $faqAbout->question }}
								        </button>
								      </h5>
								    </div>
								    <div id="collapse{{ $faqAbout->id }}" class="collapse" aria-labelledby="heading{{ $faqAbout->id }}" data-parent="#about-accordion">
								      	<div class="card-body">
								        	{!! $faqAbout->answer !!}
								      	</div>
								    </div>
								</div>
		                    @endforeach
	                    @endif
						</div>
					</div>
				  <div class="tab-pane fade" id="v-pills-account-privacy" role="tabpanel" aria-labelledby="v-pills-account-privacy-tab">
				  	<h4 class="text-center">Account and Privacy</h4>
			  		<div id="account-privacy-accordion">
			  			@if(count($faqsPrivacy) > 0)
		                    @foreach($faqsPrivacy as $faqPrivacy)
		                    	<div class="card">
								    <div class="card-header" id="heading{{ $faqPrivacy->id }}">
								      <h5 class="mb-0">
								        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $faqPrivacy->id }}" aria-expanded="true" aria-controls="collapse{{ $faqPrivacy->id }}">
								          {{ $faqPrivacy->question }}
								        </button>
								      </h5>
								    </div>
								    <div id="collapse{{ $faqPrivacy->id }}" class="collapse" aria-labelledby="heading{{ $faqPrivacy->id }}" data-parent="#account-privacy-accordion">
								      	<div class="card-body">
								        	{!! $faqPrivacy->answer !!}
								      	</div>
								    </div>
								</div>
		                    @endforeach
	                    @endif	 
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@if($showSection['faq-cta'] == 'show')
<section class="brown-bg register-now-section">
	<div class="container wrapper padTB50">
		<div class="row align-items-center text-center">
			<div class="col-md-7">
				{!! $passedContents['faq-cta-title'] !!}
			</div>
			<div class="col-md-5 register-now-button text-center">
				<a class="custom-btn btn-green" href="{{ $passedContents['faq-cta-btn-link'] }}">{{ $passedContents['faq-cta-btn-text'] }}</a>
			</div>
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