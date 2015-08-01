@extends('layout.main')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5>Create a Template</h5>
                </div>
                <div class="panel-body">
                    
                    <form action="/templates" method="POST">
                        {!! csrf_field() !!}
                        
                        <div class="form-group">
                            <label>Template Name *</label>
                            <input name="name" id="name" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Price *</label>
                            <input name="price" id="price" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Price <small> - multiple</small></label>
                            <input name="price_multiple" id="price_multiple" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Price <small> - extended</small></label>
                            <input name="price_extended" id="price_extended" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Version</label>
                            <input name="version" id="version" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description *</label>
                            <textarea name="description" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Screenshot URL *</label>
                            <input name="screenshot" id="screenshot" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Preview URL *</label>
                            <input name="preview_url" id="preview_url" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Files URL *</label>
                            <input name="files_url" id="files_url" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary form-control">
                        </div>
                        
                    </form>

                    @include('errors.list')

                </div>
            </div>

        </div>
    </div>

@stop