<template>
    <div>
        <div class="sender" v-if="sender == senderid ">
           <a :href="photo" target="blank" v-if="getExt() == 'pdf'">
                 <i class="fas fa-file-pdf"></i>
              </a>
                <a :href="photo" v-else-if="getExt() == 'docx'">
                    <i class="fas fa-file-word"></i>
                    </a>
                <img :src="photo" v-else-if="photo != 'no photo'">
                 <p class=" d-block" v-if="message != 'no msg'" v-text="message"></p>
        </div>
        <div class="reciever" v-else>
             <a :href="photo" target="blank" v-if="getExt() == 'pdf'">
                 <i class="fas fa-file-pdf"></i>
              </a>
                <a :href="photo" v-else-if="getExt() == 'docx'">
                    <i class="fas fa-file-word"></i>
                    </a>
                <img :src="photo" v-else-if="photo != 'no photo'">
                 <p class=" d-block" v-if="message != 'no msg'" v-text="message"></p>
        </div>
    </div>
</template>

<script>
export default {
    props:[
        'message',
        'sender',
        'reciever',
        'senderid',
        'photo'
    ],
    created:function(){
            // this.getExt();
    },
    methods:{
        getExt(){
            return this.photo.split('.')[1];
        }
    }
}
</script>