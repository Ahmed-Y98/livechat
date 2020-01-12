@extends('layouts.App')
@section('content')
    <div class="container">
        <div class="row">
            <div class="form">
                <form action="/login" method="post">
                    @csrf
                    <h5 class="text-capitalize text-center display-4">welcome back</h5>
                    <h6 class="text-capitalize text-center display-4 pb-5">enter your credentails to login</h6>

                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="enter your username">
                       <span class="text-red">{{ $errors->first('username') }}</span>
                    </div>
                   
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="enter your password">
                        <span class="text-red">{{ $errors->first('password') }}</span>
                    </div>
                    
                    <button class="btn-secondary btn btn-block">login</button>
                    </form>
            </div>
                @if(session('error'))
                <div class="error-msg col-lg-12 text-center text-red">
                   <span class="alert alert-dark"> 
                       {{session('error')}}
                   </span>
                </div>
                @endif
           
        </div>    
    </div>
@endsection