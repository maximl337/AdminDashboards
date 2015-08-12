@extends('layout.main')

@section('content')

    <div class="row">
        <div class="col-md-7 col-md-offset-1">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>{{ $template->name }}</h4>
                </div>
                <div class="panel-body">
                    <img src="{{ $template->screenshot }}" class="template-screenshot">
                    
                </div>
                <div class="panel-footer">
                    <h5>
                        {{ $template->description }}
                    </h5>
                    <p>$ {{ $template->price }}</p>
                </div>
            </div>

            @include('errors.list')
        </div>

        <div class="col-md-2">
            
            <div class="panel panel-default">
                <div class="panel-body">
                        
                <script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant={{ env('PAYPAL_MERCHANT_ACCOUNT_ID') }}"
                        data-button="buynow" 
                        data-name="{{ $template->name }}" 
                        data-quantity="1" 
                        data-amount="{{ $template->price }}" 
                        data-currency="CAD" 
                        data-shipping="0" 
                        data-tax="3.50" 
                        data-callback="{{ url('/') }}/paypal/callback" 
                        data-custom="{{ $template->id . ',single' }}"
                        data-env="sandbox"
                        data-notify_url="{{ url('/') }}/paypal/ipn"
                    ></script>


                </div>
            </div>
        </div>
    </div>

@stop