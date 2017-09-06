<template>
    <transition name="fade">
            <div class="product-item" >
                <div class="product-info">
                    <a href="#" class="img" :style="{backgroundImage : 'url('+item.img+')'}"></a>
                    <div class="title"><a href="#"  v-text="item.name"></a></div>
                </div>
                <div class="product-numbers">
                    <div class="price">
                        <span class="round" v-text="getRound(item.price.new)"></span>
                        <sup class="rest" v-text="getRest(item.price.new)"></sup>
                        <span class="sufix">Лей</span>
                    </div>
                    <div class="quantity">
                        <div class="item-quantity">
                            <button v-on:click="minus">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 491.858 491.858" width="12px" height="12px" xml:space="preserve">
                                                                    <g><g><path d="M465.167,211.613H240.21H26.69c-8.424,0-26.69,11.439-26.69,34.316s18.267,34.316,26.69,34.316h213.52h224.959    c8.421,0,26.689-11.439,26.689-34.316S473.59,211.613,465.167,211.613z"/></g></g>
                                                                </svg>
                            </button>
                            <input type="number" min="1" v-model="item.num" value="item.num">
                            <button v-on:click="plus">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 491.86 491.86" width="12" height="12 ">
                                    <g><g><path d="M465.167,211.614H280.245V26.691c0-8.424-11.439-26.69-34.316-26.69s-34.316,18.267-34.316,26.69v184.924H26.69    C18.267,211.614,0,223.053,0,245.929s18.267,34.316,26.69,34.316h184.924v184.924c0,8.422,11.438,26.69,34.316,26.69    s34.316-18.268,34.316-26.69V280.245H465.17c8.422,0,26.69-11.438,26.69-34.316S473.59,211.614,465.167,211.614z"/></g></g>
                                </svg>
                            </button >

                        </div>
                    </div>
                    <div class="sum" >
                        <div class="price">
                            <span class="round" v-text="getRound(totalSum)"></span>
                            <sup class="rest" v-text="getRest(totalSum)"></sup>
                            <span class="sufix">Лей</span>
                            <div class="remove" v-on:click="destroy">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 492 492" style="enable-background:new 0 0 492 492;" xml:space="preserve" width="13px" height="13">
                                    <g>
                                        <g>
                                            <path d="M300.188,246L484.14,62.04c5.06-5.064,7.852-11.82,7.86-19.024c0-7.208-2.792-13.972-7.86-19.028L468.02,7.872    c-5.068-5.076-11.824-7.856-19.036-7.856c-7.2,0-13.956,2.78-19.024,7.856L246.008,191.82L62.048,7.872    c-5.06-5.076-11.82-7.856-19.028-7.856c-7.2,0-13.96,2.78-19.02,7.856L7.872,23.988c-10.496,10.496-10.496,27.568,0,38.052    L191.828,246L7.872,429.952c-5.064,5.072-7.852,11.828-7.852,19.032c0,7.204,2.788,13.96,7.852,19.028l16.124,16.116    c5.06,5.072,11.824,7.856,19.02,7.856c7.208,0,13.968-2.784,19.028-7.856l183.96-183.952l183.952,183.952    c5.068,5.072,11.824,7.856,19.024,7.856h0.008c7.204,0,13.96-2.784,19.028-7.856l16.12-16.116    c5.06-5.064,7.852-11.824,7.852-19.028c0-7.204-2.792-13.96-7.852-19.028L300.188,246z"/>
                                        </g>
                                    </g>
                                </svg>
                                <span>Удалить</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </transition>
</template>
<script>
    export default{
        data(){
            return{
                item : this.product

            }
        },
        methods: {
            plus(){
                this.item.num++;
                this.$emit('get-total');
            },
            minus(){
                this.item.num--;
                this.$emit('get-total');
            },
            destroy(){
                this.$emit('close',this.arrPos);
                $(this.$el).fadeOut('500',function () {
                    $(this).remove();
                });
                this.$destroy();
            },
            getRound(price){
                return Math.floor(parseInt(price))
            },
            getRest(price){
                return (price - this.getRound(price))*100;
            }
        },
        props:['product' , 'arrPos'],
        mounted(){

            this.$emit('get-total');
        },

        computed:{
            totalSum(){
                var sum = this.item.price.new * this.item.num;
                return sum;
            }
        }
    }
</script>