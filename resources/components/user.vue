<template lang="">
        <tr>
    <td v-text="count"></td>
     <td v-text="username"></td>
     <td>
         <form action="/chat" method="post">
         <input type="hidden" :value="token" name="_token">
            <input type="hidden" name="username" :value="username">
            <button class="btn btn-dark">chat</button>
        </form>
     </td>
</tr>
</template>

<script>
export default {
    name:'user',
    props:[
        'username',
        'token',
        'count'
    ]
}
</script>