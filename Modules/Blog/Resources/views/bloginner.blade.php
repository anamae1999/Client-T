
@extends('blog::layouts.inner')

@section('title')
	{{ $post->meta_title ? $post->meta_title : $post->post_title }}
@endsection

@section('description')
	{{ trim($post->meta_description) }}
@endsection

@section('keywords', $post->meta_keyword)

@section('og-title', $post->meta_title)
@section('og-description')
	{!! strip_tags(Str::limit($post->meta_description)) !!}
@endsection
@section('og-image')
	{{ $post->post_image ? $post->post_image : '/images/image-placeholder.jpg' }}
@endsection

@section('content')	

@if($settings->cookie == 1)
	@include('cookieConsent::index')
@endif

	<section class="how-it-works gray-bg">
	    <div class="container wrapper padTB50">
	        <div class="row row-eq-height blog-inner-featured-img">
	            <div class="col-md-7 order-first">
			        <div class="row blog-inner-header">
			            <div class="col-md-12 blog-filter blog-inner-filter">
			                @if(Session::has('response'))
			                <div class="alert alert-success">
			                    {{ Session::get('response') }}
			                </div>
			                @endif
			                <ul class="mb-0">
			                    <li><a href="/blog">Blog</a></li>
			                    @if(isset($category->category))
			                    <li><a href="/blog/{{str_replace(' ','-',strtolower($category->category))}}">{{ ucwords($category->category) }}</a></li>
			                    @endif
			                    <li><span>{{ $post->post_title }}</span></li>
			                </ul>
			            </div>
			            <div class="col-md-12">
			                <p class="Lgreen"></p>
			                <h2 class="green">{{ $post->post_title }}</h2>
			                <div class="authorDate Lgreen">
			                    <span>By {{ $post->author_name }}</span> • <span class="blog-inner-date">{{ date_format($post->created_at, "d/m/Y") }}</span>
			                </div>
			            </div>
			        </div>
			        <div class="blog-inner-Fimage" style="background-image: url({{ $post->post_image ? $post->post_image : '/images/image-placeholder.jpg' }});">
	                	<img class="full" src="{{ $post->post_image ? $post->post_image : '/images/image-placeholder.jpg' }}" alt='{{ str_replace("-", " ", ucfirst(pathinfo($post->post_image ? $post->post_image : "/images/image-placeholder.jpg", PATHINFO_FILENAME))) }}'>
			        </div>
	            </div>
	            <div class="col-md-5 blog-inner-subsform blog-subsform-desktop">
	                <form action="https://tinysteps.us4.list-manage.com/subscribe/post" method="POST" class="get-in-touch text-center subs-form">
	                    <input type="hidden" name="u" value="64ddd322985f5887cb7fb1a38">
                        <input type="hidden" name="id" value="5cb186e3f5">
	                    <h2>Get free updates</h2>
	                    <p>Want parenting and nanny care hacks delivered straight to your inbox? Fill out this form:</p>
	                    <div class="form-group half-input">
	                        <input type="text" class="form-control" name="MERGE1" id="MERGE1" placeholder="First Name">
	                        <input type="text" class="form-control" name="MERGE2" id="MERGE2" placeholder="Last Name">
	                    </div>
	                    <div class="form-group">
	                        <input type="email" class="form-control" name="MERGE0" id="MERGE0" placeholder="Email Address">
	                    </div>
	                    <div class="gdpr-wrap-desk">
		                    <div id="mergeRow-gdpr" class="mergeRow gdpr-mergeRow">
		                        <div class="gdpr-content">
		                            <label id="gdpr-label">
		                                Marketing Permissions
		                            </label>
		                            <p id="gdpr-description">Please select all the ways you would like to hear from Tiny Steps:</p>
		                            <div>
		                                <ul class="interestgroup_field checkbox-group">
		                                    <li class="!margin-bottom--lv2 custom-checkbox-blog-inner">
		                                        <label class="checkbox" for="gdpr_16165">
		                                            <input type="checkbox" id="gdpr_16165" name="gdpr[16165]" value="Y" class="av-checkbox"><span>Email</span> </label>
		                                    </li>
		                                    <li class="!margin-bottom--lv2 custom-checkbox-blog-inner">
		                                        <label class="checkbox" for="gdpr_16169">
		                                            <input type="checkbox" id="gdpr_16169" name="gdpr[16169]" value="Y" class="av-checkbox"><span>Direct Mail</span> </label>
		                                    </li>
		                                    <li class="!margin-bottom--lv2 custom-checkbox-blog-inner">
		                                        <label class="checkbox" for="gdpr_16173">
		                                            <input type="checkbox" id="gdpr_16173" name="gdpr[16173]" value="Y" class="av-checkbox"><span>Customized Online Advertising</span> </label>
		                                    </li>
		                                </ul>
		                            </div>

		                            <p id="gdpr-legal">You can unsubscribe at any time by clicking the link in the footer of our emails. For information about our privacy practices, please visit our website.</p>
		                        </div>
		                        <div class="gdpr-footer">
		                            <a href="https://www.mailchimp.com/gdpr" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/mailchimp-gdpr.svg" alt="GDPR"></a>
		                            <p>We use Mailchimp as our marketing platform. By clicking below to subscribe, you acknowledge that your information will be transferred to Mailchimp for processing. <a href="https://mailchimp.com/legal/" target="_blank">Learn more about Mailchimp's privacy practices here.</a></p>
		                        </div>
		                    </div>	                    	
	                    </div>
	                    <div class="form-group btn-group full py-3">
	                        <button type="submit" class="custom-btn btn-green" name="submit" value="Subscribe">Subscribe</button>
	                    </div>
	                    @if(Session::has('response'))
	                    <div class="form-success white">
	                        {{ Session::get('response') }}
	                    </div>
	                    @endif
	                </form>
	            </div>
	        </div>
	        <div class="row blog-inner-content padTB50 justify-content-center">
	            <div class="col-md-8">
	                {!! $post->post_body !!}
	            </div>
	        </div>
	        <div class="row align-items-center blog-inner-author padTB50">
	            <div class="col-md-8">
	                <div class="row align-items-center">
	                    <div class="col-sm-3">
	                        <div class="author-img" style='background-image:url("{{ $post->author_pic ? $post->author_pic : asset("/images/avatar-placeholder.png") }}")'>
	                        </div>
	                    </div>
	                    <div class="col-sm-9">
	                        <h4>{{ $post->author_name }}</h4>
	                        <div>
	                            {!! $post->author_desc !!}
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-4 follow-us">
	                <h4>Share this article:</h4>
	                <ul class="mb-0">
	                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=#url" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
	                    <li><a href="http://www.twitter.com/intent/tweet?url=#url" target="_blank"><i class="fab fa-twitter"></i></a></li>
	                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=#url" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
	                </ul>
	            </div>
	        </div>
	        <div class="row blog-inner-comment">
	        	<div class="col-md-5 blog-inner-subsform blog-subsform-mobile">
	        		<form action="https://tinysteps.us4.list-manage.com/subscribe/post" method="POST" class="get-in-touch text-center subs-form">
	                    <input type="hidden" name="u" value="64ddd322985f5887cb7fb1a38">
                        <input type="hidden" name="id" value="5cb186e3f5">
	                    <h2>Get free updates</h2>
	                    <p>Want parenting and nanny care hacks delivered straight to your inbox? Fill out this form:</p>
	                    <div class="form-group half-input">
	                        <input type="text" class="form-control" name="MERGE1" id="MERGE1" placeholder="First Name">
	                        <input type="text" class="form-control" name="MERGE2" id="MERGE2" placeholder="Last Name">
	                    </div>
	                    <div class="form-group">
	                        <input type="email" class="form-control" name="MERGE0" id="MERGE0" placeholder="Email Address">
	                    </div>
	                    <div class="gdpr-wrap-mob">	                    	
	                    </div>	                   
	                    <div class="form-group btn-group full py-3">
	                        <button type="submit" class="custom-btn btn-green" name="submit" value="Subscribe">Subscribe</button>
	                    </div>
	                    @if(Session::has('response'))
	                    <div class="form-success white">
	                        {{ Session::get('response') }}
	                    </div>
	                    @endif
	                </form>
	            </div>
	            <div class="col-md-12 padT50">
	                <div class="blog-inner-comment-wrap pad30">
	                    @if(count($post->comments) > 0) @foreach($post->comments as $comment)

	                    <div class="blog-comment-wrap padB30">
	                        <div class="each-comment-wrap">
	                            @if($comment->user_id == 0)
	                            <h4>{{ $comment->guest->name }} <span class="blog-comment-date">{{$comment->created_at->diffForHumans()}}</span></h4> @else
	                            <h4>{{ $comment->user->first_name }} <span class="blog-comment-date">{{$comment->updated_at->diffForHumans()}}</span></h4> @endif

	                            <p id="comment{{$comment->id}}">{{ $comment->comment }}</p>

	                            @if(Auth::check()) @if(Auth::user()->id == $comment->user_id || Auth::user()->role == 'admin')
	                            <div class="comment-actions">
	                                <form id="updateForm{{$comment->id}}" class="hidden pb-4" method="POST" action='{{url("blog/update-comment/{$comment->id}")}}'>
	                                    @csrf
	                                    <div class="mb-2">
	                                        <textarea class="update-comment full form-control" name="updated_comment">{{ $comment->comment }}</textarea>
	                                    </div>
	                                    <button type="submit" class="custom-btn btn-white">Update</button>
	                                </form>
	                                <form id="deleteForm{{$comment->id}}" method="POST" action='{{url("blog/comment/{$comment->id}/delete")}}' class="pb-4">
	                                    @csrf @method('DELETE')
	                                    <button type="button" class="custom-btn btn-white edt-comment" data-id="{{$comment->id}}">Edit</button>
	                                    <button class="dlt-comment custom-btn btn-green btn-green-whitebg">Delete</button>
	                                </form>
	                            </div>
	                            @endif @endif
	                        </div>
	                    </div>

	                    @endforeach @else
	                    <p>No comments</p>
	                    @endif

	                </div>
	            </div>

	            <div class="col-md-12 padT50">
	                <form id="commentForm" class="comment-form" method="POST" action='{{ url("blog/add-comment/{$post->id}") }}'>
	                    @csrf
	                    <h3>Leave a reply</h3>
	                    <p>Your email address will not be published. Required fields are marked *</p>
	                    <div class="form-group">
	                        <label for="comment">Comment</label>
	                        <textarea name="comment" class="form-control"></textarea>
	                    </div>
	                    <div class="form-group">
	                        <div class="row">
	                            <div class="col-md-4">
	                                <label for="name">Name *</label>
	                                <input name="name" type="text" required="required" class="form-control" @if(Auth::check()) value="{{Auth::user()->first_name}}" disabled="disabled" @endif>
	                            </div>
	                            <div class="col-md-4">
	                                <label for="email">Email *</label>
	                                <input name="email" required="required" type="text" class="form-control" @if(Auth::check()) value="{{Auth::user()->email}}" disabled="disabled" @endif>
	                            </div>
	                            <div class="col-md-4">
	                                <label for="website">Website</label>
	                                <input name="website" type="text" class="form-control">
	                            </div>

	                        </div>
	                    </div>
	                    <div class="form-group padT15 padB50">
	                        @if(!old('registerForm')) @error('g-recaptcha-response')
	                        <span class="help-block error" role="alert">
									<strong>{{ $message }}</strong>
								</span> @enderror @endif @if(config('services.google.captcha_key'))
	                        <div class="g-recaptcha" data-sitekey="{{config('services.google.captcha_key')}}">
	                        </div>
	                        @endif
	                        <button type="submit" class="custom-btn btn-green btn-green-whitebg">Post Comment</button>
	                    </div>
	                </form>
	            </div>
	        </div>
	        <div class="row">
	            <div class="col-md-12">
	                <a href="/blog" class="back-to-list">back to list</a>
	                @if(Auth::check() && Auth::user()->role == 'admin')
	                <div>
		                <a href="/admin/pages" class="back-to-list">back to pages</a>	                	
	                </div>
	                @endif
	            </div>
	        </div>
	    </div>
	</section>
	@if(Auth::guest())
	<section class="brown-bg register-now-section">
		<div class="container padTB50">
			<div class="row align-items-center text-center">
				<div class="col-md-7">
					<p>Ready to find a great sitter?</p>
				</div>
				<div class="col-md-5 register-now-button text-center">
					<a class="custom-btn btn-green" href="" data-toggle="modal" data-target="#sign-up-modal" id="sign-up">Register now</a>
				</div>
			</div>
		</div>
	</section>
	@endif
@endsection

