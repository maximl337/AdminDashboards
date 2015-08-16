@extends('layout.main')

@section('content')

    <div class="row">
        <div class="col-md-7 col-md-offset-1">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>{{ $data['template']->name }}</h4>
                </div>
                <div class="panel-body">
                    <img src="{{ $data['template']->screenshot }}" class="template-screenshot">
                    
                </div>
                <div class="panel-footer">
                    <h5>
                        {{ $data['template']->description }}
                    </h5>
                    <p>$ {{ $data['template']->price }}</p>
                </div>
            </div>

            @include('errors.list')
        </div>

        <div class="col-md-2">
            
            <div class="panel panel-default">
                <div class="panel-body">
            
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

                @else
    
                    <p class="alert alert-warning text-center"> Approval Pending </p>
                @endif

                </div>
            </div>
        </div>
    </div>

@stop