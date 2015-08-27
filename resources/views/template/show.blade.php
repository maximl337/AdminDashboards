@extends('layout.main')

@section('content')

    <section id="page-header" class="section padding-30 paddingtop-100 bg-teal">
        <div class="container">
            <div class="row headline white-text">
                <div class="col-md-12">
                    <h2>{{ $data['template']->name }}</h2>
                </div>
            </div>
        </div>
    </section>

    <section id="main-content" class="section bg-grey">
        <div class="container">
            <div class="row">
                <main class="col-md-8">
                    <div class="content">
                        <img src="{{ $data['template']->screenshot }}" alt="{{ $data['template']->name }}" title="{{ $data['template']->name }}" class="img-responsive screenshot"/>
                        <h1>HTML Ipsum Presents</h1>                                   
                        <p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>

                        <h2>Header Level 2</h2>
                        <ol>
                           <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                           <li>Aliquam tincidunt mauris eu risus.</li>
                        </ol>

                        <blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>

                        <h3>Header Level 3</h3>
                        <ul>
                           <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                           <li>Aliquam tincidunt mauris eu risus.</li>
                        </ul>

    <pre><code>
    #header h1 a { 
        display: block; 
        width: 300px; 
        height: 80px; 
    }
    </code></pre>
                    </div>
                </main>
                <aside class="col-md-4">
                    <div class="pricing">
                        <h3>{{ $data['template']->name }}</h3>

                    <form class="pricing-form" method="post" action="#">
                        <ul>
                            <li class="form-group">
                                <label class="radio">
                                    <input type="radio" name="single-license" id="single-license" value="single-license" data-toggle="radio">
                                    <span class="license-type">Single License</span>
                                    <span class="license-price">{{ $data['template']->price }}</span>
                                    <span class="clearfix"></span>
                                </label>
                            </li>
                            <li class="form-group">
                                <label class="radio">
                                    <input type="radio" name="single-license" id="single-license" value="single-license" data-toggle="radio">
                                    <span class="license-type">Multiple License</span>
                                    <span class="license-price">$200</span>
                                    <span class="clearfix"></span>
                                </label>
                            </li>
                            <li class="form-group">
                                <label class="radio">
                                    <input type="radio" name="single-license" id="single-license" value="single-license" data-toggle="radio">
                                    <span class="license-type">Extended License</span>
                                    <span class="license-price">$400</span>
                                    <span class="clearfix"></span>
                                </label>
                            </li>
                        </ul>
                        <button type="submit" class="hidden btn btn-default btn-buy-large">Buy Now</button>
                        @if($data['template']->approved == 1)

                        <script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant={{ getenv('PAYPAL_MERCHANT_ACCOUNT_ID') }}"
                                data-button="buynow" 
                                data-name="{{ $data['template']->name }}" 
                                data-quantity="1" 
                                data-amount="{{ $data['amount'] }}" 
                                data-currency="CAD" 
                                data-shipping="0" 
                                data-tax="3.50" 
                                data-callback="{{ url('/') }}/paypal/callback" 
                                data-custom="{{ $data['license_type'] }}"
                                data-env="sandbox"
                                data-notify_url="{{ url('/') }}/paypal/ipn"
                                data-item_number="{{ $data['template']->id }}"
                            ></script>
                            <br />

                        @else

                            <p class="alert alert-warning text-center"> Approval Pending </p>
                        @endif
                    </form>
                    <br />
                    <ul class="social-share">
                        <li><a href="#" class="tw"><i class="icon ion-social-twitter-outline"></i>Tweet</a></li>
                        <li><a href="#" class="fb"><i class="icon ion-social-facebook"></i>Like</a></li>
                        <li><a href="#" class="goog"><i class="icon ion-social-googleplus-outline"></i>Share</a></li>
                    </ul>
                    
                    </div>                  
                    <ul class="item-details-table">
                        <li class="price-row">
                            <dl>
                                <dt>Price</dt>
                                <dd>$20.00</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Date released</dt>
                                <dd>7 May, 2015</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Layout</dt>
                                <dd>Responsive</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Type</dt>
                                <dd>Angular JS </dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Pre-processor</dt>
                                <dd>Sass, Lass </dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Columns</dt>
                                <dd>4</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Files Included</dt>
                                <dd>Layered PSD, HTML Files, CSS Files, JS Files</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Browser Compatibility</dt>
                                <dd>IE 9+, Firefox 14+, Chrome 19+, Safari 5.1+, Opera 12+</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Tags</dt>
                                <dd><a href="#">Minimalistic</a>, <a href="#">Multipurpose</a>, <a href="#">Angular JS</a>, <a href="#">Minimalistic</a></dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Item ID</dt>
                                <dd>#12233</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Author</dt>
                                <dd><a href="#">Simplesphere</a></dd>
                            </dl>
                        </li>
                    </ul>               
                </aside>
            </div>
        <div>
    </section>
@stop