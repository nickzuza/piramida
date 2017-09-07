@extends('layout')
@section('meta')

@stop
@section('content')
    <script>
        var cities = [
            {id:'someId',name:'chisinau'},
            {id:'anotherId',name:'soroca'}
        ];
        var historyItems=[
            {
                status:'wait',
                id:123123,
                time:{
                    date:'12.12.1997',
                    hour:'12:50'
                },
                items:[
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Грунт акриловый универсальный',
                        quantity:1,
                        price:958.10
                    },
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Aкриловый универсальный',
                        quantity:2,
                        price:918.10
                    },
                ]
            },
            {
                status:'done',
                id:123123,
                time:{
                    date:'10.12.1997',
                    hour:'11:50'
                },
                items:[
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Грунт акриловый универсальный',
                        quantity:1,
                        price:958.10
                    },

                ]
            },
            {
                status:'processing',
                id:123123,
                time:{
                    date:'10.12.1997',
                    hour:'11:50'
                },
                items:[
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Грунт акриловый универсальный',
                        quantity:1,
                        price:958.10
                    },
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Грунт акриловый универсальный',
                        quantity:1,
                        price:958.10
                    },
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Грунт акриловый универсальный',
                        quantity:1,
                        price:958.10
                    },
                ]
            },
            {
                status:'undone',
                id:123123,
                time:{
                    date:'10.12.1997',
                    hour:'11:50'
                },
                items:[
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Грунт акриловый универсальный',
                        quantity:1,
                        price:958.10
                    },
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Грунт акриловый универсальный',
                        quantity:1,
                        price:958.10
                    },
                    {
                        img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                        title:'Грунт акриловый универсальный',
                        quantity:1,
                        price:958.10
                    },
                ]
            }
        ];

    </script>
    <div id="userCabPage" class="userCab">
        <div class="page-content">
            <div class="container">
                <div class="userCab-wrapper">
                    <div class="userCab-left">

                            <ul class="menu-list" >
                                <li  :class="{active : tab===1}" @click="tab=1">Личные данные</li>
                                <li :class="{active : tab===2}" @click="tab=2">Избранные товары</li>
                                <li :class="{active : tab===3}" @click="tab=3">История покупок</li>
                                <li :class="{active : tab===4}" @click="tab=4">Изменить пароль</li>
                                <li :class="{active : tab===5}" @click="tab=5">Выход</li>
                            </ul>
                    </div>
                    <div class="userCab-right" v-cloak>
                        <transition name="fade">
                            <section v-if="tab===1">
                                <form action="" class="personalData" key="pData" >
                                    <div class="input-wrapper">
                                        <label for="">E-mail  </label>
                                        <div class="v-input"  :class="{ error: errors.has('form_userData_email')}">
                                            <input type="text"
                                                   v-validate="'required'"
                                                   name="form_userData_email"
                                                   v-model.lazy="form.userData.email"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_userData_email');"
                                            >
                                            <span class="error" v-if="errors.has('form_userData_email')">error</span>
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <label for="">Пароль   </label>
                                        <div class="v-input"  :class="{ error: errors.has('form_userData_pass')}">
                                            <input type="password"
                                                   v-validate="'required'"
                                                   name="form_userData_pass"
                                                   v-model.lazy="form.userData.pass"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_userData_pass');"
                                            >
                                            <span class="error" v-if="errors.has('form_userData_pass')">error</span>
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <label for="">Подтверждение пароля</label>
                                        <div class="v-input"  :class="{ error: errors.has('form_userData_confPass')}">
                                            <input type="password"
                                                   v-validate="'required'"
                                                   name="form_userData_confPass"
                                                   v-model.lazy="form.userData.confPass"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_userData_confPass');"
                                            >
                                            <span class="error" v-if="errors.has('form_userData_confPass')">error</span>
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <label for="">Ф.И.О.</label>
                                        <div class="v-input"  :class="{ error: errors.has('form_userData_name')}">
                                            <input type="text"
                                                   v-validate="'required'"
                                                   name="form_userData_name"
                                                   v-model.lazy="form.userData.name"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_userData_name');"
                                            >
                                            <span class="error" v-if="errors.has('form_userData_name')">error</span>
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <label for="">Телефон</label>
                                        <div class="v-input"  :class="{ error: errors.has('form_userData_phone')}">
                                            <input type="text"
                                                   v-validate="'required'"
                                                   name="form_userData_phone"
                                                   v-model.lazy="form.userData.phone"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_userData_phone');"
                                            >
                                            <span class="error" v-if="errors.has('form_userData_phone')">error</span>
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <label for="">Ваш Город</label>
                                        <div class="v-input"  >
                                            <multiselect v-model="form.userData.city"
                                                         :options="city"
                                                         track-by="name"
                                                         label="name"
                                                         :searchable="false"
                                                         :close-on-select="true"
                                                         :hide-selected="true"
                                                         :show-labels="false"
                                                         placeholder="Выберите город"
                                                         v-on:select="removeCity"
                                            ></multiselect>
                                            <input type="text"
                                                   v-model="form.userData.city.id"
                                                   name="form_userData_city"
                                                   v-validate="'required'"
                                                   v-on:change="removeError('form_userData_city');"
                                                   data-vv-validate-on="none"
                                                   hidden
                                            >
                                            <span class="error" v-if="errors.has('form_userData_city')">error</span>
                                        </div>
                                    </div>
                                    <div class="input-wrapper">
                                        <label for="">Адрес</label>
                                        <div class="v-input"  :class="{ error: errors.has('form_userData_address')}">
                                            <input type="text"
                                                   v-validate="'required'"
                                                   name="form_userData_address"
                                                   v-model.lazy="form.userData.address"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_userData_address');"
                                            >
                                            <span class="error" v-if="errors.has('form_userData_address')">error</span>
                                        </div>
                                    </div>
                                    <div class="four-inputs-wrapper">
                                        <div class="input-wrapper">
                                            <label for="">Дом</label>
                                            <div class="v-input"  :class="{ error: errors.has('form_userData_house')}">
                                                <input type="text"
                                                       v-validate="'required|min:2|max:30'"
                                                       name="form_userData_house"
                                                       v-model.lazy="form.userData.house"
                                                       data-vv-validate-on="none"
                                                       v-on:focus="removeError('form_userData_house');"
                                                >
                                                <span class="error" v-if="errors.has('form_userData_house')">error</span>
                                            </div>
                                        </div>
                                        <div class="input-wrapper">
                                            <label for="">Подьезд</label>
                                            <div class="v-input"  :class="{ error: errors.has('form_userData_door')}">
                                                <input type="text"
                                                       v-validate="'required|min:2|max:30'"
                                                       name="form_userData_door"
                                                       v-model.lazy="form.userData.door"
                                                       data-vv-validate-on="none"
                                                       v-on:focus="removeError('form_userData_door');"
                                                >
                                                <span class="error" v-if="errors.has('form_userData_door')">error</span>
                                            </div>
                                        </div>
                                        <div class="input-wrapper">
                                            <label for="">Этаж</label>
                                            <div class="v-input"  :class="{ error: errors.has('form_userData_level')}">
                                                <input type="text"
                                                       v-validate="'required|min:2|max:30'"
                                                       name="form_userData_level"
                                                       v-model.lazy="form.userData.level"
                                                       data-vv-validate-on="none"
                                                       v-on:focus="removeError('form_userData_level');"
                                                >
                                                <span class="error" v-if="errors.has('form_userData_level')">error</span>
                                            </div>
                                        </div>
                                        <div class="input-wrapper">
                                            <label for="">Квартира</label>
                                            <div class="v-input"  :class="{ error: errors.has('form_userData_room')}">
                                                <input type="text"
                                                       v-validate="'required|min:2|max:30'"
                                                       name="form_userData_room"
                                                       v-model.lazy="form.userData.room"
                                                       data-vv-validate-on="none"
                                                       v-on:focus="removeError('form_userData_room');"
                                                >
                                                <span class="error" v-if="errors.has('form_userData_room')">error</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" @click="validateForm" class="main-butt">Сохранить</button>
                                </form>
                            </section>
                        </transition>
                        <transition name="fade">
                            <section v-if="tab===2" >
                                <div class="products-wrapper">
                                    <div class="product">
                                        <div class="deleteProd">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 212.982 212.982" xml:space="preserve" width="15" height="15">
                                                <g>
                                                    <path style="fill-rule:evenodd;clip-rule:evenodd;" d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312   c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312   l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937   c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                                        </div>
                                        <a href="" class="product-title">
                                            Профиль UD  (Standard) 3m/4m
                                        </a>
                                        <div class="product-bottom">
                                            <div class="prices">
                                                <div class="old-price"><span>1788</span> <b>лей</b> </div>
                                                <div class="new-price"><span>1788</span> <b>лей</b></div>
                                            </div>
                                            <button class="to-cart"></button>
                                        </div>
                                    </div>
                                    <div class="product">
                                        <div class="deleteProd">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 212.982 212.982" xml:space="preserve" width="15" height="15">
                                                <g>
                                                    <path style="fill-rule:evenodd;clip-rule:evenodd;" d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312   c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312   l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937   c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                                        </div>
                                        <a href="" class="product-title">
                                            Профиль UD  (Standard) 3m/4m
                                        </a>
                                        <div class="product-bottom">
                                            <div class="prices">
                                                <div class="old-price"><span>1788</span> <b>лей</b> </div>
                                                <div class="new-price"><span>1788</span> <b>лей</b></div>
                                            </div>
                                            <button class="to-cart"></button>
                                        </div>
                                    </div>
                                    <div class="product">
                                        <div class="deleteProd">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 212.982 212.982" xml:space="preserve" width="15" height="15">
                                                <g>
                                                    <path style="fill-rule:evenodd;clip-rule:evenodd;" d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312   c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312   l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937   c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                                        </div>
                                        <a href="" class="product-title">
                                            Профиль UD  (Standard) 3m/4m
                                        </a>
                                        <div class="product-bottom">
                                            <div class="prices">
                                                <div class="old-price"><span>1788</span> <b>лей</b> </div>
                                                <div class="new-price"><span>1788</span> <b>лей</b></div>
                                            </div>
                                            <button class="to-cart"></button>
                                        </div>
                                    </div>
                                    <div class="product">
                                        <div class="deleteProd">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 212.982 212.982" xml:space="preserve" width="15" height="15">
                                                <g>
                                                    <path style="fill-rule:evenodd;clip-rule:evenodd;" d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312   c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312   l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937   c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                                        </div>
                                        <a href="" class="product-title">
                                            Профиль UD  (Standard) 3m/4m
                                        </a>
                                        <div class="product-bottom">
                                            <div class="prices">
                                                <div class="old-price"><span>1788</span> <b>лей</b> </div>
                                                <div class="new-price"><span>1788</span> <b>лей</b></div>
                                            </div>
                                            <button class="to-cart"></button>
                                        </div>
                                    </div>
                                    <div class="product">
                                        <div class="deleteProd">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 212.982 212.982" xml:space="preserve" width="15" height="15">
                                                <g>
                                                    <path style="fill-rule:evenodd;clip-rule:evenodd;" d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312   c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312   l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937   c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                                        </div>
                                        <a href="" class="product-title">
                                            Профиль UD  (Standard) 3m/4m
                                        </a>
                                        <div class="product-bottom">
                                            <div class="prices">
                                                <div class="old-price"><span>1788</span> <b>лей</b> </div>
                                                <div class="new-price"><span>1788</span> <b>лей</b></div>
                                            </div>
                                            <button class="to-cart"></button>
                                        </div>
                                    </div>
                                    <div class="product">
                                        <div class="deleteProd">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 212.982 212.982" xml:space="preserve" width="15" height="15">
                                                <g>
                                                    <path style="fill-rule:evenodd;clip-rule:evenodd;" d="M131.804,106.491l75.936-75.936c6.99-6.99,6.99-18.323,0-25.312   c-6.99-6.99-18.322-6.99-25.312,0l-75.937,75.937L30.554,5.242c-6.99-6.99-18.322-6.99-25.312,0c-6.989,6.99-6.989,18.323,0,25.312   l75.937,75.936L5.242,182.427c-6.989,6.99-6.989,18.323,0,25.312c6.99,6.99,18.322,6.99,25.312,0l75.937-75.937l75.937,75.937   c6.989,6.99,18.322,6.99,25.312,0c6.99-6.99,6.99-18.322,0-25.312L131.804,106.491z"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                                        </div>
                                        <a href="" class="product-title">
                                            Профиль UD  (Standard) 3m/4m
                                        </a>
                                        <div class="product-bottom">
                                            <div class="prices">
                                                <div class="old-price"><span>1788</span> <b>лей</b> </div>
                                                <div class="new-price"><span>1788</span> <b>лей</b></div>
                                            </div>
                                            <button class="to-cart"></button>
                                        </div>
                                    </div>



                                </div>
                            </section>
                        </transition>
                        <transition name="fade">
                            <section v-if="tab===3">
                                <div class="historyProd-wrapper" >
                                    <div class="labels">
                                        <span class="icon title-label">Статус</span>
                                        <span class="date title-label">Дата</span>
                                        <span class="id title-label">Номер заказа</span>
                                        <span class="content title-label">Содержимое</span>
                                        <span class="sum title-label">Сумма</span>
                                    </div>

                                    <div class="hItem" v-for="item in hProds" :class="[item.status , {big : item.items.length > 1} , {closed : item.items.length > 1} ]">
                                         <div class="hItem-info">
                                             <div class="icon-wrapper">
                                                 <span class="title-label">Статус</span>
                                                <div class="icon"></div>
                                             </div>
                                             <div class="date">
                                                 <span class="title-label">Дата</span>
                                                 <span class="data" v-text="item.time.date"></span>
                                                 <span class="hour" v-text="item.time.hour"></span>
                                             </div>
                                         </div>
                                        <div class="hItem-prod">

                                            <div class="id" >
                                                <span class="title-label">Номер заказа</span>
                                                <label v-text="item.id"></label>
                                            </div>
                                            <div class="hItem-list">
                                                <span class="content title-label">Содержимое</span>
                                                <ul >
                                                    <li v-for="product in item.items">
                                                        <div class="item-desc">
                                                            <div class="img" :style="{backgroundImage: 'url('+product.img+')'}"></div>
                                                            <div class="item-info">
                                                                <a href="#" class="title" v-text="product.title"></a>
                                                                <div class="count">
                                                                    <span v-text="product.quantity"></span>
                                                                    <span>x</span>
                                                                    <span v-text="getRound(product.price)"></span>
                                                                    <sup v-text="getRest(product.price)"></sup>
                                                                    <span>лей</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="sum">
                                                <span class="title-label">Сумма</span>
                                                <span class="integer" v-text="getRound(getTotal(item))"></span>
                                                <sup class="rest" v-text="getRest(getTotal(item))">50</sup>
                                                <span class="sufix">лей</span>
                                            </div>
                                        </div>
                                        <div class="more-info" data-open="Посмотреть все" data-close="Скрыть">Посмотреть все</div>


                                    </div>

                                    {{--<div class="hItem wait">--}}
                                        {{--<div class="hItem-info">--}}
                                            {{--<div class="icon-wrapper">--}}
                                                {{--<div class="icon">--}}

                                                {{--</div>--}}

                                            {{--</div>--}}
                                            {{--<div class="date">--}}
                                                {{--<span class="data">28.09.2017</span>--}}
                                                {{--<span class="hour">12:25</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="id">--}}
                                                {{--542054--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="hItem-prod">--}}
                                            {{--<ul class="hItem-list">--}}

                                                {{--<li>--}}
                                                    {{--<div class="item-desc">--}}
                                                        {{--<div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)"></div>--}}
                                                        {{--<div class="item-info">--}}
                                                            {{--<a href="#" class="title">Грунт акриловый универсальный</a>--}}
                                                            {{--<div class="count">--}}
                                                                {{--<span>1</span>--}}
                                                                {{--<span>x</span>--}}
                                                                {{--<span>958</span>--}}
                                                                {{--<sup>10</sup>--}}
                                                                {{--<span>лей</span>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}
                                                {{--<li>--}}
                                                    {{--<div class="item-desc">--}}
                                                        {{--<div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)"></div>--}}
                                                        {{--<div class="item-info">--}}
                                                            {{--<a href="#" class="title">Грунт акриловый универсальный</a>--}}
                                                            {{--<div class="count">--}}
                                                                {{--<span>1</span>--}}
                                                                {{--<span>x</span>--}}
                                                                {{--<span>958</span>--}}
                                                                {{--<sup>10</sup>--}}
                                                                {{--<span>лей</span>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}
                                                {{--<li>--}}
                                                    {{--<div class="item-desc">--}}
                                                        {{--<div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)"></div>--}}
                                                        {{--<div class="item-info">--}}
                                                            {{--<a href="#" class="title">Грунт акриловый универсальный</a>--}}
                                                            {{--<div class="count">--}}
                                                                {{--<span>1</span>--}}
                                                                {{--<span>x</span>--}}
                                                                {{--<span>958</span>--}}
                                                                {{--<sup>10</sup>--}}
                                                                {{--<span>лей</span>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                            {{--<div class="sum">--}}
                                                {{--<span class="integer">22158</span>--}}
                                                {{--<sup class="rest">50</sup>--}}
                                                {{--<span class="sufix">лей</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}


                                        {{--<div class="more-info" data-open="Посмотреть все" data-close="Скрыть">Посмотреть все</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="hItem done">--}}
                                        {{--<div class="hItem-info">--}}
                                            {{--<div class="icon-wrapper">--}}
                                                {{--<div class="icon">--}}

                                                {{--</div>--}}

                                            {{--</div>--}}
                                            {{--<div class="date">--}}
                                                {{--<span class="data">28.09.2017</span>--}}
                                                {{--<span class="hour">12:25</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="id">--}}
                                                {{--542054--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="hItem-prod">--}}
                                            {{--<ul class="hItem-list">--}}

                                                {{--<li>--}}
                                                    {{--<div class="item-desc">--}}
                                                        {{--<div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)"></div>--}}
                                                        {{--<div class="item-info">--}}
                                                            {{--<a href="#" class="title">Грунт акриловый универсальный</a>--}}
                                                            {{--<div class="count">--}}
                                                                {{--<span>1</span>--}}
                                                                {{--<span>x</span>--}}
                                                                {{--<span>958</span>--}}
                                                                {{--<sup>10</sup>--}}
                                                                {{--<span>лей</span>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                            {{--<div class="sum">--}}
                                                {{--<span class="integer">22158</span>--}}
                                                {{--<sup class="rest">50</sup>--}}
                                                {{--<span class="sufix">лей</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}


                                        {{--<div class="more-info" data-open="Посмотреть все" data-close="Скрыть">Посмотреть все</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="hItem undone">--}}
                                        {{--<div class="hItem-info">--}}
                                            {{--<div class="icon-wrapper">--}}
                                                {{--<div class="icon">--}}

                                                {{--</div>--}}

                                            {{--</div>--}}
                                            {{--<div class="date">--}}
                                                {{--<span class="data">28.09.2017</span>--}}
                                                {{--<span class="hour">12:25</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="id">--}}
                                                {{--542054--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="hItem-prod">--}}
                                            {{--<ul class="hItem-list">--}}

                                                {{--<li>--}}
                                                    {{--<div class="item-desc">--}}
                                                        {{--<div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)"></div>--}}
                                                        {{--<div class="item-info">--}}
                                                            {{--<a href="#" class="title">Грунт акриловый универсальный</a>--}}
                                                            {{--<div class="count">--}}
                                                                {{--<span>1</span>--}}
                                                                {{--<span>x</span>--}}
                                                                {{--<span>958</span>--}}
                                                                {{--<sup>10</sup>--}}
                                                                {{--<span>лей</span>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                            {{--<div class="sum">--}}
                                                {{--<span class="integer">22158</span>--}}
                                                {{--<sup class="rest">50</sup>--}}
                                                {{--<span class="sufix">лей</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}


                                        {{--<div class="more-info" data-open="Посмотреть все" data-close="Скрыть">Посмотреть все</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="hItem processing">--}}
                                        {{--<div class="hItem-info">--}}
                                            {{--<div class="icon-wrapper">--}}
                                                {{--<div class="icon">--}}

                                                {{--</div>--}}

                                            {{--</div>--}}
                                            {{--<div class="date">--}}
                                                {{--<span class="data">28.09.2017</span>--}}
                                                {{--<span class="hour">12:25</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="id">--}}
                                                {{--542054--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="hItem-prod">--}}
                                            {{--<ul class="hItem-list">--}}

                                                {{--<li>--}}
                                                    {{--<div class="item-desc">--}}
                                                        {{--<div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)"></div>--}}
                                                        {{--<div class="item-info">--}}
                                                            {{--<a href="#" class="title">Грунт акриловый универсальный</a>--}}
                                                            {{--<div class="count">--}}
                                                                {{--<span>1</span>--}}
                                                                {{--<span>x</span>--}}
                                                                {{--<span>958</span>--}}
                                                                {{--<sup>10</sup>--}}
                                                                {{--<span>лей</span>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                            {{--<div class="sum">--}}
                                                {{--<span class="integer">22158</span>--}}
                                                {{--<sup class="rest">50</sup>--}}
                                                {{--<span class="sufix">лей</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}


                                        {{--<div class="more-info" data-open="Посмотреть все" data-close="Скрыть">Посмотреть все</div>--}}
                                    {{--</div>--}}


                                </div>
                            </section>
                        </transition>
                        <transition name="fade">
                            <section v-if="tab===4">
                                <form action="" class="change-pass" key="cPass">
                                    <div class="input-wrapper">
                                        <label for="">Текущий пароль </label>
                                        <div class="v-input"  :class="{ error: errors.has('form_changePass_actPass')}">
                                            <input type="password"
                                                   v-validate="'required'"
                                                   name="form_changePass_actPass"
                                                   v-model.lazy="form.changePass.actPass"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_changePass_actPass');"
                                            >
                                            <span class="error" v-if="errors.has('form_changePass_actPass')">error</span>
                                        </div>

                                    </div>
                                    <div class="input-wrapper">
                                        <label for="">Новый пароль  </label>
                                        <div class="v-input"  :class="{ error: errors.has('form_changePass_newPass')}">
                                            <input type="password"
                                                   v-validate="'required'"
                                                   name="form_changePass_newPass"
                                                   v-model.lazy="form.changePass.newPass"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_changePass_newPass');"
                                            >
                                            <span class="error" v-if="errors.has('form_changePass_newPass')">error</span>
                                        </div>

                                    </div>
                                    <div class="input-wrapper">
                                        <label for="">Новый пароль еще раз </label>
                                        <div class="v-input"  :class="{ error: errors.has('form_changePass_confNewPass')}">
                                            <input type="password"
                                                   v-validate="'required'"
                                                   name="form_changePass_confNewPass"
                                                   v-model.lazy="form.changePass.actNewPass"
                                                   data-vv-validate-on="none"
                                                   v-on:focus="removeError('form_changePass_confNewPass');"
                                            >
                                            <span class="error" v-if="errors.has('form_changePass_confNewPass')">error</span>
                                        </div>

                                    </div>
                                    <button type="button" v-on:click="validate()" class="main-butt">Изменить</div>
                                </form>
                            </section>
                        </transition>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop