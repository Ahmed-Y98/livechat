<template>
<div class="container">
    <div class="row">
      <div class="title col-lg-12">
            <h4 class="display-4 text-center text-capitalize">chat</h4>
        </div>
     <div class="chat-container mx-auto my-4">
      <div class="push-notification" :class="{message : visible}">
            <i class="fas fa-bell"></i>
            <span v-text="notification"></span>
        </div>
        <div class="chat-header">
                <h6 v-text="reciever"></h6>
                <span>active</span>
            </div>
     <div class="timeline">
                <message v-for="message in messages" 
                        :key="message.id" 
                        :message="message.body" 
                        :sender="message.sender"
                        :reciever="message.reciever"
                        :senderid="senderid"
                        :photo="message.photo"
                />
         </div>
       <div class="chat-action">
            <form  method="post" class="data" enctype="multipart/form-data" >
                <input type="hidden" name="_token" :value="token">
                    <div class="form-group">
                        <input type="text" name="message" class="form-control msg" v-model="body" autocomplete="off">
                            </div>
                    <div class="buttons">
                            <input type="file" name="file" class="file" @change="fileUpload">
                            <button class="btn btn-warning"><i class="fas fa-paperclip"></i></button>
                            </div>
                        <div class="button">
                            <button class="btn btn-secondary send" @click.prevent="newMessage">send</button>
                        </div>
               </form>
         </div>
        </div>
</div>
</div>
</template>

<script>
const axios = require('axios');
const Pusher = require('pusher-js');
import message from "../components/message";
export default {
    name: 'chat',
    props: [
        'reciever',
        'senderid',
        'chattoken',
        'token',
        'rec_id',
    ],
    mounted() {
        this.recievedANewMessage();
        this.liveMessage;
        this.onlineUser();
    },
    created(){
        this.chatMessages();
    },
    data(){
        return{
            title: 'chat',
            messages : [],
            notification:'',
            visible: false,
            body: '',
            file:''
        }
    },
    components:{
        message
    },
    methods:{
        newMessage(){
            const $this = this;
            let message = this.body;
            const form = new FormData();
            if($this.file != ''){
                form.append('file' , this.file);
            }
            form.append('message' , this.body);
            form.append('token' , this.chattoken);
            axios.post('/message' , 
            form,
            {
                headers:{
                    'Content-Type': 'multipart/form-data'
                }
            }
            ).then(function(res){
                // console.log(res);
                $this.body = '';
                $this.file = '';
            }).catch(err => console.error(err));
            console.log(form.file);

        },
        fileUpload(event){
                const file = event.target.files[0];
                this.file = file;
        },
        errorHandle(){
            alert('we are having some difficulty in file uploading please try again later sorry for the inconvenience');    
        },
        recievedANewMessage(){

                const $this = this; 
                var pusher = new Pusher('90ada675880388af9865', {
                        cluster: 'eu',
                        forceTLS: true
                     });

               var channel = pusher.subscribe('push-not-'+this.senderid);

                channel.bind('event', function(data) {
                    if($this.rec_id != data.sender){
                        $this.notification = `${data.username} messaged you`;
                        $this.visible = true;

                    let y =  setInterval(function(){
                            $this.visible = false;
                            clearInterval(y);
                            },5000);
                    }
               

                });

        },
        chatMessages(){

            const $this = this;

            axios.post('/api/chat' , {
                token: this.chattoken
            })
            .then(function(response){
                $this.messages = response.data;
            })
            .catch(err => console.error(err));

        },
        onlineUser(){
            const $this = this;
             var pusher = new Pusher('90ada675880388af9865', {
                        cluster: 'eu',
                        forceTLS: true
                     });
            var channel = pusher.subscribe('user-is-online');
             channel.bind('user-event', function(data) {
            
                    if(data.sender != this.senderid){
                         $this.notification = `${data.username} is online`;
                         $this.visible = true;

                        let y =  setInterval(function(){
                                $this.visible = false;
                                clearInterval(y);
                                },5000);
                        }
                });
        }
    },
    computed: {
        liveMessage(){
                Pusher.logToConsole = true;
                const $this = this;
             var pusher = new Pusher('90ada675880388af9865', {
                cluster: 'eu',
                forceTLS: true
                });
                var channel = pusher.subscribe('online-' + this.chattoken);

                channel.bind('online-user', function(data) {
                     $this.messages.push(data);
                });
        }
    },
}

</script>

<style lang="scss" scoped>
.message{
    right: 10px !important; 
    transition: 1s ease-in-out;
}
</style>