@extends('layout.main')

@section('content')

<div class="row">
    <div class="col-md-4 col-md-offset-4">

        <form class="form" method="POST" action="/auth/login">
            {!! csrf_field() !!}

            <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" name="password" id="password">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
                
            </div>

            <div class="form-group">
                <button class="btn btn-primary form-control" type="submit">Login</button>
            </div>
        </form>


        @include('errors.list')
        

    </div>
</div>


@stop