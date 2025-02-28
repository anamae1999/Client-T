@extends('blog::layouts.master')

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
	<section class="how-it-works gray-bg">
		<div class="container wrapper text-center padTB50">

			@if($showSection['blog-main'] == 'show')
			<div class="row">
				<div class="col-xl-12 section-title-content">
					<h2 class="section-title">{{ $passedContents['blog-main-title'] }}</h2>
					{!! $passedContents['blog-main-content'] !!}
				</div>
			</div>
			@endif

			@if($showSection['blog-filter'] == 'show')
			<div class="row">
				<div class="col-xl-12 col-sm-12 blog-filter section-title-content">
					<ul class="mb-0">
						<li><em>{{ $passedContents['blog-filter-text'] }}</em></li>
						<li><a href="/blog">All</a></li>
						@if(count($categories)>0)
							@foreach($categories as $category)
							<li><a href="/blog/{{str_replace(' ','-',strtolower($category->category))}}">{{ucwords($category->category)}}</a></li>
							@endforeach
						@endif
					</ul>
				</div>
			</div>
			@endif

			<div class="row blog-list justify-content-center">
				@if(count($posts) > 0)
                    @foreach($posts as $post)
						<div class="col-sm-6 col-lg-4 blog-item padB50">
							<a href='{{ url("blog/inner/{$post->slug}") }}' class="blog-item-img-link" style="background-image: url({{ $post->post_image ? $post->post_image : asset('/images/image-placeholder.jpg') }});"></a>
							<div class="blog-item-inner">
								<div class="blog-title">
									<h4><a class="green" href='{{ url("blog/inner/{$post->slug}") }}'>{{ $post->post_title }}</a></h4>
								</div>
								<div class="blog-details">
									<p class="Lgreen">{{ $post->author_name }} | {{ date_format($post->created_at, "d/m/Y") }}</p>
								</div>
								<div class="blog-content padTB25">
									@php
										$paragraph = strip_tags($post->post_body, "<p>");
									@endphp
									@if(strlen($paragraph) > 180)	
										{!! substr($paragraph, 0, strpos(wordwrap($paragraph, 180), "\n")) !!}
										@if(strpos($paragraph,"\n") > 180)
										<span>...</span>	
										@endif
									@else 
										{!! $paragraph !!}
									@endif						
								</div>								
							</div>
							
							<div class="blog-cta">
								<a class="custom-btn btn-green btn-green-whitebg mt-3" href='{{ url("blog/inner/{$post->slug}") }}'>Read More</a>
							</div>
						</div>
					@endforeach
				@else					
                    <p>No Posts</p>
                @endif  
			</div>
			<div class="row">
				<div class="col-xl-12 text-center">
					<nav aria-label="..." class="d-flex justify-content-center blog-pagination">
					  {{ $posts->links() }}
					</nav>
				</div>
			</div>
		</div>
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