@extends('layout.main')

@section('head')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('content')


<section id="main-content" class="section bg-grey">
    <div class="container" style="padding-top: 50px;">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">
                <h3>Templates</h3>
                <hr />   
                <table id="templates" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Seller</th>
                            <th>Exclusive</th>
                            <th>Approved</th>
                            <th>Rejected</th>
                            <th>Disabled</th>
                            <th>Orders</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $template)
                            <tr>
                                <td>{{ $template->id }}</td>
                                <td><a href="/admin/templates/{{ $template->id }}"> {{ $template->name }}</a></td>
                                <td>{{ $template->user->first_name }}</td>
                                <td>{{ $template->exclusive }}</td>
                                <td>{{ $template->approved }}</td>
                                <td>{{ $template->rejected }}</td>
                                <td>{{ $template->disabled }}</td>
                                <td>{{ count($template->orders) }}</td>
                                <td>{{ $template->created_at }}</td>
                                
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

        $("#templates").dataTable();

    })();
</script>
@endsection