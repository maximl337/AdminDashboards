<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Bootstrap Dashboards</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/home.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Bootstrap Dashboards</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li><a href="/browse">Browse</a></li>
                  <li><a href="/sell">Sell</a></li>
                  @if(Auth::check())

                    <li><a href="/user/{{ Auth::id() }}"> {{ Auth::user()->username }}</a></li>
                    <li><a href="/dashboard">Dashboard</a></li>
                    <li><a href="/auth/logout">Logout</a></li>
                  @else

                    <li><a href="/auth/login">Sign in</a></li>
                    <li><a href="/auth/register">Sign up</a></li>
                  @endif
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Marketplace for bootstrap dashboards</h1>
            <p class="lead">A marketplace to buy and sell Bootstrap based dashboards. Get a first class dashboard your business deserves or make money by selling world class themes.</p>
            <p class="lead">
              <a href="/browse" class="btn btn-lg btn-default">Browse</a>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p> &copy 2015. Anoop & Angad  </p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   
  </body>
</html>
