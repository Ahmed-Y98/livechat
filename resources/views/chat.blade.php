@extends('layouts.App')
@section('content')

        <chat reciever="{{$rec}}" 
              senderid="{{auth()->user()->id}}" 
              chattoken="{{$channel_token}}" 
              token="{{csrf_token()}}" 
              rec_id="{{$reciever_id}}"
              messages=<?php $messages ?>
              />   
@endsection