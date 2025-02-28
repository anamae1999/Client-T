<div class="js-cookie-consent cookie-consent">

	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-7 col-xl-8">
				<span class="cookie-consent__message">					
			        {!! trans('cookieConsent::texts.message') !!}
			    </span>
			</div>
			<div class="col-lg-5 col-xl-4 text-right">
				<div class="cookie-btn-wrap">
				    <button class="custom-btn btn-white cookie-settings-btn" data-toggle="modal" data-target="#cookie-settings-modal">Cookie Settings</button>

				    <button class="js-cookie-consent-agree cookie-consent__agree">
				        {{ trans('cookieConsent::texts.agree') }}
				    </button>    	
			    </div>
			</div>
		</div>
	</div>
</div>
