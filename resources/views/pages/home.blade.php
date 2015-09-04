@extends('layout.main')

@section('content')
  
  <section id="top-banner" class="section padding-120 bg-teal">
    <div class="container">
      <div class="row banner-content">
      
      </div>
    </div>
  </section>

  <!-- Partners -->
  <section id="partners" class="section padding-50 bg-white">
    <div class="container">
      <div class="row">
      
      </div>
    </div>
  </section>
  
  
  <section id="intro" class="section bg-grey">
    <div class="container">
      
      <div class="row">
        <div class="col-md-8">
        
          <div class="row">

            @foreach($templates as $template)
            <div class="col-md-6">
              <div class="item-listing">
                <div class="img-hover">
                  <div class="item-price"><span>$</span> {{ $template->price }}</div>
                  <img src="{{ $template->screenshot }}" alt="" title="" class="img-responsive" />
                  <div class="img-overlay">
                    <a href="#" class="btn-default btn-large">Preview</a>
                    <a href="#" class="btn-default btn-large">Buy Now</a>
                  </div>
                </div>
                <div class="item-listing-meta">
                  <h4><a href="/templates/{{ $template->id }}">{{ $template->name }}</a></h4>
                  <ul>
                    <li><i class="ion-ios-cart-outline"></i> {{ count($template->orders) }} Sales</li>
                    <li><i class="ion-calendar"></i> Released {{ $template->created_at->diffForHumans() }}</li>
                  </ul>
                </div>
              </div>
            </div>        
            @endforeach

            

          </div>

        

          <div class="row">
            <div class="col-md-12 text-left">
              <!-- <ul class="pagination">
                <li><a href="#" aria-label="Previous"><i class="ion-ios-arrow-left"></i><i class="ion-ios-arrow-left"></i></a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#" aria-label="Next"><i class="ion-ios-arrow-right"></i><i class="ion-ios-arrow-right"></i></a></li>
              </ul> -->
              {!! $templates->render() !!}
            </div>
          </div>
          
        </div>
        <div class="col-md-4">
          
          <div class="home-filter">
            <div class="row">
              <div class="dropdown">
                <select ONCHANGE="location = this.options[this.selectedIndex].value;">
                  <option value="">Sort by Price..</option>
                  <option value="?sort=price_highest">Highest First</option>  
                  <option value="?sort=price_lowest">Lowest First</option>
                </select>
              </div>
            </div>
          </div>  
          
          <h4>Recently Launched</h4>
          <ul class="recently-launched row">

            @foreach($recent as $template)
            <li class="col-md-6">
              <div class="thumb">
                <img src="{{ $template->screenshot }}" class="img-responsive" title="" alt="" />
                <h4><a href="/templates/{{ $template->id }}">{{ $template->name }}</a></h4>
              </div>
            </li>
            @endforeach

          </ul>
        </div>
      </div>
      
    </div>
  </section>
  
  <section class="section bg-dark text-white">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3>Most Popular</h3>
          <ul class="recently-launched row">

            @foreach($popular as $template)

              <li class="col-md-4">
                <div class="thumb">
                  <img src="{{ $template->screenshot }}" class="img-responsive" title="" alt="" />
                  <h4><a href="/templates/{{ $template->id }}">{{ $template->name }}</a></h4>
                </div>
              </li>

            @endforeach

          </ul>
        </div>
      </div>
    </div>
  </section>
  
  
  
@stop


@section('footer')

<script type="text/javascript">
    (function() {

        

    })();
</script>
@endsection
