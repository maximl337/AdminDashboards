<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <title>Admin Dashboards</title>
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">
  
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">   
  
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/ionicons.css" rel="stylesheet">
  <link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" media="all" />

  
  <link href="css/style.css" rel="stylesheet">
  
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Montserrat:400,700">
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,300,200,600,600italic,700">

  <!--[if lt IE 9]>
    <script src="./js/html5shiv.js"></script>
    <script src="./js/respond.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <![endif]-->
  
</head>
<body data-spy="scroll" data-target=".navigation">

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand text-logo" href="/"><img src="img/logo.png" alt="" title="" class="logo" /> Admin Dashboards</a>
          </div>
        </div>
        <div class="col-md-4 border-left border-right">
          <form class="top-search" action="#">
            <div class="input-group">
              <input type="text" name="s" class="form-control" placeholder="Search for templates">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit">
                <i class="ion-ios-search-strong"></i></button>
              </span>
            </div>
          </form>
        </div>
        <div class="col-md-5">
          <div class="navigation navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="tour.html">Tour</a></li>
              <li><a href="how-it-works.html">How it works</a></li>

              @if(Auth::check())

                <li><a href="/user/{{ Auth::id() }}"> @{{ Auth::user()->username }}</a></li>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="/auth/logout">Logout</a></li>

              @else

                <li><a href="/auth/login">Sign In</a></li>
                <li class="/auth/register"><a href="join.html">Join Now</a></li>
              @endif
             
            </ul>
          </div>
        </div>
      
      </div>
    </div>
  </nav>
  
  <section id="top-banner" class="section padding-120 bg-teal">
    <div class="container">
      <div class="row banner-content">
      
      </div>
    </div>
  </section>

  <!-- Partners -->
  <section id="partners" class="section padding-50 bg-white">
    <div class="container">
      <div class="row">
      
      </div>
    </div>
  </section>
  
  
  <section id="intro" class="section bg-grey">
    <div class="container">
      
      <div class="row">
        <div class="col-md-8">
        
          <div class="row">

            @foreach($templates as $template)
            <div class="col-md-6">
              <div class="item-listing">
                <div class="img-hover">
                  <div class="item-price"><span>$</span> {{ $template->price }}</div>
                  <img src="{{ $template->screenshot }}" alt="" title="" class="img-responsive" />
                  <div class="img-overlay">
                    <a href="#" class="btn-default btn-large">Preview</a>
                    <a href="#" class="btn-default btn-large">Buy Now</a>
                  </div>
                </div>
                <div class="item-listing-meta">
                  <h4><a href="#">{{ $template->name }}</a></h4>
                  <ul>
                    <li><i class="ion-ios-cart-outline"></i> 100 Sales</li>
                    <li><i class="ion-calendar"></i> Released 3 months ago</li>
                  </ul>
                </div>
              </div>
            </div>        
            @endforeach

            

          </div>

        

          <div class="row">
            <div class="col-md-12 text-left">
              <!-- <ul class="pagination">
                <li><a href="#" aria-label="Previous"><i class="ion-ios-arrow-left"></i><i class="ion-ios-arrow-left"></i></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#" aria-label="Next"><i class="ion-ios-arrow-right"></i><i class="ion-ios-arrow-right"></i></a></li>
              </ul> -->
              {!! $templates->render() !!}
            </div>
          </div>
          
        </div>
        <div class="col-md-4">
          
          <div class="home-filter">
            <div class="row">
              <div class="dropdown">
                <select>
                  <option>Sort by Price..</option>
                  <option>Highest First</option>  
                  <option>Lowest First</option>
                </select>
              </div>
            </div>
          </div>  
          
          <h4>Recently Launched</h4>
          <ul class="recently-launched row">

            @foreach($recent as $template)
            <li class="col-md-6">
              <div class="thumb">
                <img src="{{ $template->screenshot }}" class="img-responsive" title="" alt="" />
                <h4><a href="#">{{ $template->name }}</a></h4>
              </div>
            </li>
            @endforeach

          </ul>
        </div>
      </div>
      
    </div>
  </section>
  
  <section class="section bg-dark text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3>Most Popular</h3>
          <ul class="recently-launched row">

            @foreach($popular as $template)

              <li class="col-md-4">
                <div class="thumb">
                  <img src="{{ $template->screenshot }}" class="img-responsive" title="" alt="" />
                  <h4><a href="#">{{ $template->name }}</a></h4>
                </div>
              </li>

            @endforeach

          </ul>
        </div>
      </div>
    </div>
  </section>
  
  <section class="section how-it-works">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <h3>How it works</h3>
          <ul class="steps-list">
            <li>
              <span>1</span>
              <p>Vestibulum ante ipsum primis in faucibus orci luctus etel ultrices posuere cubilia Curae.</p>
            </li>
            <li>
              <span>2</span>
              <p>Nunc eu lacus massa, et accumsan erat. Phasellus auct malesuada odio.</p>
            </li>
            <li>
              <span>3</span>
              <p>Proin viverra, felis eget feugiat dignissim, ante ante odio pulvinas.</p>
            </li>
          </ul>         
        </div>
        <div class="col-md-3">
          <h3>Sell you designs</h3>
          <p>Open your shop and reach out potential buyers</p>
          <ul class="list-arrows">
            <li>Earn 70% On Each Sale</li>
            <li>No Exclusivity Lock-In</li>
            <li>Set Your Own Prices</li>
          </ul>
          <a href="/sell" class="btn btn-default btn-teal">Start Selling</a>
        </div>
        <div class="col-md-4">
          <h3>Stay Connected</h3>
          <p>If you would like updates about new templates, please register to our mailing list. </p>
          <form class="subscribe-form" action="#" method="post">
            <div class="input-group">
              <input class="form-control bottom-form-input" type="email" name="bottom-email" placeholder="Email Address">
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default btn-submit">Subscribe</button>
              </div>
            </div>
          </form>
          <ul class="social">
            <li><a href="#"><i class="icon ion-social-twitter-outline"></i></a></li>
            <li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
            <li><a href="#"><i class="icon ion-social-dribbble-outline"></i></a></li>
            <li><a href="#"><i class="icon ion-social-googleplus-outline"></i></a></li>
            <li><a href="#"><i class="icon ion-social-linkedin-outline"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  
  <section class="footer footer-top">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <h3>Admin Dashboards</h3>
          <p>A brand new marketplace for Twitter Bootstrap templates. Our aim is to provide the best service for both buyers and sellers of Bootstrap Themes. We provide a direct helpful feedback to designers, and have an excellent affilate program for everyone.</p>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <h3>Company</h3>
          <ul class="quick-links">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Our Team</a></li>
            <li><a href="#">Jobs<span class="label label-info">We're hiring!</span></a></li>           
          </ul>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <h3>Terms</h3>
          <ul class="quick-links">
            <li><a href="#">Disclaimer</a></li>
            <li><a href="#">Terms &amp; Conditions</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-md-2 col-sm-3 col-xs-6">
          <h3>Documentation</h3>
          <ul class="quick-links">
            <li><a href="#">Product Help</a></li>
            <li><a href="#">Developer API</a></li>
            <li><a href="#">Product Markdown</a></li>             
          </ul>
        </div>
      </div>
    </div>
  </section>
  
  <footer class="footer footer-sub">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <p>&copy; Admin Dashboards. All Right Reserved.</p>
        </div>
        <div class="col-md-6 col-sm-12">
          <p class="copyright">Made with <i class="ion-heart"></i> by <a href="#"> _Red Mesa Software</a></p>
        </div>
      </div>
    </div>
  </footer>
  
  <a href="#" class="scroll-up"><i class="ion-android-arrow-up"></i></a>
  
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
  <script type="text/javascript">window.jQuery || document.write('<script src="js/jquery-2.1.0.min.js"><\/script>')</script>
  <script src="/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="/js/modernizr.min.js" type="text/javascript"></script>
  <script src="/js/jquery.prettyPhoto.js" type="text/javascript" ></script>
  <script src="/js/custom.js" type="text/javascript"></script>

</body>
</html>
