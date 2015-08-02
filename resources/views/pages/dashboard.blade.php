@extends('layout.main')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <div class="panel panel-primary">
                <div class="panel-heading">
                    
                    <h5 class="text-white">{{ Auth::user()->username }}'s  Dashboard </h5>

                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills" style="margin-bottom: 25px;">
                      <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Home</a></li>
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
                    <div id="myTabContent" class="tab-content">

                      <div class="tab-pane fade active in" id="home">
                        <div class="row">

                          <div class="col-md-4">
                            <div class="panel panel-primary">
                              <div class="panel-heading">
                                <h3 class="panel-title">Total Templates</h3>
                              </div>
                              <div class="panel-body">
                                {{ count($data['templates']) }}
                              </div>
                            </div>
                          </div> <!-- /.col-md-4 -->

                          <div class="col-md-4">
                            <div class="panel panel-warning">
                              <div class="panel-heading">
                                <h3 class="panel-title">Total Orders</h3>
                              </div>
                              <div class="panel-body">
                                {{ count($data['orders']) }}
                              </div>
                            </div>
                          </div> <!-- /.col-md-4 -->

                          <div class="col-md-4">
                            <div class="panel panel-success">
                              <div class="panel-heading">
                                <h3 class="panel-title">Total earnings $</h3>
                              </div>
                              <div class="panel-body">
                                {{ $data['earnings'] }}
                              </div>
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
                                    <td><a href="/templates/{{ $template['id'] }}">{{ $template['name'] }}</a></td>
                                    <td>{{ $template['price'] }}</td>
                                    <td>{{ $template['version'] }}</td>
                                    <td>{{ $template['preview_url'] }}</td>
                                    <td>{{ $template['approved'] }}</td>
                                    <td>{{ $template['rejected'] }}</td>
                                    <td>{{ $template['created_at'] }}</td>
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
                              <th>Date</th>
                              <th>Number</th>
                              <th>Template</th>
                              <th>Amount</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data['orders'] as $order)
                              <tr>
                                <td>{{ $order['created_at'] }}</td>
                                <td>{{ $order['id'] }}</td>
                                <td><a href="/templates/{{ $order['template']['id'] }}">{{ $order['template']['name'] }}</a></td>
                                <td>{{ $order['template']['price'] }}</td>
                                <td><small>Pending</small></td>
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

@stop