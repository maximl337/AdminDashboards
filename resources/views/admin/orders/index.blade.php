@extends('layout.main')

@section('head')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('content')


<section id="main-content" class="section bg-grey">
    <div class="container" style="padding-top: 50px;">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">
                <h3>Orders</h3>
                <hr />   
                <table id="orders" class="table table-striped">
                    <thead>
                        <tr>
                            <th>XN #</th>
                            <th>Template</th>
                            <th>License</th>
                            <th>Status</th>
                            <th>Payment Amt</th>
                            <th>Tax</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->txn_id }}</td>
                                <td><a href="/admin/templates/{{ $order->template_id }}"> {{ $order->template->name }}</a></td>
                                <td>{{ $order->licence_type }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->payment_gross }}</td>
                                <td>{{ $order->tax }}</td>
                                <td>{{ $order->created_at }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                

            </div>
        </div> <!-- /.row -->
    </div>
</section>
@endsection

@section('footer')
<script type="text/javascript" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    (function() {

        $("#orders").dataTable();

    })();
</script>
@endsection