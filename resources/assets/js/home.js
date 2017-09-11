function homeSliderInit(){

    $('.home-slider').slick({
        slidesToShow:1,
        arrows:false,
        dots:true
    });
}
function initProductSlider(id){
    $(id+' .products-slider').not('.slick-initialized').css('opacity','0');
    $(id+' .products-slider').not('.slick-initialized').slick({
        slidesToShow:5,
        slidesToScroll:1,
        dots:true,
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
    $(id+' .products-slider').css('opacity','1');
}
if(document.getElementById('homePage')){

    window.homePage = new Vue({
        el:"#homePage",
        data:{
            activeTab:1
        },
        methods:{


        },
        mounted(){
            homeSliderInit();
            initProductSlider('#recomended-products');
            initProductSlider('#new-prods');
            initProductSlider('#partener-slider');
        },
        watch:{
            activeTab(){
                    if(this.activeTab === 1){
                        setTimeout(()=>{
                            if($('#new-prods .products-slider').length){
                                if($('#new-prods .products-slider').hasClass('slick-initialized')){
                                    $('#new-prods .products-slider').slick('unslick');
                                    setTimeout(()=>{
                                        initProductSlider('#new-prods');},50);
                                }
                                else{
                                    initProductSlider('#new-prods');
                                }
                            }
                        },50);
                    }else{
                        setTimeout(()=>{
                            if($('#auction-prods .products-slider').length){
                                if($('#auction-prods .products-slider').hasClass('slick-initialized')){

                                    $('#auction-prods .products-slider').slick('unslick');
                                    setTimeout(()=>{initProductSlider('#auction-prods');},50);
                                }
                                else{
                                    initProductSlider('#auction-prods');
                                }
                            }
                        },50);
                    }
            }
        }
    });
}