'use strict';
import Multiselect from 'vue-multiselect';
import productItem from './components/cartItem';



function wordend(num, words){
    return words[ ((num=Math.abs(num%100)) > 10 && num < 15 || (num%=10) > 4 || num === 0) + (num !== 1) ];
}
if(document.getElementById('cartPage')){
    window.cartObj = new Vue({
        el:"#cartPage",
        data:{
            products:window.cartArray,
            step:1,
            tab:1,
            payMode:1,
            total:0,
            valuta:{
                ru:['лей','лея','лей'],
                ro:['leu','lei','lei']
            },
            items:[],
            city:window.cities,
            form:{
                courier:{
                    email:'',
                    name:'',
                    phone:'',
                    city:{
                        id:''
                    },
                    adress:'',
                    house:'',
                    door:'',
                    level:'',
                    room:'',
                    comments:''
                },
                sam:{
                    email:'',
                    name:'',
                    phone:'',
                    place:$('input[name="place"]:checked').val()
                },
                trans:{
                    compName:'',
                    adress:'',
                    bankCode:'',
                    fiscCode:'',
                    iban:'',
                    nds:'',
                    phone:'',
                    comments:''
                }
            }
        },
        methods:{
            submitForm(){
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
                        this.step=3;
                    }
                }).catch(() => {

                });
            },
            removeError(name){
                this.errors.remove(name);
            },
            remove(id){
                delete this.items[id];
                setTimeout(this.totalSum,300);
            },
            getRound(price){
                return Math.floor(parseInt(price))
            },
            getRest(price){
                return (price - this.getRound(price))*100;
            },
            totalSum(){
                var total=0;
              this.$children.forEach(function(item){
                    total+=item.totalSum;
              });
              this.total=total;
            },
            nextStep(){
                for(var i=0 ; i < this.$children.length;i++){
                    this.items[i]=this.$children[i].item;
                }
                this.items.length ? this.step = 2 : null


            },
            deliveryCost(option, id){
                this.removeError('form_courier_city');

            }
        },
        watch:{total(){
            this.totalSum();
        }},
        computed:{
            // totalWithLei(){
            //     console.log(this.total)
            //     return wordend(this.total,this.valuta[Laravel.language])
            // },
        },
        components:{productItem , Multiselect},
        mounted(){
        }

    });
    $(document).on('click' , '#moreItems' , function(){
        if($('.items-list').hasClass('closed')){
            $('.items-list').removeClass('closed');
            $('#moreItems').html($('#moreItems').attr('data-close'))

        }else{
            $('.items-list').addClass('closed');
            $('#moreItems').html($('#moreItems').attr('data-open'))
        }
    });
    $(document).on('change','input[name=place]',function(){
        cartObj.form.sam.place = $('input[name=place]:checked').val();
    })
}