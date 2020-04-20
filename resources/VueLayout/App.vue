<template lang="">
    <div>
        <router-view :token="token" :userid="userid" :username="username"></router-view>
    </div>
</template>

<script>
export default {
   name:'App',
   props:['token' , 'userid' , 'username']
    
}
</script>