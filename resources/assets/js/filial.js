import productSlider from './components/productsCatalog';
function sliderInit(){
    $('.home-slider:not(.slick-initialised)').slick({
        slidesToShow:1,
        dots:true,
        arrows:true,
        prevArrow:'<div class="slick-arrow slickPrev">' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11px" height="18px">'+
        '<path fill-rule="evenodd"  d="M1.526,18.000 C1.919,18.000 2.311,17.848 2.609,17.544 L11.001,9.000 L2.609,0.455 C2.015,-0.149 1.049,-0.153 0.451,0.448 C-0.147,1.048 -0.150,2.025 0.444,2.630 L6.700,9.000 L0.444,15.370 C-0.150,15.974 -0.147,16.951 0.451,17.552 C0.749,17.851 1.138,18.000 1.526,18.000 Z"/>'+
        '</svg>'+
        '</div>',
        nextArrow:'<div class="slick-arrow slickNext">' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11px" height="18px">'+
        '<path fill-rule="evenodd"  d="M1.526,18.000 C1.919,18.000 2.311,17.848 2.609,17.544 L11.001,9.000 L2.609,0.455 C2.015,-0.149 1.049,-0.153 0.451,0.448 C-0.147,1.048 -0.150,2.025 0.444,2.630 L6.700,9.000 L0.444,15.370 C-0.150,15.974 -0.147,16.951 0.451,17.552 C0.749,17.851 1.138,18.000 1.526,18.000 Z"/>'+
        '</svg>'+
        '</div>'
    });
}
if(document.getElementById('filialPage')){

    window.filialPage=new Vue({
        el:"#filialPage",
        data:{
            lang:1,
            filialTab:2,
            sCatItem:1,
            catProdImgs:['https://www.taglinx.com/layout/images/noproduct.jpg.gif']
        },
        methods:{
            // changeCategory(id , e){
            //     this.sCatItem = id;
            // }
        },
        watch:{
            sCatItem(){
                this.catProdImgs = JSON.parse($('#cat-'+ this.sCatItem).attr('data-img'));
            }
        },
        components:{productSlider},
        mounted(){
            sliderInit();
            this.catProdImgs = JSON.parse($('#cat-'+ this.sCatItem).attr('data-img'));
            $('.product-slider-wrapper-arrow').velocity({
                left:$('.catalog-list li.active').position().left+'px'
            })
        }
    });

    $('.catalog-list li').on('click',function(e){
        var el =e.currentTarget;
        if(window.innerWidth <1270){

            var slider = $('.product-slider-wrapper').offset().top;
            $('html , body').animate({scrollTop: slider+'px'} , 500);
        }
        var left = $(el).position().left;
        $('.product-slider-wrapper-arrow').velocity({
            left:$('.catalog-list li.active').position().left+'px'
        })

    });

    $('.bottom-menu>li>a').click(function(e){
        if(window.innerHeight < 1270){
            e.preventDefault();
        }
    });
    $('.mob-menu-butt').click(function(){
        $('.bottom-menu').velocity({
            top:0
        });
    });
    $('.mob-men-close').click(function(){
        $('.bottom-menu').velocity({
            top:'-100vh'
        });
    });
    $(window).on('resize' , function(){
        $('.product-slider-wrapper-arrow').velocity({
            left:$('.catalog-list li.active').position().left+'px'
        })
    });
 }
