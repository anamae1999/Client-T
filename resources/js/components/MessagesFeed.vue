<template>
    <div class="feed" ref="feed">
        <div v-if="contact" class="msg-body white-bg scroll">
            <div v-for="message in messages" :class="`${message.to == contact.id ? ' message mine' : ' message'}`" :key="message.id">
                <div class="message-img">
                    <div v-if="message.to != contact.id">
                        <div v-if="contact.profile_pic !== null" class="circle-img" :style="{ backgroundImage: `url(${contact.profile_pic})` }"></div>
                        <div v-else class="circle-img" :style="{ backgroundImage: `url('/images/avatar-placeholder.png')` }"></div>
                    </div>
                    <div v-else>
                        <div>                              
                            <div v-if="self.profile_pic !== null" class="circle-img" :style="{ backgroundImage: `url(${self.profile_pic})` }"></div>
                            <div v-else class="circle-img" :style="{ backgroundImage: `url('/images/avatar-placeholder.png')` }"></div>                         
                        </div>  
                    </div>
                </div>
                <div class="message-info">
                    <div class="message-text text">
                        <p>{{ message.text }}</p> 
                    </div>
                    <p class="msg-time">{{ message.created_at }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script> 
    export default {
        props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
                required: true
            },
            self: {
                type: Object
            },
        },
        methods: {
            scrollToBottom() {
                var chatParentHeight = jQuery('.dashboard-tab-content').outerHeight();
                var chatInfoHeight = jQuery('.msg-info').outerHeight();
                var chatSenderHeight = jQuery('.msg-sender').outerHeight();
                if (window.innerWidth > 420){
                    jQuery('.feed').height( chatParentHeight - chatInfoHeight - chatSenderHeight - 66);
                } else {
                    jQuery('.feed').height( chatParentHeight - chatInfoHeight - chatSenderHeight - 36);
                }

                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            }
        },
        watch: {
            contact(contact) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        } 
    }
</script>


