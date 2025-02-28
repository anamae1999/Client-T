<template>
    <div class="shadow rounded white-bg pos-relative p-md-5 p-3 my-md-3 my-0">
        <div class="header-container mb-4">
            <h4 class="brown">Messages</h4>
        </div>        
        <div v-if="contacts.length > 0" class="row">            
            <div class="col-12 no-gutters row message-item px-1 py-3" v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }">
                <div class="px-2 contact-img">
                    <div v-if="contact.profile_pic !== null" class="circle-img" :style="{ backgroundImage: `url(${contact.profile_pic})` }"></div>
                    <div v-else class="circle-img" :style="{ backgroundImage: `url('/images/avatar-placeholder.png')` }"></div>
                </div>
                <div class="px-2 flex-grow-1 d-flex flex-column justify-content-center contact">
                    <p class="mb-2">{{ contact.first_name }}</p>
                    <p class="mb-0 unread green" v-if="contact.unread"><strong>You have new message(s)</strong></p>
                </div>
                <div class="px-2 d-flex flex-column justify-content-center">
                    <div class="d-flex justify-content-end">                                               
                        <a href="#deleteContactModal" class="mb-0 brown pl-2 delete-contact-lnk" data-toggle="modal" :data-contactid="contact.id" :data-name="contact.first_name">Delete</a>                        
                    </div>
                </div>
            </div>
            
        </div>
        <div v-else class="row">
            <div class="col-12 no-gutters row message-item py-3">
                <p>You have no contact on your list.</p>                
            </div>
        </div>
        
       
    </div>
    
</template>

<script>
    export default {
        props: {
            contacts: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                selected: this.contacts.length ? this.contacts[0] : null
            };
        },
        methods: {
            selectContact(contact) {
                this.selected = contact;

                this.$emit('selected', contact);
            },
            autoSelectContact(){
                var getUrlParameter = function getUrlParameter(sParam) {
                    var sPageURL = window.location.search.substring(1),
                        sURLVariables = sPageURL.split('&'),
                        sParameterName,
                        i;

                    for (i = 0; i < sURLVariables.length; i++) {
                        sParameterName = sURLVariables[i].split('=');

                        if (sParameterName[0] === sParam) {
                            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                        }
                    }
                };
                var id = getUrlParameter('id');
                var first_name = getUrlParameter('first_name');
                var profile_pic = getUrlParameter('profile_pic');
                var profile = getUrlParameter('profile');

                var contact = {"id":id,"first_name":first_name, "profile_pic":profile_pic, "profile":profile}

                if (contact.id) {
                    this.$emit('selected', contact);
                }
                
            },
        },
        mounted(){
            this.autoSelectContact();
        },
        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact == this.selected) {
                        return Infinity;
                    }

                    return contact.unread;
                }]).reverse();
            }
        }
    }


    // delete contact modal
    $('#deleteContactModal').on('show.bs.modal', function(e) {
        var contactid = $(e.relatedTarget).data('contactid');
        var name = $(e.relatedTarget).data('name');
        $(e.currentTarget).find('input[name="contactid"]').val(contactid);
        $(e.currentTarget).find('input[name="name"]').val(name);
        $(e.currentTarget).find('.user-name').html(name);
    });
    
</script>
