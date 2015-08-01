@extends('layout.main')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
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

                    <button class="btn btn-primary">Purchase</button>
                </div>
            </div>

            @include('errors.list')
        </div>
    </div>

@stop