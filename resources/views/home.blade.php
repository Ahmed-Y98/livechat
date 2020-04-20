@extends('layouts.App')
@section('content')
<App username="{{auth()->user()->username}}"
      userid = "{{auth()->user()->id}}"
        token="{{csrf_token()}}"
    />
@endsection