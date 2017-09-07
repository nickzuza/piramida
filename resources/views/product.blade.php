@extends('layout')
@section('meta')

@stop
@section('content')
    <script xmlns:v-on="http://www.w3.org/1999/xhtml">
        window.productItem = {
            id:123123,
            images:[
                'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                'https://i.simpalsmedia.com/marketplace/products/original/5bf5c63b975d9e1ea2f44f027c8741ef.jpg',
                'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                'https://i.simpalsmedia.com/marketplace/products/original/5bf5c63b975d9e1ea2f44f027c8741ef.jpg',
                'https://i.simpalsmedia.com/marketplace/products/original/f606551bddac4e89a2908871f4ff1ffb.jpg',
                'https://i.simpalsmedia.com/marketplace/products/original/672c311e9c5e2d123fd9f6a99bc09ab1.jpg',
                'https://i.simpalsmedia.com/marketplace/products/original/77bbef892f9d50eda817de92559b25cd.jpg'
            ],
            onFav:false,
            cartQuant:1,
            onCart:false
        }
    </script>
    <div id="productPage" class="productPage">

        <div class="page-content">
            <div class="container">
                <div class="breadcrumbs">
                    <div class="breadcrumb"><a href="">Главная</a></div>
                    <div class="breadcrumb"><a href="">Строительные материалы</a></div>
                    <div class="breadcrumb"><a href="">Смеси кладочно-монтажные</a></div>
                    <div class="breadcrumb"><span>Грунт Ceresit CT17 5 л</span></div>
                </div>
                <div class="h1-title"><h1>Грунт Ceresit CT17 5 л</h1></div>
                <div class="productPage-top">
                    <div class="info-id">
                        Артикул:
                        <span v-text="product.id"></span>
                    </div>
                    <div class="productPage-top_slider">
                        <div class="slider-min" >
                            <div class="slide" v-for="(item , index) in product.images" key="'min'+index" :style="{backgroundImage : 'url('+item+')'}"></div>
                        </div>
                        <div class="slider-max">
                            <div class="slide" v-for="(item , index) in product.images" key="'max'+index" :style="{backgroundImage : 'url('+item+')'}">
                                <a :href="item" data-lightbox="prodImg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 512 512" height="22" width="22                                                                                             ">
                                        <g>
                                            <g>
                                                <path d="m289.8,200.2h-49.3v-49.3c0-11.3-9.1-20.4-20.4-20.4-11.3,0-20.4,9.1-20.4,20.4v49.3h-49.3c-11.3,0-20.4,9.1-20.4,20.4 0,11.3 9.1,20.4 20.4,20.4h49.3v49.3c0,11.3 9.1,20.4 20.4,20.4 11.3,0 20.4-9.1 20.4-20.4v-49.3h49.3c11.3,0 20.4-9.1 20.4-20.4 0-11.3-9.2-20.4-20.4-20.4z"/>
                                                <path d="m220.2,388.7c-92.9,0-168.2-75.2-168.2-168.1s75.3-168.1 168.2-168.1 168.1,75.3 168.1,168.1-75.3,168.1-168.1,168.1zm274.8,78l-113.3-113.3c29.7-36.1 47.6-82.4 47.6-132.8 0-115.5-93.6-209.2-209.2-209.2s-209.1,93.7-209.1,209.2 93.6,209.2 209.2,209.2c50.4,0 96.6-17.8 132.7-47.5l113.3,113.3c5.2,5.3 21.1,7.9 28.9,0 7.9-8 7.9-20.9-0.1-28.9z"/>
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="productPage-top_info">
                        <div class="main-info">
                            <div class="information-wrapper">
                                <div class="information-title">Вес:</div>
                                <div class="information-val">1.00kg</div>
                            </div>
                            <div class="information-wrapper">
                                <div class="information-title">Высота:</div>
                                <div class="information-val">23.4cm</div>
                            </div>
                            <div class="information-wrapper">
                                <div class="information-title">Глубина:</div>
                                <div class="information-val">10.1cm</div>
                            </div>

                        </div>
                        <div class="more-info" >Все характеристики </div>
                        <button class="delivery-butt" v-on:click="modal.delivery = true"><span>Способы доставки</span></button>
                        <modal v-if="modal.delivery" v-on:close="modal.delivery = false" v-cloak class="modal-base registration mobilemenu">
                            <h2 class="header-fog_title">Способы доставки</h2>
                            <div class="header-fog_text">
                                <span class="paragraf-title">Самовывоз</span>
                                <p>Вы можете получить свой заказ на складе (г. Кишинев, ул. Узинелor 10/2)</p>
                                <span class="paragraf-title">Курьерская доставка</span>
                                <p>
                                    Стоимость доставки заказов до 40 000 руб. в пределах Кишинева и населенные пункты на расстоянии до 20 км от города составляет 300 лей.; в населенные пункты на расстоянии до 50 км  – 1100 лей.
                                    За исключением крупногабаритных товаров, стоимость доставки которых в пределах Кишинева и населенные пункты на расстоянии до 20 км от Кишинева составляет 1000 лей.
                                </p>
                            </div>
                        </modal>
                    </div>
                    <div class="productPage-top_cart">
                        <div class="cart-price">
                            <span class="cart-label">Цена </span>
                            <span class="price">227 <sup>50</sup></span>
                            <span class="valuta">лей</span></div>
                        <div class="cart-quantity">
                            <span class="cart-label">Кол-во</span>
                            <div class="item-quantity">
                                <button v-on:click="product.cartQuant--">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 491.858 491.858" width="12px" height="12px" xml:space="preserve">
                                            <g><g><path d="M465.167,211.613H240.21H26.69c-8.424,0-26.69,11.439-26.69,34.316s18.267,34.316,26.69,34.316h213.52h224.959    c8.421,0,26.689-11.439,26.689-34.316S473.59,211.613,465.167,211.613z"/></g></g>
                                    </svg>
                                </button>
                                <input type="number" min="1" v-model="product.cartQuant">
                                <button v-on:click="product.cartQuant++">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 491.86 491.86" width="12" height="12 ">
                                        <g><g><path d="M465.167,211.614H280.245V26.691c0-8.424-11.439-26.69-34.316-26.69s-34.316,18.267-34.316,26.69v184.924H26.69    C18.267,211.614,0,223.053,0,245.929s18.267,34.316,26.69,34.316h184.924v184.924c0,8.422,11.438,26.69,34.316,26.69    s34.316-18.268,34.316-26.69V280.245H465.17c8.422,0,26.69-11.438,26.69-34.316S473.59,211.614,465.167,211.614z"/></g></g>
                                    </svg>
                                </button >

                            </div>
                            <span class="cart-label">шт.</span>
                        </div>
                        <button class="yellow-butt"><span>В корзину</span></button>
                        <button class="oneClick" v-on:click="modal.oneClick = true"><span>Купить в один клик</span></button>
                        <modal v-if="modal.oneClick" v-on:close="modal.oneClick = false" v-cloak class="modal-base registration mobilemenu">
                            <h2 class="header-fog_title">Быстрый заказ</h2>
                            <div v-if="!modal.oneC.isSent">
                                <div class="editor header-fog_text">Заполните форму, и наши менеджеры свяжутся с вами в течение часa</div>
                                <div class="input-wrapper">
                                    <label>Укажите ваше имя:</label>
                                    <input type="text"
                                           v-validate="'required|min:2|max:30'"
                                           v-model="modal.oneC.name"
                                           name="modal_oneC_name"
                                           data-vv-validate-on="none"
                                           v-on:focus="removeError('modal_oneC_name')"
                                           v-on:change="modal.oneC.error = false"
                                    >
                                    <span :class="{error: errors.has('modal_oneC_name')}"
                                          v-if="errors.has('modal_oneC_name')"
                                    >@lang('l.email_valid')</span>
                                    <span class="error" v-if="modal.oneC.error">@lang('l.user_not_exist')</span>
                                </div>
                                <div class="input-wrapper">
                                    <label>Укажите ваш телефон:</label>
                                    <input type="text"
                                           v-validate="'required|min:6|max:12'"
                                           v-model="modal.oneC.phone"
                                           name="modal_oneC_phone"
                                           data-vv-validate-on="none"
                                           v-on:focus="removeError('modal_oneC_phone')"
                                           v-on:change="modal.oneC.error = false"
                                    >
                                    <span :class="{error: errors.has('modal_oneC_phone')}"
                                          v-if="errors.has('modal_oneC_phone')"
                                    >@lang('l.email_valid')</span>
                                    <span class="error" v-if="modal.oneC.error">@lang('l.user_not_exist')</span>
                                </div>
                                <div class="btn-wrapper">
                                    <button v-on:click="validate">Отправить</button>
                                </div>
                            </div>
                            <div v-if="modal.oneC.isSent">
                                <div class="editor header-fog_text">
                                    Ждите звонка
                                </div>
                            </div>

                        </modal>

                        <button class="addToFav"><span>Добавить в избранные</span></button>
                    </div>
                </div>
                <div class="productPage-bottom">
                    <div class="productPage-bottom_caracteristics">
                        <div class="block-title">Характеристики</div>
                        <div class="caracteristics" v-cloak>
                            <div><span>Артикул:</span><span>15848303</span></div>
                            <div><span>Вес, кг:</span><span>12</span></div>
                            <div><span> Страна-производитель:</span><span>Россия</span></div>
                            <div><span>Назначение:</span><span>подготовка поверхности (грунтование)</span></div>
                            <div><span>Марка:</span><span>Боларс</span></div>
                            <div><span>Материал основания:</span><span>бетонные, кирпичные, каменные и оштукатуренные поверхности, ГВЛ, ГКЛ, ПГП</span></div>
                            <div><span>Область применения:</span><span>для внутренних и наружных работ, для увеличения адгезии наносимых материалов путем придания основаниям шероховатости</span></div>
                            <div><span>Артикул:</span><span>15848303</span></div>
                            <div><span>Вес, кг:</span><span>12</span></div>
                            <div><span> Страна-производитель:</span><span>Россия</span></div>
                            <div><span>Назначение:</span><span>подготовка поверхности (грунтование)</span></div>
                            <div><span>Марка:</span><span>Боларс</span></div>
                        </div>
                        <div class="more-info" data-opened="Все характеристики" data-closed="Скрыть характеристики">Все характеристики </div>

                    </div>
                    <div class="productPage-bottom_description">
                        <div class="block-title">Описание</div>
                        <div class="editor description" v-cloak>
                            Легкая невесомая увлажняющая маска с эффектом anti-frizz облегчает расчесывание волос, делая их более мягкими и блестящими. Входящие в состав эссенция лаванды и сыворотка винограда способствуют формированию идеальных волн и завитков, не утяжеляя и не перегружая волосы.

                            Способ применения: после использования шампуня PRECIOUS NATURE SHAMPOO FOR CURLY&WAVY HAIR, распределить маску по волосам и оставить для воздействия на 3‐5 минут. Промыть волосы водой. Для большего кондиционирующего эффекта и контроля объема: нанести небольшое
                            количество маски на влажные волосы и не смывать.

                            100% натуральный ингредиент. НЕ СОДЕРЖИТ: сульфатов, парабенов, парафинов, минеральных масел, синтетических веществ, аллергенов**
                            **гипоаллергенные экстракты растений и ароматизаторы.
                            Легкая невесомая увлажняющая маска с эффектом anti-frizz облегчает расчесывание волос, делая их более мягкими и блестящими. Входящие в состав эссенция лаванды и сыворотка винограда способствуют формированию идеальных волн и завитков, не утяжеляя и не перегружая волосы.

                            Способ применения: после использования шампуня PRECIOUS NATURE SHAMPOO FOR CURLY&WAVY HAIR, распределить маску по волосам и оставить для воздействия на 3‐5 минут. Промыть волосы водой. Для большего кондиционирующего эффекта и контроля объема: нанести небольшое
                            количество маски на влажные волосы и не смывать.

                            100% натуральный ингредиент. НЕ СОДЕРЖИТ: сульфатов, парабенов, парафинов, минеральных масел, синтетических веществ, аллергенов**
                            **гипоаллергенные экстракты растений и ароматизаторы.
                        </div>
                        <div class="more-info" data-opened="Все характеристики" data-closed="Скрыть характеристики">Все характеристики </div>

                    </div>

                </div>
                <div class="productPage-similar_Prods">
                    <div class="container-products" id="similar-products">
                        <div class="block-title">Похожие товары</div>
                        <div class="products-slider" v-cloak>
                            <div class="product">

                                <div class="img" style="background-image: url(https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg)">
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
                                    <div class="stickers">
                                        <span class="sticker sale">Скидка</span>
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
                                    <div class="stickers">
                                        <span class="sticker exclusive">Хит продаж</span>
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

        </div>

    </div>


@stop
