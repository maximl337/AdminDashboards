@extends('layout.main')

@section('content')

<section id="main-content" class="section bg-grey">
    <div class="container">
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
                                <label>Template Name </label> <em>(required)</em>
                                <input name="name" id="name" type="text" class="form-control" value=" {{ old('name') }}">
                            </div>

                            <div class="form-group">
                                <label>Price </label> <em>(required)</em>
                                <input name="price" id="price" type="text" class="form-control" value="{{ old('price') }}">
                            </div>
                            <div class="form-group">
                                <label>Price </label> <em> - multiple (required)</em>
                                <input name="price_multiple" id="price_multiple" type="text" class="form-control" value="{{ old('price_multiple') }}">
                            </div>
                            <div class="form-group">
                                <label>Price </label> <em> - extended (required)</em>
                                <input name="price_extended" id="price_extended" type="text" class="form-control" value="{{ old('price_extended') }}">
                            </div>
                            <div class="form-group">
                                <label>Version </label> <em>(required)</em>
                                <input name="version" id="version" type="text" class="form-control" value="{{ old('version') }}">
                            </div>
                            <div class="form-group">
                                <label>Description </label> <em>(required)</em>
                                <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Layout</label>
                                <div class="checkbox">
                                    <label>
                                        <input name="layout" type="checkbox" value="responsive" checked="checked"> Responsive
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="layout" type="checkbox" value="fixed"> Fixed
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="layout" type="checkbox" value="fluid"> Fluid
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Type</label>
                                <div class="checkbox">
                                    <label>
                                        <input name="frameworks[]" type="checkbox" value="Bootstrap" checked="checked"> Bootstrap
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="frameworks[]" type="checkbox" value="Foundation"> Foundation
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="frameworks[]" type="checkbox" value="AngularJS"> AngularJS
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="frameworks[]" type="checkbox" value="jQuery"> jQuery
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="frameworks[]" type="checkbox" value="Vanilla"> Vanilla
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>CSS PreProcessor</label>
                                <div class="radio">
                                    <label>
                                        <input name="preprocessor" type="radio" value="Sass" checked="checked"> Sass
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input name="preprocessor" type="radio" value="Less"> Less
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input name="preprocessor" type="radio" value="Stylus"> Stylus
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input name="preprocessor" type="radio" value=""> None
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Browser Compatibility</label>
                                <div class="checkbox">
                                    <label>
                                        <input name="browser[]" type="checkbox" value="FireFox" checked="checked"> FireFox <em>(latest)</em>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="browser[]" type="checkbox" value="Chrome" checked="checked"> Chrome <em>(latest)</em>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="browser[]" type="checkbox" value="Opera" checked="checked"> Opera <em>(latest)</em>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="browser[]" type="checkbox" value="Safari" checked="checked"> Safari <em>(latest)</em>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="browser[]" type="checkbox" value="IE 11" checked="checked"> IE 11
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="browser[]" type="checkbox" value="IE 10" checked="checked"> IE 10
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="browser[]" type="checkbox" value="IE 9" checked="checked"> IE 9
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="browser[]" type="checkbox" value="IE 8" checked="checked"> IE 8
                                    </label>
                                </div>
                                
                            </div>

                            <div class="form-group">
                                <label>Columns</label>
                                <select name="columns" id="" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3" selected="selected">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                                
                            </div>

                            <div class="form-group">
                                <label>Build Tools</label>
                                <div class="checkbox">
                                    <label>
                                        <input name="build_tools[]" type="checkbox" value="Grunt" checked="checked"> Grunt
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="build_tools[]" type="checkbox" value="Gulp"> Gulp
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Exclusivity</label> <small>Exclusivity determines commission rate</small>
                                <div class="radio">
                                    <label>
                                        <input name="exclusive" type="radio" value="1" checked="checked"> Exclusive
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input name="exclusive" type="radio" value="0"> Non-exclusive
                                    </label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="">Tags</label>
                                
                                <select id="tags" name="tags" class="form-control">
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Screenshot</label> <em>Must be W:1100 X H:590 pixels (required)</em>
                                <input type="file" name="screenshot" id="screenshot" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>Preview URL </label><em>A preview of the working product.(required)</em>
                                <input name="preview_url" id="preview_url" type="text" class="form-control" value="{{ old('preview_url') }}">
                            </div>

                            <div class="form-group">
                                <label>Files </label> <em>.zip only - max size 150 MB (required)</em>
                                <input name="files" id="files" type="file" class="form-control" />
                            </div>
                             <div class="form-group">
                                <label for="">Files included </label> <em>A comma separated list of files that are included in the final product</em>
                                <input name="files_included" id="files_included" type="text" class="form-control">
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
    </div>
</section>

@stop

@section('footer')
<script type="text/javascript">
  $('#tags').select2({
    tags: true,
    tokenSeparators: [',', ' ']
  });
</script>
@stop