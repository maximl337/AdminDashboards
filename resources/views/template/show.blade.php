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

                        <div class="description">
                            {{ $data['template']->description }}
                        </div>

                    </div>
                </main>
                <aside class="col-md-4">
                    <div class="pricing">
                        <h3>{{ $data['template']->name }}</h3>

                    <form class="pricing-form" method="post" action="#">
                        <ul>
                            <li class="form-group">
                                <label class="radio">
                                    <input type="radio" name="license_type" id="single-license" value="single-license" data-toggle="radio" checked="checked">
                                    <span class="license-type">Single License</span>
                                    <span class="license-price">${{ $data['template']->price }}</span>
                                    <span class="clearfix"></span>
                                </label>
                            </li>
                            
                            @if(!empty($data['template']->multiple_price))
                            <li class="form-group">
                                <label class="radio">
                                    <input type="radio" name="license_type" id="single-license" value="multiple" data-toggle="radio">
                                    <span class="license-type">Multiple License</span>
                                    <span class="license-price">$200</span>
                                    <span class="clearfix"></span>
                                </label>
                            </li>
                            @endif

                            @if(!empty($data['template']->extended_price))
                            <li class="form-group">
                                <label class="radio">
                                    <input type="radio" name="license_type" id="single-license" value="extended" data-toggle="radio">
                                    <span class="license-type">Extended License</span>
                                    <span class="license-price">$400</span>
                                    <span class="clearfix"></span>
                                </label>
                            </li>
                            @endif
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
                                <dd>{{ $data['template']->price }}</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Date released</dt>
                                <dd>{{ $data['template']->created_at }}</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Layout</dt>
                                <dd>{{ $data['template']->layout }}</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Type</dt>
                                <dd>{{ $data['template']->frameworks }}</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Pre-processor</dt>
                                <dd>{{ $data['template']->preprocessor ?: "None" }}</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Columns</dt>
                                <dd>{{ $data['template']->columns }}</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Files Included</dt>
                                <dd>{{ $data['template']->files_included }}</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Browser Compatibility</dt>
                                <dd>{{ $data['template']->browser }}</dd>
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
                                <dd>{{ $data['template']->id }}</dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>Author</dt>
                                <dd><a href="#">{{ $data['author']->username }}</a></dd>
                            </dl>
                        </li>
                    </ul>               
                </aside>
            </div>
        <div>
    </section>
@stop