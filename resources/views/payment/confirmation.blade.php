@extends('layout.main')

@section('content')


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        
            @if($internalResp['status'] == true)
        
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <p class="panel-title"> Payment Successful </p>
                    </div>
                    <div class="panel-body">
                        
                        <p class="alert alert-success"> {{ $internalResp['message'] }} </p> <hr />

                        <h4> Transaction Details </h4>

                        <ul class="list-group">
                          <li class="list-group-item">First Name: {{ $internalResp['transaction']['first_name'] }}</li>
                          <li class="list-group-item">Last Name: {{ $internalResp['transaction']['last_name'] }}</li>
                          <li class="list-group-item">Amount: {{ $internalResp['transaction']['amount'] }} CAD</li>
                          <li class="list-group-item">Template: {{ $internalResp['transaction']['template']->name }}</li>
                        </ul>
                        <hr />

                        <h4>Files</h4>

                        <a class="btn btn-lg btn-success" href="{{ $internalResp['file']['url'] }}">Download File</a><br />
                        
                        <p><small>{{ $internalResp['file']['message']  }}</small></p>
                    </div>
                </div>

            @else

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <p class="panel-title"> Something went wrong !</p>
                    </div>
                    <div class="panel-body">
                        
                        <p class="alert alert-danger text-center"> {{ $internalResp['message'] }} </p> <hr />

                    </div>
                </div>

            @endif
            
        </div> <!-- EO .col-md-8 -->
    </div> <!-- EO .row -->

    <script type="text/javascript">

    </script>
@endsection