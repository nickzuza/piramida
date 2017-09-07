<template>
    <div class="product-slider">
        <div class="slide-img" v-for="(item , index) in imgs" :key="index">
            <a :href="item" :data-lightbox="index"  rel='lightbox' class="img" :style="{backgroundImage:'url('+item+')'}"></a>
        </div>

    </div>
</template>
<script>
    export default{
        data(){
            return{
                imgs:this.sliderImgs
            }
        },
        methods:{
        },
        props:['sliderImgs'],
        mounted(){
            setTimeout(function () {
                slickInit();
            } , 300);
        },
        watch:{
            sliderImgs(){
                $('.product-slider').css('opacity','0');
                $('.product-slider.slick-initialized').slick('unslick');
                this.imgs = this.sliderImgs;

                setTimeout(function(){
                    slickInit();
                    $('.product-slider').css('opacity','1');
                },100);
            }
        }
    }
    function slickInit() {

        $('.product-slider:not(.slick-initialized)').slick({
            slidesToShow:5,
            slidesToScroll:1,
            arrows:true,
            prevArrow:'<div class="slick-arrow prevArrow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="42px" height="52px">'+
            '<path fill-rule="evenodd" d="M16.906,51.925 L16.906,52.000 L-0.000,52.000 L-0.000,-0.000 L16.906,-0.000 L16.906,0.294 C30.851,0.826 42.000,12.163 42.000,26.109 C42.000,40.056 30.851,51.392 16.906,51.925 ZM21.556,18.630 C22.150,18.025 22.146,17.048 21.548,16.448 C20.951,15.848 19.984,15.851 19.391,16.456 L10.999,25.000 L19.391,33.544 C19.689,33.848 20.081,34.000 20.473,34.000 C20.862,34.000 21.251,33.851 21.548,33.552 C22.146,32.951 22.150,31.974 21.556,31.370 L15.300,25.000 L21.556,18.630 Z"/>'+
            '</svg></div>',
            nextArrow:'<div class="slick-arrow nextArrow">'+
            '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="42px" height="52px">'+
            '<path fill-rule="evenodd" d="M25.094,52.000 L25.094,51.925 C11.149,51.392 -0.000,40.056 -0.000,26.109 C-0.000,12.163 11.149,0.826 25.094,0.294 L25.094,-0.000 L42.000,-0.000 L42.000,52.000 L25.094,52.000 ZM22.609,16.456 C22.016,15.851 21.049,15.848 20.451,16.448 C19.854,17.048 19.850,18.025 20.444,18.630 L26.700,25.000 L20.444,31.370 C19.850,31.974 19.854,32.951 20.451,33.552 C20.749,33.851 21.138,34.000 21.527,34.000 C21.919,34.000 22.311,33.848 22.609,33.544 L31.001,25.000 L22.609,16.456 Z"/>'+
            '</svg></div>',
            responsive:[
                {breakpoint:1270 , settings:{slidesToShow:4}},
                {breakpoint:1000 , settings:{slidesToShow:3}},
                {breakpoint:650 , settings:{slidesToShow:2}},
                {breakpoint:450 , settings:{slidesToShow:1}}
            ]
        });
    }
</script>