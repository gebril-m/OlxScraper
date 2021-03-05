
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Unify Admin Panel" />
    <meta name="keywords" content="Admin, Datatables, Dashboard, Bootstrap4, Sass, CSS3, HTML5, Responsive Dashboard, Responsive Admin Template, Admin Template, Best Admin Template, Bootstrap Template, Themeforest" />
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="shortcut icon" href="http://bootstrap.gallery/unify-dashboards/design-12/img/favicon.ico" />
    <title>Unify Admin Dashboard - Datatables</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    
    @include('includes.css')
  </head>
  <body>

    <!-- BEGIN .app-wrap -->
    <div class="app-wrap">
      <!-- BEGIN .app-heading -->
      @include('includes.head')
      <!-- END: .app-heading -->
      <!-- BEGIN .app-container -->
      <div class="app-container">
        
        @include('includes.aside')

        @yield('content')
      </div>
      <!-- END: .app-container -->
      @include('includes.footer')
    </div>
    <!-- END: .app-wrap -->

    @include('includes.js')

  </body>
</html>