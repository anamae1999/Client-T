<!doctype html>
<html lang="en">
  <head>
    @if(isset($_COOKIE['tinysteps_ga_cookie_consent']) && $_COOKIE['tinysteps_ga_cookie_consent'] == 1)
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src='https://www.googletagmanager.com/gtag/js?id={{config("services.google.analytics_id")}}'></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '{{config("services.google.analytics_id")}}');
        </script>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    <title>@yield('title')</title>

    @if(isset($canonical))
    <link rel="canonical" href='{{ url("/".$canonical) }}' />
    @endif

    <!-- Fontawesome CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- Slick CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap" rel="stylesheet">
    <!-- Bootstrap Style -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Main Styles -->
    <link href="{{ asset('css/main.min.css') }}" rel="stylesheet">
    <!-- Utilities -->
    <link href="{{ asset('css/utilities.min.css') }}" rel="stylesheet">
    <!-- tinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin" defer></script>
    <!-- Google Captcha -->
    <script src='https://www.google.com/recaptcha/api.js' defer></script>

    @yield('headhtml')
  </head>
  <body>

    <main>     
      @include('internals.header')

      @yield('content')

      @include('internals.footer')

        <div class="modal fade cookie-settings-modal" id="cookie-settings-modal" tabindex="-1" role="dialog" aria-labelledby="cookie-settings-modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header cda34f-bg brown">
                        <div class="container">
                            <div class="row align-items-center">                                
                                <div class="modal-header-right">
                                    <h4 class="modal-title" id="">Cookie Settings</h4>                                    
                                </div>
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="cookie-accordion" class="cookie-accordion">
                            @if(count($cookieSettings) > 0)
                                @foreach($cookieSettings as $cookieSetting)
                                    <div class="card">
                                        <div class="card-header" id="heading-cookie{{$cookieSetting->id}}">
                                          <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse-cookie{{$cookieSetting->id}}" aria-expanded="true" aria-controls="collapse-cookie{{$cookieSetting->id}}">
                                                {{$cookieSetting->title}}
                                            </button>
                                          </h5>
                                        </div>
                                        <div id="collapse-cookie{{$cookieSetting->id}}" class="collapse" aria-labelledby="heading-cookie{{$cookieSetting->id}}" data-parent="#cookie-accordion">
                                            <div class="card-body">
                                                {!!$cookieSetting->content!!}
                                            </div>
                                        </div>
                                    </div> 
                                @endforeach
                            @endif
                            <div class="card">
                                <div class="card-header" id="analytics-cookie">
                                  <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse-analytics-cookie" aria-expanded="true" aria-controls="collapse-cookie1">
                                        Analytics Cookies
                                    </button>
                                  </h5>
                                </div>
                                <div id="collapse-analytics-cookie" class="collapse" aria-labelledby="analytics-cookie" data-parent="#cookie-accordion">
                                    <div class="card-body">  
                                        <p>These cookies allows us to understand how visitors are interacting and using our website. We use these for gathering information such as to count site and page visits, identify traffic sources, and to track which links you click on. They help us know which pages are the most and least popular and see how visitors move around the site.</p>
                                        <p>The information collected are used as basis for implementing further improvement on our website.</p>
                                        <p>If you choose to opt-out from these cookies, we will not know when you have visited our site nor the pages you have visited.</p>
                                        <div class="cookie-toggle-wrap text-right mt-3">
                                            <span>Accept this cookie</span>
                                            <label class="switch m-0 mx-3">
                                                <input id="cookie-toggle" type="checkbox" name="cookie-toggle" checked="checked">
                                                <span class="slider round"></span>
                                            </label>
                                        </div> 
                                    </div>
                                </div>
                            </div>  
                                                           
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <a href="/cookie-statement" class="green">Cookie Statement</a>
                    </div>
                </div>
            </div>
        </div>
  </main>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" defer></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" defer></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js" defer></script>
    <!-- BOOTSTRAP -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" defer></script>

    <!-- SLICK -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js" defer></script>

    <!-- Main JS -->
    <script type="text/javascript" src="{{ asset('js/main.min.js') }}" defer></script>

    <!-- Defer images -->
    <script>
        function init() {
        var imgDefer = document.getElementsByTagName('img');
        for (var i=0; i<imgDefer.length; i++) {
        if(imgDefer[i].getAttribute('data-src')) {
        imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
        } } }
        window.onload = init;
    </script>
    
    @yield('foothtml')

    @if(!empty(Session::get('url')['intended']) && strpos(Session::get('url')['intended'],'verify'))
        <div class="modal-backdrop fade show"></div>
    @endif
  </body>
</html>