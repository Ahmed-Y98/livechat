<template>
    <div>
        <div class="container">
    <div class="row">
        <div class="form">
            <form action="/register" method="post">
            <input type="hidden" name="_token" :value="token">
                <h5 class="text-capitalize text-center display-4">welcome</h5>
                <h6 class="text-capitalize text-center display-4 pb-5">to sign up please fill the fields below</h6>

                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="enter your username" autocomplete="off" v-model="username" @blur="userValid">
                       <span class="text-red" v-text="usererror"></span>
                       <span class="text-red" v-text="userError" v-if="userError != ''"></span>
                </div>
               
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="enter your password" v-model="password" @keyup="passwords">
                         <span class="text-red" v-text="passerror"></span>
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="confirm password" v-model="confpassword" @keyup="passwords">
                    <span class="text-red" v-text="confError" v-if="confError != ''"></span>
                </div>
                
                <button class="btn-secondary btn btn-block text-capitalize" :disabled="!show">sign up</button>
                {{ validate }}
               
                </form>
        </div>
        <div class="error-msg col-lg-12 text-center text-red">
        </div>
    </div>    
  </div>
</div>
</template>

<script>
export default {
    name:'register',
    props:[
        'token',
        'usererror',
        'passerror'
    ],
    data:function(){
        return{
            username: '',
            password: '',
            show: false,
            userError:'',
            passError : '',
            confpassword: '',
            confError: ''
        }
    },
     computed:{
        validate: function(){
            if(this.username != '' && this.password != '' && this.password === this.confpassword && this.password.length >=8 && this.confpassword.length >=8){
                this.show = true;
            }else{
                this.show = false;
            }
        },
        },
        methods:{
            passwords(){
            if(this.password.length < 8){
                this.confError = 'password should be 8 characters minimum';
            }else if(this.password != this.confpassword){
                this.confError = "passwords doesn't match";
            }else{
                this.confError = '';
            }
         },
          userValid(){
            if(this.username == ''){
                this.userError = 'username is required!!';
            }else{
                this.userError = '';
            }
        }
    }
    
}
</script>

<style lang="scss" scoped>

</style>