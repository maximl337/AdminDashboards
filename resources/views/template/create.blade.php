@extends('layout.main')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="text-white">Submit a Template</h5>
                </div>
                <div class="panel-body">
                    
                    <form enctype="multipart/form-data" action="/templates" method="POST">
                        {!! csrf_field() !!}
                        
                        <div class="form-group">
                            <label>Template Name *</label>
                            <input name="name" id="name" type="text" class="form-control" value=" {{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label>Price *</label>
                            <input name="price" id="price" type="text" class="form-control" value="{{ old('price') }}">
                        </div>
                        <div class="form-group">
                            <label>Price <small> - multiple</small></label>
                            <input name="price_multiple" id="price_multiple" type="text" class="form-control" value="{{ old('price_multiple') }}">
                        </div>
                        <div class="form-group">
                            <label>Price <small> - extended</small></label>
                            <input name="price_extended" id="price_extended" type="text" class="form-control" value="{{ old('price_extended') }}">
                        </div>
                        <div class="form-group">
                            <label>Version</label>
                            <input name="version" id="version" type="text" class="form-control" value="{{ old('version') }}">
                        </div>
                        <div class="form-group">
                            <label>Description *</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Screenshot *</label>
                            <input type="file" name="screenshot" id="screenshot" class="form-control" />
                            
                        </div>
                        <div class="form-group">
                            <label>Preview URL *</label>
                            <input name="preview_url" id="preview_url" type="text" class="form-control" value="{{ old('preview_url') }}">
                        </div>
                        <div class="form-group">
                            <label>Files *</label> <small>Zip - max size 150 MB</small>
                            <input name="files" id="files" type="file" class="form-control" />
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