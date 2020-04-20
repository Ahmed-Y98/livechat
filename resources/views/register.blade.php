@extends('layouts.App')
@section('content')
<register token="{{csrf_token()}}" 
usererror="{{$errors->first('username')}}" 
passerror="{{$errors->first('password')}}"/>
@endsection