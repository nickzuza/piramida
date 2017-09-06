

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
                        // var data= {};
                        // data['tab']    = this.tab;
                        // data['pay']    = this.paytab;
                        // data['info']    = this.info;
                        // data['_token']    = Laravel.csrfToken;
                        // $.ajax({
                        //     url: '',
                        //     // url: Laravel.language+'/cart',
                        //     type: 'POST',
                        //     data: data,
                        //     dataType: 'JSON',
                        //     success: function (data){
                        //         this.step = 3;
                        //     }
                        // });
                    }
                }).catch(() => {

                });
            },
            }
    })

}