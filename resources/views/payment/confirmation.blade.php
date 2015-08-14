@extends('layout.main')

@section('content')


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        
            Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.sandbox.paypal.com/ca to view details of this transaction.

            <hr />
            <?php print_r($res); ?>
        </div>
    </div>

@endsection