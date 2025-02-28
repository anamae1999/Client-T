<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nanny Dashboard</title>

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
    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- tinyMCE -->
    <script src="{{ asset('plugins/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    

  </head>
  <body onbeforeunload="return nullifyTalk()">
        <main class="dash">
            @include('admin::internals.headerdashboard')

            @yield('content')

            @include('admin::internals.footerdashboard')
        </main>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <!-- SLICK -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>

    <!-- Main JS -->
    <script type="text/javascript" src="{{ asset('js/main.min.js') }}"></script>

    <script type="text/javascript">
        function nullifyTalk() {
            jQuery.ajax({
                type: 'GET',
                url: '/nullify-talk'
            });
        }
    </script>
    </body>
</html>