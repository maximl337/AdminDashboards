@extends('layout.main')

@section('content')

<section id="main-content" class="section bg-grey">
    <div class="container" style="padding-top: 50px;">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <div class="panel panel-primary">
                <div class="panel-heading">
                    
                    <h3>Dashboard </h3>

                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills" style="margin-bottom: 25px;">
                      <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Earnings</a></li>
                      <li><a href="#template" data-toggle="tab" aria-expanded="true">Templates</a></li>
                      <li><a href="#orders" data-toggle="tab" aria-expanded="false">Orders</a></li>
                      <li><a href="#payment-settings" data-toggle="tab" aria-expanded="false">Payment Settings</a></li>
                      <li class="dropdown hidden">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                          Dropdown <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                          <li class=""><a href="#dropdown1" data-toggle="tab" aria-expanded="false">Action</a></li>
                          <li class="divider"></li>
                          <li class=""><a href="#dropdown2" data-toggle="tab" aria-expanded="false">Another action</a></li>
                        </ul>
                      </li>
                    </ul>
                    <hr />
                    <div id="myTabContent" class="tab-content">

                      <div class="tab-pane fade active in" id="home">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="well">
                              <h1>${{ $data['earnings']['pending'] }}</h1><br />
                              <small>Pending</small>
                            </div>
                          </div> <!-- /.col-md-4 -->

                          <div class="col-md-4">
                            <div class="well">
                              <h1>${{ $data['earnings']['paid'] }}</h1><br />
                              <small>Paid</small>
                            </div>
                          </div> <!-- /.col-md-4 -->

                          <div class="col-md-4">
                            <div class="well">
                              <h1>${{ $data['earnings']['lifetime'] }}</h1><br />
                              <small>Lifetime</small>
                            </div>
                          </div> <!-- /.col-md-4 -->

                        </div> <!-- /.row -->                        
                      </div>

                      <div class="tab-pane fade" id="template">
                        @if(count($data['templates']))


                            <table class="table table-striped table-hover ">
                              <thead>
                                <tr>
                                  <th>Name</th>
                                  <th>Price</th>
                                  <th>Version</th>
                                  <th>Preview</th>
                                  <th>Approved</th>
                                  <th>Rejected</th>
                                  <th>Submit Date</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($data['templates'] as $template)
                                  <tr>
                                    <td><a href="/templates/{{ $template->id }}">{{ $template['name'] }}</a></td>
                                    <td>{{ $template->price }}</td>
                                    <td>{{ $template->version }}</td>
                                    <td>{{ $template->preview_url }}</td>
                                    <td>{{ $template->approved }}</td>
                                    <td>{{ $template->rejected }}</td>
                                    <td>{{ $template->created_at }}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table> 
                         @else

                            <p class="alert alert-warning">You dont have any templates</p>

                            <a class="btn btn-primary" href="/sell">Submit a template</a>

                         @endif
                      </div>
                      <div class="tab-pane fade" id="orders">
                        @if(count($data['orders']))
                        <table class="table table-striped table-hover ">
                          <thead>
                            <tr>
                              <th>Template</th>
                              <th>Price</th>
                              <th>Earning</th>
                              <th>Licence</th>
                              <th>Status</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data['orders'] as $order)
                              <tr>
                                <td><a href="/templates/{{ $order->template->id }}">{{ $order->template->name }}</a></td>
                                <td>${{ $order->template->price }}</td>
                                <td>${{ $order->earning }}</td>
                                <td>{{ $order->licence_type }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->created_at }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table> 
                        @else
                          
                          <p class="alert alert-warning text-center">
                            You do not have any orders.
                          </p>
                        @endif

                      </div>
                      <div class="tab-pane fade" id="payment-settings">
                        @include('_partials._payment-settings-form', ['user' => Auth::user()])
                      </div>
                    </div>
                </div> <!-- .panel-body -->
            </div> <!-- .panel -->

        </div>
    </div>
  </div>
</section>

@stop