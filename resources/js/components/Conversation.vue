<template>
    <div class="conversation shadow rounded white-bg">        
        <div class="msg-info d-flex justify-content-between align-items-center px-2 px-md-5 py-3">           
            <div class="d-flex align-items-center">
                <a v-if="contact !== null" :href="contact.profile">  
                    <div v-if="contact !== null" class="circle-img 1" :style="{ backgroundImage: `url(${contact.profile_pic !== null && contact.profile_pic !== '' ? contact.profile_pic : '/images/avatar-placeholder.png'})` }"></div>  
                </a>    
                <a class="msg-profile-link" v-if="contact !== null" :href="contact.profile">            
                    <div class="ml-3">                    
                        <h5 class="green">{{ contact ? contact.first_name : '' }}</h5>                    
                    </div>
                </a>
            </div>
            <div class="message-functions">
                <a v-if="contact" href="#deleteContactModal" data-toggle="modal" :data-contactid="contact.id" :data-name="contact.first_name"><i class="fas fa-trash-alt brown" data-toggle="tooltip" data-placement="top" title="Delete?"></i></a>
            </div>
        </div>            
        <MessagesFeed :contact="contact" :messages="messages" :self="self"/>
        <MessageComposer @send="sendMessage"/>
    </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed';
    import MessageComposer from './MessageComposer';

    export default {
        props: {
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            },
            self: {
                type: Object
            },
        },
        methods: {
            sendMessage(text) {
                if (!this.contact) {
                    return;
                }

                axios.post('/conversation/sender', {
                    contact_id: this.contact.id,
                    text: text
                }).then((response) => {
                    this.$emit('new', response.data);
                    console.log(response);
                })
                .catch(error => {
                   console.log(error.response)
                });
            }
        },
        components: {MessagesFeed, MessageComposer}
    }
</script>
