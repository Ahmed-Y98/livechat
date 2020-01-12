@extends('layouts.App')
@section('content')
<div class="container">
    <div class="row">
        <div class="form">
            <form action="/register" method="post">
                @csrf
                <h5 class="text-capitalize text-center display-4">welcome</h5>
                <h6 class="text-capitalize text-center display-4 pb-5">to sign up please fill the fields below</h6>

                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="enter your username" autocomplete="off">
                   @error('username')
                       <span class="text-red">{{ $message}}</span>
                     @enderror
                </div>
               
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="enter your password">
                   
                    @error('password')
                         <span class="text-red">{{ $message }}</span>
                        @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="confirm password">
                </div>
                
                <button class="btn-secondary btn btn-block text-capitalize">sign up</button>
                </form>
        </div>
        <div class="error-msg col-lg-12 text-center text-red">
            @if(session('error'))
                {{session('error')}}
            @endif
        </div>
    </div>    
</div>
@endsection