@extends('layout.main')

@section('head')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('content')


<section id="main-content" class="section bg-grey">
    <div class="container" style="padding-top: 50px;">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">
                <h3>Users</h3>
                <hr />   
                <table id="orders" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Approved Seller</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td><a href="/admin/users/{{ $order->id }}"> {{ $user->username }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->approved_seller ? 'approved' : '' }}</td>
                                <td>{{ $user->created_at }}</td>
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