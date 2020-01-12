@extends('layouts.App')
@section('content')
<div class="push-notification">
    <i class="fas fa-bell"></i>
    <span>someone messaged you</span>
</div>
<div class="container">
    <div class="row">
        <div class="title col-lg-12">
            <h4 class="display-4 text-capitalize text-center">chat</h4>
        </div>
        <div class="chat-container  mx-auto my-4">
            <div class="chat-header">
                <h6>{{$rec}}</h6>
                <span>active</span>
            </div>
            <div class="timeline">
                @foreach($messages as $message)
                @if(auth()->user()->id == $message->sender)
                    <div class="sender">
                        @if($message->photo != 'no photo')
                     <img src="{{$message->photo}}" alt="">
                        @endif
                       <p class="d-block">
                        {{$message->body}}  
                    </p> 
                    </div>
                @else
                    <div class="reciever">
                        @if($message->photo != 'no photo')
                        <img src="{{$message->photo}}" alt="">
                           @endif
                        <p class=" d-block">
                            {{$message->body}}  
                        </p> 
                    </div>
                @endif
                @endforeach
            </div>
            <div class="chat-action">
                <div class="row">
                    <form action="" method="post" class="data" enctype="multipart/form-data">
                        @csrf
                    <input type="hidden" name="token" value="{{$channel_token}}">
                        <div class="form-group">
                            <input type="text" name="message" class="form-control msg">
                        </div>
                        <div class="buttons">
                            <input type="file" name="file" class="file">
                            <button class="btn btn-warning"><i class="fas fa-paperclip"></i></button>
                        </div>
                        <div class="button">
                            <button class="btn btn-secondary send">send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
<script>
    $(function(){
        // $.playSound("/songs/just-saying.mp3");

        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('.data').submit(function(e){
    e.preventDefault();
    var formdata = new FormData($(this)[0]);


            $.ajax({
                url:'/message',
                method:'POST',
                cache       : false,
                contentType : false,
                processData : false,
                data:formdata,
                success(data){
                    if(data == 'success'){
                        $('.msg').val('');
                        $('.file').val('');
                    }else{
                        alert('something went wrong!!!');
                    }
                }
            })
        });
    Pusher.logToConsole = true;

    var pusher = new Pusher('90ada675880388af9865', {
    cluster: 'eu',
    forceTLS: true
    });

    var channel = pusher.subscribe('online-{{$channel_token}}');

    channel.bind('online-user', function(data) {
            let photo;
            let message;
        if(data.sender == "{{auth()->user()->id}}"){
            if(data.photo != 'no photo'){
                photo =  `<img src="${data.photo}" >`;
            }else{
                photo = '';
            }
            if(data.message != 'no msg'){
                message =  `<p class="class="d-block"">${data.message}</p>`;
            }else{
                message = '';
            }
            const html = `<div class="sender">
                ${photo}
                ${message != '' ? message : ''}
                </div>`;
                 $('.timeline').append(html);
        }else{
            if(data.photo != 'no photo'){
                photo = `<img src="${data.photo}" >`;
            }else{
                photo = '';
            }
            if(data.message != 'no msg'){
                message = `<p class="d-block">${data.message}</p>`;
            }else{
                message = '';
            }
            const html = `<div class="reciever">
                ${photo}
                ${message != '' ? message : ''}
                </div>`;
                     $('.timeline').append(html);

        }
    });

    var channel = pusher.subscribe('user-is-online');

    channel.bind('user-event', function(data) {
    console.log('listening on port 8000');
    if(data.sender != "{{auth()->user()->id}}"){

        $('.push-notification span').text(`${data.username} is online`);
        $('.push-notification span').css('left' , '44px');
        $('.push-notification').animate({
            right: '10px'
        },1500 , function(){
            $(this).animate({
                right:'-205px'
            })
        });
        $.playSound("/songs/just-saying.mp3");
    }
    });
            
        



        //new message from a user to you
    var pusher = new Pusher('90ada675880388af9865', {
    cluster: 'eu',
    forceTLS: true
    });
    var $verify = '{{$reciever_id}}';
    

        var channel = pusher.subscribe('push-not-{{auth()->user()->id}}');
    
        channel.bind('event', function(data) {
        console.log('listening on port 8000');
        if($verify != data.sender){
        $('.push-notification span').text(`${data.username} sent you a message`);
       $('.push-notification').animate({
    
            right: '10px'
          },1500 , function(){
            $(this).animate({
            right:'-205px'
        })
        
        });
        $.playSound("/songs/just-saying.mp3");
    }
    });

    

    });
</script>
@endsection