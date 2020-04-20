<template>
    <div>
     <div class="container">
        <div class="row">
            <div class="form">
                <form action="/login" method="post">
              <input type="hidden" name="_token" :value="token">
                    <h5 class="text-capitalize text-center display-4">welcome back</h5>
                    <h6 class="text-capitalize text-center display-4 pb-5">enter your credentails to login</h6>

                    <div class="form-group">
                        <input type="text"
                         name="username" 
                         class="form-control" 
                         placeholder="enter your username" 
                         autocomplete="off"
                         @blur="userValid"
                         v-model="username">
                       <span class="text-red" v-text="usernameerror">
                       </span>
                        <span class="error text-red" v-text="userError" v-if="userError != ''"></span>
                    </div>
                   
                    <div class="form-group">
                        <input type="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="enter your password"
                         @blur="passValid"
                        v-model="password">
                        <span class="text-red" v-text="passworderror"></span>
                        <span class="error text-red" v-text="passError" v-if="passError != ''"></span>
                    </div>
                    
                    <button class="btn-secondary btn btn-block" :disabled="!show">login</button>
                    {{ validate}}
                    </form>
            </div>
                <div class="error-msg col-lg-12 text-center text-red" v-if="errormsg != ''">
                    <span class="alert alert-dark" v-text="errormsg"></span>
                    </div>
        </div>    
    </div>
</div>
</template>
<script>
export default {
    props: [
            'token',
            'errormsg',
            'passworderror',
            'usernameerror'
        ],
    name:'login',
    data:function(){
        return{
            username: '',
            password: '',
            show: false,
            userError:'',
            passError : ''
        }
    },
    computed:{
        validate: function(){
            if(this.username != '' && this.password != ''){
                this.show = true;
            }else{
                this.show = false;
            }
        }
    },
    methods:{
        userValid(){
            if(this.username == ''){
                this.userError = 'username is required!!';
            }else{
                this.userError = '';
            }
        },
        passValid(){

                if(this.password == '' && this.username == ''){

                    this.passError = 'password is required!!';
                    this.userError = 'username is required!!';

                }else if(this.password == ''){

                 this.passError = 'password is required!!';

                }else if(this.username == '' && this.password !=''){

                     this.userError = 'username is required!!';
                     this.passError = '';
                }else{

                    this.passError = '';
                    this.userError = '';
                }
                
            
        }
    }
}
</script>
<style lang="css">
 
</style>