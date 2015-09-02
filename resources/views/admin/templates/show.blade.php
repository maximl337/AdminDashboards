@extends('layout.main')

@section('head')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('content')


<section id="main-content" class="section bg-grey">
    <div class="container" style="padding-top: 50px;">
         <div class="row">
            <div class="col-md-8 col-md-offset-2">
                

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Name</h4>
                            <p class="list-group-item-text">{{ $template->name }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Price</h4>
                            <p class="list-group-item-text">Single: ${{ $template->price }}</p>
                            <p class="list-group-item-text">Multiple: ${{ $template->price_multiple }}</p>
                            <p class="list-group-item-text">Extended: ${{ $template->price_extended }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Version</h4>
                            <p class="list-group-item-text">{{ $template->version }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Description</h4>
                            <p class="list-group-item-text">{{ $template->description }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Layout</h4>
                            <p class="list-group-item-text">{{ $template->layout }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Type</h4>
                            <p class="list-group-item-text">{{ $template->type }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">CSS Pre-processor</h4>
                            <p class="list-group-item-text">{{ $template->preprocessor }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Browser Compatibality</h4>
                            <p class="list-group-item-text">{{ $template->browser }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Columns</h4>
                            <p class="list-group-item-text">{{ $template->columns }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Build Tools</h4>
                            <p class="list-group-item-text">{{ $template->build_tools }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Exclusivity</h4>
                            <p class="list-group-item-text">{{ $template->exclusive }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Tags</h4>
                            <p class="list-group-item-text">{{ $template->tags }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Preview</h4>
                            <p class="list-group-item-text">{{ $template->preview_url }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Files Included</h4>
                            <p class="list-group-item-text">{{ $template->files_included }}</p>
                          </a>
                        </div>

                        <div class="list-group">
                          <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading">Files</h4>
                            <p class="list-group-item-text">URL: {{ $template->files_url }}</p>
                            <p class="list-group-item-text"><a href="{{ $template->files }}" class="btn btn-primary">Files</a></p>
                          </a>
                        </div>



            </div>
        </div>
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