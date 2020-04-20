@extends('layouts.App')
@section('content')
<login
 token="{{csrf_token()}}" 
errormsg="{{session('error') ? session('error') : ''}}"
passworderror="{{$errors->first('password')}}"
usernameerror="{{$errors->first('username')}}"/>
@endsection