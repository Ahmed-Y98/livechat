require('./bootstrap');
require('pusher-js');
const Vue = require('vue');
import router from "./router";
//require vue components
import login from "../components/login";
import register from "../components/register";
import chat from "../components/chat";
import App from "../VueLayout/App";
new Vue({
    el:'#app',
    components:{
       App,
       login,
       register,
       chat
    },
    router
});
