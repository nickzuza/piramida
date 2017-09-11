import Multiselect from 'vue-multiselect';
if(document.getElementById('userCabPage')){
    $(document).ready(function(){
        $('.hItem').each(function(){
            if($(this).find('.hItem-list li').length >1){
                $(this).addClass('closed');
                $(this).addClass('big');
            }
        });
    });
    $(document).on('click' , '.hItem > .more-info' , function(e){
        var el = e.currentTarget;
        if( $(el).closest('.hItem').hasClass('closed')){
            $(el).closest('.hItem').removeClass('closed');
            $(el).html($(el).attr('data-close'));
        }else{
            $(el).closest('.hItem').addClass('closed');
            $(el).html($(el).attr('data-open'));
        }

    });
    window.userCab = new Vue({
        el:"#userCabPage",
        data:{
            tab:1,
            hProds:window.historyItems,
            city:window.cities,
            activeMen:'',
            form:{
                changePass:{
                    actPass:'',
                    newPass:'',
                    confNewPass:'',
                },
                userData:{
                    email:'',
                    pass:'',
                    confPass:'',
                    name:'',
                    phone:'',
                    city:{
                        id:''
                    },
                    address:'',
                    house:'',
                    door:'',
                    level:'',
                    room:''
                }
            }

        },
        components:{Multiselect},
        methods:{
            removeCity(){
                this.removeError('form_userData_city')
            },
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
                    }).catch(() => {});
            },
            validateForm(){
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
                }).catch(() => {});
            },
            getTotal(item){
               var total=0;
                for(var i=0 ;i <item.items.length;i++){
                    total +=(item.items[i].price * item.items[i].quantity);
                }
                return total;
            },
            changeSlug(tab){
              if(tab != this.tab){
                  this.tab=tab;
                  setTimeout(function(){
                      console.log($('.menu-list>li.active').attr('data-slug'));
                  },10);
              }
            },
            getRound(price){
                return Math.floor(parseInt(price))
            },
            getRest(price){
                return Math.floor((price - this.getRound(price))*100);
            },
        },
        mounted(){
            this.activeMen = $('.menu-list>.active').html()
            setTimeout(this.changeSlug(this.tab),1000)
        }
    });
    $('.header-men').click(function(){
        if($('.menu-list').hasClass('opened')){
            $('.menu-list').velocity({
                height:0
            });
            $('.menu-list').removeClass('opened');
        }else{
            $('.menu-list').velocity({
                height:'228px'});
            $('.menu-list').addClass('opened');
        }
    });
    $(window).on('resize' , function(){
        if(window.innerWidth > 1170){
            $('.menu-list').removeAttr('style');
            $('.menu-list').removeClass('opened');
        }
    });
    $('.menu-list>li').click(function(){
        userCab.activeMen = $('.menu-list>.active').html()
        if(window.innerWidth < 1170) {
            $('.menu-list').velocity({
                height: 0
            });
            $('.menu-list').removeClass('opened');
        }
    });
}