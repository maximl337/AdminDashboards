@extends('layout.main')

@section('content')


     <div class="row">
        <div class="col-md-10 col-md-offset-1">
            
            @foreach(array_chunk($templates, 3) as $templateRow)
            <div class="row">
                @foreach($templateRow as $template)

                    <div class="col-md-4">
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ $template['name'] }}
                            </div>
                          <div class="panel-body">
                            <img src="{{ $template['screenshot'] }}" class="template-screenshot">
                          </div>
                            <div class="panel-footer">
                                <a href="#" class="btn btn-primary">Preview</a>

            
                                <a href="/template/{{ $template['id'] }}" class="btn btn-primary">Details</a>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
            
    


                
            @endforeach

        </div>
    </div>

@stop