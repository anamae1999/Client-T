<template>
    <div class="msg-sender py-3 d-flex flex-row">
        <div class="d-flex flex-grow-1">
            <textarea v-model="message" @keydown.enter="send" placeholder="New Message..." class="msg-input form-control"></textarea>
        </div>
        <div class="send-btn ml-3">
            <i v-on:click="send" class="far text-success fa-paper-plane"></i>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: ''
            };
        },
        methods: {
            send(e) {
                e.preventDefault();
                
                if (this.message == '') {
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>


