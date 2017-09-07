function prodSlideInit(){
    $('.slider-min').slick({
        asNavFor:'.slider-max',
        arrows:true,
        dots:false,
        prevArrow:'<div class="slick-arrow prevArrow"> ' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"  x="0px" y="0px" width="14" height="12" viewBox="0 0 307.054 307.054"  xml:space="preserve">'+
        '<g><g > <g>'+
        '<path d="M302.445,205.788L164.63,67.959c-6.136-6.13-16.074-6.13-22.203,0L4.597,205.788c-6.129,6.132-6.129,16.069,0,22.201     l11.101,11.101c6.129,6.136,16.076,6.136,22.209,0l115.62-115.626L269.151,239.09c6.128,6.136,16.07,6.136,22.201,0     l11.101-11.101C308.589,221.85,308.589,211.92,302.445,205.788z"/>'+
        '</g> </g> </g> ' +
        '</div>',
        nextArrow:'<div class="slick-arrow nextArrow">' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"  x="0px" y="0px" width="14" height="12" viewBox="0 0 307.054 307.054"  xml:space="preserve">'+
        '<g><g > <g>'+
        '<path d="M302.445,205.788L164.63,67.959c-6.136-6.13-16.074-6.13-22.203,0L4.597,205.788c-6.129,6.132-6.129,16.069,0,22.201     l11.101,11.101c6.129,6.136,16.076,6.136,22.209,0l115.62-115.626L269.151,239.09c6.128,6.136,16.07,6.136,22.201,0     l11.101-11.101C308.589,221.85,308.589,211.92,302.445,205.788z"/>'+
        '</g> </g> </g> ' +
        ' </div>',
        slidesToShow:5,
        vertical:true,
    });
    $('.slider-max').slick({
        asNavFor:'.slider-min',
        dots:false,
        arrows:true,
        prevArrow:'<div class="slick-arrow prevArrow">' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 492.004 492.004" height="40" width="25 " xml:space="preserve">'+
        '<g>'+
        '<g>'+
        '<path d="M382.678,226.804L163.73,7.86C158.666,2.792,151.906,0,144.698,0s-13.968,2.792-19.032,7.86l-16.124,16.12    c-10.492,10.504-10.492,27.576,0,38.064L293.398,245.9l-184.06,184.06c-5.064,5.068-7.86,11.824-7.86,19.028    c0,7.212,2.796,13.968,7.86,19.04l16.124,16.116c5.068,5.068,11.824,7.86,19.032,7.86s13.968-2.792,19.032-7.86L382.678,265    c5.076-5.084,7.864-11.872,7.848-19.088C390.542,238.668,387.754,231.884,382.678,226.804z"/>'+
        '</g>'+
        '</g> </svg>' +
        '</div>',
        nextArrow:'<div class="slick-arrow nextArrow">' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 492.004 492.004" height="40" width="25 " xml:space="preserve">'+
        '<g>'+
        '<g>'+
        '<path d="M382.678,226.804L163.73,7.86C158.666,2.792,151.906,0,144.698,0s-13.968,2.792-19.032,7.86l-16.124,16.12    c-10.492,10.504-10.492,27.576,0,38.064L293.398,245.9l-184.06,184.06c-5.064,5.068-7.86,11.824-7.86,19.028    c0,7.212,2.796,13.968,7.86,19.04l16.124,16.116c5.068,5.068,11.824,7.86,19.032,7.86s13.968-2.792,19.032-7.86L382.678,265    c5.076-5.084,7.864-11.872,7.848-19.088C390.542,238.668,387.754,231.884,382.678,226.804z"/>'+
        '</g>'+
        '</g> </svg>' +
        '</div>',
        slidesToShow:1,
    });
}
function initProductSlider(id){

    $(id+' .products-slider').not('.slick-initialized').slick({
        slidesToShow:5,
        slidesToScroll:1,
        dots:false,
        arrows:true,
        infinite:false,
        prevArrow:'<div class="slick-arrow prevArrow">' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10px" height="17px">'+
        '<path fill-rule="evenodd"  fill="rgb(140, 140, 140)" d="M8.612,16.999 C8.255,16.999 7.899,16.856 7.628,16.569 L-0.001,8.497 L7.628,0.425 C8.168,-0.146 9.046,-0.150 9.589,0.418 C10.133,0.985 10.136,1.908 9.596,2.479 L3.909,8.497 L9.596,14.515 C10.136,15.086 10.133,16.009 9.589,16.576 C9.319,16.858 8.965,16.999 8.612,16.999 Z"/>  </svg>' +
        '</div>',
        nextArrow:'<div class="slick-arrow nextArrow">' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10px" height="17px">'+
        '<path fill-rule="evenodd"  fill="rgb(140, 140, 140)" d="M8.612,16.999 C8.255,16.999 7.899,16.856 7.628,16.569 L-0.001,8.497 L7.628,0.425 C8.168,-0.146 9.046,-0.150 9.589,0.418 C10.133,0.985 10.136,1.908 9.596,2.479 L3.909,8.497 L9.596,14.515 C10.136,15.086 10.133,16.009 9.589,16.576 C9.319,16.858 8.965,16.999 8.612,16.999 Z"/>  </svg>' +
        '</div>',
        responsive:[
            {
                breakpoint : 1270,
                settings:{
                    slidesToShow:4
                }
            },{
                breakpoint : 1000,
                settings:{
                    slidesToShow:3
                }

            },{
                breakpoint : 750,
                settings:{
                    slidesToShow:2,
                    dots:false
                }
            },{
                breakpoint : 500,
                settings:{
                    slidesToShow:1,
                    dots:false
                }
            }
        ]
    });
}
$(document).on('click','.productPage-top_info>.more-info' , function(){
    console.log(1);
        $('html , body').animate({scrollTop:$('.productPage-bottom').offset().top} , 500);
        $('.caracteristics').velocity({height : $('.caracteristics').attr('data-h') +'px'});
        $('.caracteristics').removeClass('closed');
        $('.productPage-bottom_caracteristics .more-info').html($('.productPage-bottom_caracteristics .more-info').attr('data-closed'))
    });
$(document).on('click','.productPage-bottom_caracteristics.big>.more-info',function(e){
    toggleBlock(e ,'.caracteristics' );
});
$(document).on('click','.productPage-bottom_description.big>.more-info',function(e){
    toggleBlock(e ,'.description' );
});
function initBlocks(id){
        if($('.'+id).innerHeight() > 400){
        $('.'+id).attr('data-h', $('.'+id).innerHeight())
        $('.'+id).css('height','400px');
        $('.'+id).addClass('closed');
        $('.productPage-bottom_'+id).addClass('big');
    }
}

function toggleBlock(e , id ){
    var el=e.target;
    if($(id).hasClass('closed')){
        $(id).velocity({
            height : $(id).attr('data-h') +'px'
        });
        $(id).removeClass('closed');

        $(el).html($(el).attr('data-closed'))
    }else{
        $(id).addClass('closed');
        $(id).velocity({
            height :'400px'
        })
        $(el).html($(el).attr('data-opened'))
    }
}

if(document.getElementById('productPage')){
     window.productPage=new Vue({
        el:"#productPage",
        data:{
            modal:{
                oneClick:false,
                delivery:false,
                oneC:{
                    isSent:false,
                    name:'',
                    phone:''
                }
            },
            product:window.productItem
        },
        methods:{
            removeError(name){
                this.errors.remove(name);
            },
            validate(){
                this.$validator.validateAll().then(result => {
                    if (result) {
                        this.modal.oneC.isSent = true;
                        return;
                    }else{
                        headerVue.$validator.validateAll()
                    }
                });
            }

        },
        watch:{
        },
        mounted(){
            prodSlideInit();
            initBlocks('caracteristics');
            initBlocks('description');
            initProductSlider('#similar-products');
        }

});
}