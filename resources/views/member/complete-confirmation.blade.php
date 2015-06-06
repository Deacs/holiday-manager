@extends('master')

@section('content')

    <div class="large-12 columns">
        <h1>Confirm Your Account</h1>
        <p>Please create a password to complete the confirmation of your account.</p>
    </div>

    {!! Form::open(['action' => 'UserController@completeConfirmation']) !!}

        {!! Form::hidden('user_id', $user_id) !!}

        <div class="large-12 columns">
            <label>Password</label>
            <input type="text" placeholder="Password" name="password">
        </div>
        <div class="large-12 columns">
            <label>Confirm Password</label>
            <input type="text" placeholder="Confirm Password" name="password_confirmation">
        </div>

        <div class="large-12 columns">
            <button class="small button" title="Add">Confirm</button>
        </div>

    {!! Form::close() !!}

@endsection
