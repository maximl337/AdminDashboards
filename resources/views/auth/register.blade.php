@extends('layout.main')

@section('content')

<div class="row">
    <div class="col-md-4 col-md-offset-4">

        <form class="form" method="POST" action="/auth/register">
            {!! csrf_field() !!}

            <div class="form-group">
                <label>Username</label>
                <input class="form-control" type="text" name="username" value="" required>
            </div>


            <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input class="form-control" type="password" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <button class="form-control btn btn-primary" type="submit">Register</button>
            </div>
        </form>

        @include('errors.list')

    </div>
</div>


@stop