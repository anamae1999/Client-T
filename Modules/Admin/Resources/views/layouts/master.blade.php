<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Dashboard</title>

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
    <script src="{{ asset('plugins/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <!-- CodeFlask Editor -->
    <script src="https://unpkg.com/codeflask/build/codeflask.min.js"></script>

   
  </head>
  <body>
    <main class="dash">
        @include('admin::internals.headerdashboard')

        @yield('content')

        @include('admin::internals.footerdashboard')
    </main>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

    <!-- DATE PICKER -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script> -->
    
    <!-- BOOTSTRAP -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- SLICK -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>

    <!-- Main JS -->
    <script type="text/javascript" src="{{ asset('js/main.min.js') }}"></script>

    <script>
        // CodeFlask Editor | Reference: https://github.com/kazzkiq/CodeFlask -VLSJ
          const flaskhead = new CodeFlask(
            '#head-editor',
          { 
             language: 'html',
             lineNumbers: true 
          });
          const flaskfoot = new CodeFlask(
            '#foot-editor',
          { 
             language: 'html',
             lineNumbers: true 
          });
          // flaskhead.onUpdate((code) => {
          //   var headhtml = $('#head-editor textarea').val();
          //   $('input[name="headhtml"]').val(headhtml);
          // });

          var newHeadHml = jQuery('#head-editor').data('headhtml');
          var newFootHml = jQuery('#foot-editor').data('foothtml');

          flaskhead.updateCode(newHeadHml);
          flaskfoot.updateCode(newFootHml);

          jQuery('#head-editor textarea').attr('name','headhtml');
          jQuery('#foot-editor textarea').attr('name','foothtml');

    </script>
    </body>
</html>