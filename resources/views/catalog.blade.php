@extends('layout')
@section('meta')

@stop
@section('content')
    <script>
        var options = [
            {
                name:'По возрастанию цены',
                id:'54541'
            },
            {
                name:'По убыванию цены',
                id:'54542'
            },
            {
                name:'По новизне',
                id:'54543'
            },
            {
                name:'По популярности',
                id:'54544'
            },
            {
                name:'По увеличению веса',
                id:'54545'
            },
            {
                name:'По уменьшению веса',
                id:'54546'
            },
        ]
    </script>
    <div id="catalogPage" class="catalogPage defaultPage">
        <div class="page-content">
            <div class="container">
                <div class="breadcrumbs">
                    <div class="breadcrumb"><a href="">Главная</a></div>
                    <div class="breadcrumb"><a href="">Строительные материалы</a></div>
                    <div class="breadcrumb"><a href="">Смеси кладочно-монтажные</a></div>
                    <div class="breadcrumb"><span>Грунт Ceresit CT17 5 л</span></div>
                </div>
                <div class="h1-title"><h1>Грунт Ceresit CT17 5 л</h1></div>
                <div class="sort">
                    <div class="sort-wrapper">
                        <span class="title-label">Сортировка:</span>
                        <multiselect v-model="filter"
                                     :options="options"
                                     track-by="id"
                                     label="name"
                                     v-on:input="changeFilter"
                                     v-model="filter"
                                     :hide-selected="true"
                                     placeholder="Сортировать по"
                                     :searchable="false"
                        ></multiselect>
                    </div>
                    <div class="paginator">qqq</div>
                </div>
                <div class="search-wrapper">
                    <div class="product">

                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                            <div class="fav">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="19px" height="18px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                        <g id="favorite">
                                            <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="stickers">
                                <span class="sticker new">Новинка</span>
                            </div>
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

                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                            <div class="fav">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="19px" height="18px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                        <g id="favorite">
                                            <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="stickers">
                                <span class="sticker new">Новинка</span>
                            </div>
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

                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                            <div class="fav">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="19px" height="18px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                        <g id="favorite">
                                            <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="stickers">
                                <span class="sticker new">Новинка</span>
                            </div>
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

                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                            <div class="fav">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="19px" height="18px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                        <g id="favorite">
                                            <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="stickers">
                                <span class="sticker new">Новинка</span>
                            </div>
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

                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                            <div class="fav">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="19px" height="18px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                        <g id="favorite">
                                            <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="stickers">
                                <span class="sticker new">Новинка</span>
                            </div>
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

                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                            <div class="fav">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="19px" height="18px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                        <g id="favorite">
                                            <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="stickers">
                                <span class="sticker new">Новинка</span>
                            </div>
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

                        <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
                            <div class="fav">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="19px" height="18px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve">
                                    <g>
                                        <g id="favorite">
                                            <path d="M255,489.6l-35.7-35.7C86.7,336.6,0,257.55,0,160.65C0,81.6,61.2,20.4,140.25,20.4c43.35,0,86.7,20.4,114.75,53.55    C283.05,40.8,326.4,20.4,369.75,20.4C448.8,20.4,510,81.6,510,160.65c0,96.9-86.7,175.95-219.3,293.25L255,489.6z"/>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="stickers">
                                <span class="sticker new">Новинка</span>
                            </div>
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
            </div>

        </div>

    </div>
@stop
