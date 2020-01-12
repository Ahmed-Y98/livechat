const $ = require('jquery');
const Pusher = require('pusher-js');
$(function(){

    Pusher.logToConsole = true;

    var pusher = new Pusher('90ada675880388af9865', {
      cluster: 'eu',
      forceTLS: true
    });

    var channel = pusher.subscribe('status');

    channel.bind('status-event', function(data) {
      console.log('listening on port 8000');

      

    });

});