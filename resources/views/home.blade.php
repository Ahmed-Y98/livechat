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
        <div class="select-user col-lg-12 ">
            <div class="loader">
                <img src="" alt="">
            </div>
            <table class="table table-light striped d-none bordered">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>username</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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

    axios.post('{{route("activeUsers")}}' , {
        id: '{{Auth()->user()->id}}'
    })
    .then((res) => {
        $('.select-user .loader').hide();
        $('table tbody').html(res.data);
        $('table').removeClass('d-none');
    })
    .catch(err => console.error(err));


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
        $('table tbody').html(response.data);
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