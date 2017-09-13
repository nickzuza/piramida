<template>
    <form action="" id="header-serach" name="header-search-form" class="search-wrapper">
        <div  class="search">
            <input type="text" v-model="searchData" v-on:keyup.esc="searchData = ''" v-on:keyup="searchResult"  :placeholder="placeHolder">
            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 451 451" style="enable-background:new 0 0 451 451;" xml:space="preserve" width="18px" height="18px">
                                     <g>
                                        <path d="M447.05,428l-109.6-109.6c29.4-33.8,47.2-77.9,47.2-126.1C384.65,86.2,298.35,0,192.35,0C86.25,0,0.05,86.3,0.05,192.3   s86.3,192.3,192.3,192.3c48.2,0,92.3-17.8,126.1-47.2L428.05,447c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4   C452.25,441.8,452.25,433.2,447.05,428z M26.95,192.3c0-91.2,74.2-165.3,165.3-165.3c91.2,0,165.3,74.2,165.3,165.3   s-74.1,165.4-165.3,165.4C101.15,357.7,26.95,283.5,26.95,192.3z"/>
                                    </g>
                                </svg>
            </button>
        </div>
        <transition name="fade">
            <div class="response" v-if="searchData.length > 2">

                <ul class="results" v-if=" searchRes !== ''">
                    <li class="result"  v-for="item in searchRes">
                        <a href=""><span v-text="item.name"></span></a>
                    </li>

                </ul>
                <button  class="more-results" v-if="searchResLen > 5">
                    Показать все результаты

                </button>
                <div class="no-results" v-if="searchRes.length == 0">
                    Нет резулитатов
                </div>

            </div>
        </transition>


    </form>
</template>
<script>
    export default{
        data(){
            return{
                searchData:'',
                searchRes:[]    ,
                searchResLen:0
            }
        },
        methods:{
            searchResult(e){
                if(this.searchData.length > 2){
                    this.ajaxSearch();
                }
            },
            ajaxSearch(){
                this.searchRes=[];
                var data = [];
                //test
                if (this.searchData.length < 9){
                    var max= 12 - this.searchData.length;
                }else{
                    var max = 1;
                }
                var objNum= Math.round(Math.random() * (max - 0) + 0 );
                for(var i = 0 ; i < objNum; i++){
                    var obj = {};
                    obj.name='test '+i;
                    obj.id=objNum+i;
                    data.push(obj);
                }
                if(data.length >= 5){
                    for(var i = 0; i< 5;i++){
                        this.searchRes.push(data[i]);
                    }
                }
                else{
                    this.searchRes = data;
                }
                this.searchResLen = data.length;

            }
        },
        props:['placeHolder']
    }
</script>