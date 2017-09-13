

if(document.getElementById('contacts')){
    window.contactsPage = new Vue({
         el:"#contacts",
        data: {
            items: window.locations,

            form: {
                feedback: {
                    uName: '',
                    email: '',
                    phone: '',
                    comment: ''
                }
            }
        },
        methods:{
            removeError(name){
                this.errors.remove(name);
            },
            validate(){
                this.$validator.validateAll().then((result) => {
                    if(result){
                        headerVue.modal.auth=6;
                        headerVue.modal.log=true;
                    }
                }).catch(() => {

                });
            },
            }
    })

}