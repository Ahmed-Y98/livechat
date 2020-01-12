@extends('layouts.App')
@section('content')
<div class="push-notification">
    <i class="fas fa-bell"></i>
    <span>someone messaged you</span>
</div>
<div class="container">
    <div class="row">
        <div class="wel-msg">
            <h5 class="display-4">
                welcome , {{ auth()->user()->username}} choose a user to begin chatting have fun!!!
            </h5>
        </div>
        <div class="select-user col-lg-12  ">
            <form action="/chat" method="post">
                @csrf
                <div class="form-group col-lg-4 text-center mx-auto my-5">
                    <select name="username" class="custom-select">
                        <option selected>choose a user</option>    
                        @foreach($users as $user)
                    <option value="{{$user->username}}">
                        {{$user->username}}
                    </option>
                        @endforeach
                    </select>    
                </div>    
                <button class="btn-dark btn-lg d-block m-auto">start chat</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.1/axios.min.js"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script>
$(function(){

    //change in user status
    Pusher.logToConsole = true;

    var pusher = new Pusher('90ada675880388af9865', {
    cluster: 'eu',
    forceTLS: true
    });

    var channel = pusher.subscribe('status');

    channel.bind('status-event', function(data) {
    console.log('listening on port 8000');
    let id = "{{auth()->user()->id}}";
   
    axios.post('{{route("activeUsers")}}' , {
        id
    })
    .then((response) => {
        $('.custom-select').html('');
        response.data.forEach(element => {
           $('.custom-select').append(`<option value="${element}">${element}</option>`);
       });
    })
    .catch(err => console.error(err));
    });

    //new message from a user to you
    var pusher = new Pusher('90ada675880388af9865', {
    cluster: 'eu',
    forceTLS: true
    });

    var channel = pusher.subscribe('push-not-{{auth()->user()->id}}');

    channel.bind('event', function(data) {
    console.log('listening on port 8000');
    $('.push-notification span').text(`${data.username} sent you a message`);
   $('.push-notification').animate({

        right: '10px'
   },1500 , function(){
    $(this).delay(2000).animate({
                right:'-205px'
            })
    
});
$.playSound("/songs/just-saying.mp3");
    });

});
</script>
@endsection