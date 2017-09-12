@extends('layout')
@section('meta')

@stop
@section('content')
    <script>
        var cartArray = [
            {
                name:'Жидкое мыло с ароматом цитрусовых фруктов 500мл',
                link:'#testUrl',
                img:'http://irecommend.ru/sites/default/files/product-images/15067/1nega.jpg',
                id:'testId',
                num:1,
                weight:300,
                price:{
                    new:300.50
                },
                sale:false,
            },
            {
                name:'Deox универсальный гель для стирки с марсельским мылом 1650мл',
                link:'#testUrl2',
                img:'http://artsana.md/images/catalog/products/354_386/pEwqwIJY.png',
                id:'testId2',
                num:1,
                weight:100,
                price:{
                    new:1000,

                },
                sale:true,
            },
            {
                name:'Deox универсальный гель для стирки с марсельским мылом 1650мл',
                link:'#testUrl2',
                img:'https://i.simpalsmedia.com/marketplace/products/original/61bf3f7f51658a18d42fd16e9dbf456e.jpg',
                id:'testId2',
                num:1,
                weight:100,
                price:{
                    new:1000,
                },
                sale:true,
            }
        ];
        var cartVip = false;
        var loggedIn = false;
        var cartVipPercent = 10;
        var cities = [
            {id:'someId',name:'chisinau',summ:1000,cost:50},
            {id:'anotherId',name:'soroca',summ:5000,cost:500}
        ];
        var weightCost =[
            {weight:1000,summ:0},
            {weight:5000,summ:600},
            {weight:10000,summ:1000},
            {weight:99999999999,summ:2500}
        ];
    </script>

    <div id="cartPage" class="cart">

        <div class="page-content">
            <div class="container">
                <div class="breadcrumbs" :class="{hide: step >1}">
                    <div class="breadcrumb"><a href="">Главная</a></div>
                    <div class="breadcrumb"><span>Корзина</span></div>
                </div>

                    <div class="cart-wrapper" v-if="step <3">
                        <div class="cart-left" >
                            <transition name="fade">
                                <section class="left-container" v-cloak v-if="step === 1">
                                    <div class="h1-title"><h1>Корзина</h1></div>
                                    <div class="titles" v-if="total > 0">
                                        <span class="prod">Товар</span>
                                        <span class="price">Цена за ед.</span>
                                        <span class="quant">Кол-во</span>
                                        <span class="sum">Сумма</span>
                                    </div>
                                    <div class="products-wrapper">
                                        <product-item
                                                v-for="(item , index) in products"
                                                key="'prod'+index"
                                                v-on:close="remove"
                                                :arr-pos="index"
                                                :product="item"
                                                :wordend="wordend"
                                                :lang="info.language"
                                                v-on:get-total="totalSum"
                                        >
                                        </product-item>
                                    </div>
                                </section>
                            </transition>
                            <transition name="fade">
                                <section class="left-container"  v-cloak v-if="step === 2">
                                    <div class="h1-title"><h1>оформление заказа</h1></div>
                                    <form action="" method="POST" >
                                        <div class="form-top">
                                            <div class="butt-pannel">
                                                <button :class="{active : tab===1}" v-on:click="tab = 1" type="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" width="33" xml:space="preserve" height="27">
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <path d="M458.671,214.24v-11.571c0-17.645-14.354-32-32-32H320v-53.337c0-5.891-4.775-10.667-10.667-10.667h-32.001V74.67     c0-5.891-4.776-10.667-10.667-10.667H121.759L103.545,45.79c-4.164-4.165-10.918-4.165-15.084,0l-60.878,60.875H10.667     C4.776,106.666,0,111.441,0,117.332v298.668c0,5.89,4.776,10.667,10.667,10.667h43.739c1.605,7.878,4.954,15.129,9.622,21.333     H42.666C36.775,448,32,452.777,32,458.667s4.775,10.667,10.667,10.667h63.997c0.027,0,0.052-0.004,0.079-0.004     c25.72-0.037,47.231-18.373,52.181-42.662h150.409h43.747c1.605,7.878,4.955,15.129,9.623,21.333H341.34     c-5.89,0-10.667,4.776-10.667,10.667s4.776,10.667,10.667,10.667h63.997c0.027,0,0.053-0.004,0.08-0.004     c25.72-0.037,47.231-18.373,52.181-42.662h43.735c5.891,0,10.667-4.776,10.667-10.667v-96.001v-42.669     C512,245.679,488.896,219.336,458.671,214.24z M255.999,85.337v21.329h-91.576l-21.33-21.329H255.999z M96.003,68.417     l13.788,13.787c0.005,0.005,0.011,0.011,0.016,0.016l24.446,24.446H57.754L96.003,68.417z M106.666,447.998     c-17.646,0-32.001-14.354-32.001-31.998c0-17.646,14.355-32.002,32.001-32.002c17.644,0,31.998,14.356,31.998,32.002     C138.663,433.644,124.309,447.998,106.666,447.998z M298.666,181.336v181.332h-72.543c-5.891,0-10.667,4.776-10.667,10.667     s4.775,10.667,10.667,10.667h72.543v21.333H158.924c-4.955-24.316-26.503-42.668-52.258-42.668     c-25.755,0-47.306,18.353-52.261,42.668H21.333V234.668h42.665c5.89,0,10.667-4.775,10.667-10.667     c0-5.891-4.776-10.667-10.667-10.667H21.333v-21.332H149.33c5.891,0,10.667-4.775,10.667-10.667     c0-5.891-4.775-10.667-10.667-10.667H21.333v-42.671h10.66c0.006,0,0.012,0,0.017,0h266.656V181.336z M353.08,405.334H320     v-21.333h42.701C358.032,390.206,354.684,397.456,353.08,405.334z M437.337,416.035c-0.019,17.629-14.366,31.963-31.998,31.963     c-17.645,0-32.001-14.354-32.001-31.998c0-17.619,14.311-31.955,31.919-32h0.08c0.01,0,0.019-0.001,0.028-0.001     c17.621,0.014,31.953,14.346,31.972,31.967c0,0.012-0.001,0.022-0.001,0.034C437.336,416.012,437.337,416.023,437.337,416.035z      M490.667,405.334h-33.069c-4.956-24.316-26.504-42.668-52.259-42.668c-0.028,0-0.055,0.002-0.082,0.002h-85.258V192.003h106.672     c5.882,0,10.667,4.785,10.667,10.667v10.666h-74.666c-5.89,0-10.667,4.775-10.667,10.667v95.998     c0,5.891,4.776,10.667,10.667,10.667h127.995V405.334z M394.673,234.668v74.665h-21.334v-74.665H394.673z M490.667,309.333     h-74.661v-74.665h31.999c23.524,0,42.662,19.138,42.662,42.663V309.333z"/>
                                                                <path d="M184.397,384.001h6.658c5.89,0,10.667-4.776,10.667-10.667s-4.776-10.667-10.667-10.667h-6.658     c-5.891,0-10.667,4.776-10.667,10.667S178.507,384.001,184.397,384.001z"/>
                                                                <path d="M184.397,192.003h6.658c5.89,0,10.667-4.775,10.667-10.667c0-5.891-4.776-10.667-10.667-10.667h-6.658     c-5.891,0-10.667,4.775-10.667,10.667C173.731,187.227,178.507,192.003,184.397,192.003z"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                                    <span>Курьером</span>
                                                </button>
                                                <button :class="{active : tab===2}" v-on:click="tab = 2" type="button">

                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="27px" height="27px" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                    <g>
                                                        <g>
                                                            <path d="M276.422,252.582H137.047c-5.633,0-10.199,4.567-10.199,10.199v139.376c0,5.632,4.566,10.199,10.199,10.199h139.376    c5.632,0,10.199-4.567,10.199-10.199V262.781C286.621,257.149,282.055,252.582,276.422,252.582z M266.223,272.982v39.079    l-39.079-39.079H266.223z M147.246,391.958v-39.355l39.355,39.355H147.246z M266.224,391.958h-50.775v0.001l-68.203-68.204    v-36.351l63.806,63.806c1.992,1.991,4.602,2.987,7.212,2.987s5.221-0.996,7.212-2.987c3.983-3.983,3.984-10.441,0-14.425    l-63.805-63.806h36.624l67.929,67.929V391.958z"/>
                                                        </g>
                                                    </g>
                                                        <g>
                                                            <g>
                                                                <path d="M251.779,363.09l-2.846-2.845c-3.983-3.984-10.441-3.983-14.424,0.001c-3.983,3.983-3.982,10.441,0.001,14.424    l2.846,2.845c1.992,1.992,4.601,2.987,7.211,2.987s5.221-0.996,7.213-2.988C255.762,373.531,255.761,367.072,251.779,363.09z"/>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M442.788,169.331h-91.292c-5.632,0-10.199,4.567-10.199,10.199v223.605c0,5.632,4.567,10.199,10.199,10.199h91.292    c5.632,0,10.199-4.567,10.199-10.199V179.53C452.987,173.898,448.42,169.331,442.788,169.331z M361.694,189.73h28.92    l41.974,41.974v33.326l-70.582-70.582c-0.1-0.1-0.208-0.187-0.312-0.281V189.73z M361.695,392.938v-40.334l40.333,40.334H361.695z     M432.589,392.938h-1.712l-69.181-69.182v-36.351l70.894,70.894V392.938z M432.589,329.45l-70.582-70.582    c-0.1-0.1-0.208-0.187-0.312-0.281v-35.601l70.894,70.894V329.45z M432.589,202.856l-13.125-13.125h13.125V202.856z"/>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M276.422,39.049H137.047c-5.633,0-10.199,4.567-10.199,10.199v139.376c0,5.632,4.566,10.199,10.199,10.199h139.376    c5.632,0,10.199-4.567,10.199-10.199V49.248C286.621,43.616,282.055,39.049,276.422,39.049z M266.223,59.448v39.08l-39.08-39.08    H266.223z M147.246,178.426v-39.355l39.355,39.355H147.246z M215.448,178.425l-68.202-68.202V73.872l104.553,104.553H215.448z     M266.224,164.001L161.67,59.447h36.624l67.93,67.93V164.001z"/>
                                                            </g>
                                                        </g>
                                                        <g>
                                                            <g>
                                                                <path d="M501.801,429.232h-11.93V143.506c0-5.632-4.567-10.199-10.199-10.199H324.07V11.975c0-5.632-4.567-10.199-10.199-10.199    H99.773c-5.633,0-10.199,4.567-10.199,10.199v417.258h-9.635V134.88c0-24.218-19.703-43.921-43.921-43.921H14.941    c-5.633,0-10.199,4.567-10.199,10.199s4.566,10.199,10.199,10.199h21.077c12.97,0,23.522,10.553,23.522,23.522v282.865    c-3.971-1.091-8.145-1.686-12.457-1.686C21.12,416.06,0,437.182,0,463.143c0,25.961,21.12,47.082,47.083,47.082    c25.961,0,47.083-21.121,47.083-47.082c0-4.696-0.7-9.229-1.986-13.512h323.306c-3.523,5.978-5.553,12.936-5.553,20.362    c0,22.184,18.049,40.232,40.233,40.232c22.184,0,40.233-18.047,40.233-40.232c0-7.426-2.031-14.384-5.553-20.362h16.957    c5.632,0,10.199-4.567,10.199-10.199C512,433.8,507.433,429.232,501.801,429.232z M47.083,489.826    c-14.713,0-26.684-11.971-26.684-26.683c0-14.714,11.971-26.684,26.684-26.684s26.684,11.97,26.684,26.684    C73.767,477.855,61.796,489.826,47.083,489.826z M303.672,429.232h-193.7v-193.33h193.7V429.232z M303.672,143.506v71.998h-193.7    V22.174h193.7V143.506z M324.07,429.232V153.705h145.402v275.527H324.07z M450.164,489.826c-10.938,0-19.834-8.898-19.834-19.833    c0-10.938,8.898-19.834,19.834-19.834s19.834,8.898,19.834,19.834C469.999,480.928,461.102,489.826,450.164,489.826z"/>
                                                            </g>
                                                        </g>
                                                </svg>
                                                    <span>Самовывоз </span>
                                                </button>
                                            </div>
                                            <div class="form-courier" key="courier" v-if="tab === 1">
                                                <div class="form-title">Получатель и адрес доставки</div>
                                                <div class="input-wrapper">
                                                    <label for="">E-mail</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_courier_email')}">
                                                        <input type="text"
                                                               v-validate="'required|email'"
                                                               name="form_courier_email"
                                                               v-model.lazy="form.courier.email"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_courier_email');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_courier_email')">error</span>
                                                    </div>

                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Ф.И.О</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_courier_name')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:30'"
                                                               name="form_courier_name"
                                                               v-model.lazy="form.courier.name"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_courier_name');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_courier_name')">error</span>
                                                    </div>

                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Телефон</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_courier_phone')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:30'"
                                                               name="form_courier_phone"
                                                               v-model.lazy="form.courier.phone"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_courier_phone');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_courier_phone')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Ваш Город</label>
                                                    <div class="v-input"  >
                                                        <multiselect v-model="form.courier.city"
                                                                     :options="city"
                                                                     track-by="name"
                                                                     label="name"
                                                                     :searchable="false"
                                                                     :close-on-select="true"
                                                                     :hide-selected="true"
                                                                     :show-labels="false"
                                                                     placeholder="Выберите город"
                                                                     v-on:select="deliveryCost"
                                                        ></multiselect>
                                                        <input type="text"
                                                               v-model="form.courier.city.id"
                                                               name="form_courier_city"
                                                               v-validate="'required'"
                                                               data-vv-validate-on="none"
                                                               hidden
                                                        >
                                                        <span class="error" v-if="errors.has('form_courier_city')">error</span>
                                                    </div>

                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Адрес</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_courier_adress')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:30'"
                                                               name="form_courier_adress"
                                                               v-model.lazy="form.courier.adress"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_courier_adress');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_courier_adress')">error</span>
                                                    </div>
                                                </div>
                                                <div class="four-inputs-wrapper">
                                                    <div class="input-wrapper">
                                                        <label for="">Дом</label>
                                                        <div class="v-input"  :class="{ error: errors.has('form_courier_house')}">
                                                            <input type="text"
                                                                   v-validate="'required|min:2|max:30'"
                                                                   name="form_courier_house"
                                                                   v-model.lazy="form.courier.house"
                                                                   data-vv-validate-on="none"
                                                                   v-on:focus="removeError('form_courier_house');"
                                                            >
                                                            <span class="error" v-if="errors.has('form_courier_house')">error</span>
                                                        </div>
                                                    </div>
                                                    <div class="input-wrapper">
                                                        <label for="">Подьезд</label>
                                                        <div class="v-input"  :class="{ error: errors.has('form_courier_door')}">
                                                            <input type="text"
                                                                   v-validate="'required|min:2|max:30'"
                                                                   name="form_courier_door"
                                                                   v-model.lazy="form.courier.door"
                                                                   data-vv-validate-on="none"
                                                                   v-on:focus="removeError('form_courier_door');"
                                                            >
                                                            <span class="error" v-if="errors.has('form_courier_door')">error</span>
                                                        </div>
                                                    </div>
                                                    <div class="input-wrapper">
                                                        <label for="">Этаж</label>
                                                        <div class="v-input"  :class="{ error: errors.has('form_courier_level')}">
                                                            <input type="text"
                                                                   v-validate="'required|min:2|max:30'"
                                                                   name="form_courier_level"
                                                                   v-model.lazy="form.courier.level"
                                                                   data-vv-validate-on="none"
                                                                   v-on:focus="removeError('form_courier_level');"
                                                            >
                                                            <span class="error" v-if="errors.has('form_courier_level')">error</span>
                                                        </div>
                                                    </div>
                                                    <div class="input-wrapper">
                                                        <label for="">Квартира</label>
                                                        <div class="v-input"  :class="{ error: errors.has('form_courier_room')}">
                                                            <input type="text"
                                                                   v-validate="'required|min:2|max:30'"
                                                                   name="form_courier_room"
                                                                   v-model.lazy="form.courier.room"
                                                                   data-vv-validate-on="none"
                                                                   v-on:focus="removeError('form_courier_room');"
                                                            >
                                                            <span class="error" v-if="errors.has('form_courier_room')">error</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Комментарий  к заказу</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_courier_comments')}">
                                                    <textarea type="text"
                                                              v-validate="'required|min:2|max:30'"
                                                              name="form_courier_comments"
                                                              v-model.lazy="form.courier.comments"
                                                              data-vv-validate-on="none"
                                                              v-on:focus="removeError('form_courier_comments');"
                                                    ></textarea>
                                                        <span class="error" v-if="errors.has('form_courier_comments')">error</span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-sam" key="sam" v-if="tab === 2">
                                                <div class="form-title">Укажите кто заберет </div>
                                                <div class="input-wrapper">
                                                    <label for="">Ваше Имя</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_sam_name')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:20'"
                                                               name="form_sam_name"
                                                               v-model.lazy="form.sam.name"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_sam_name');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_sam_name')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">E-mail</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_sam_email')}">
                                                        <input type="text"
                                                               v-validate="'required|email'"
                                                               name="form_sam_email"
                                                               v-model.lazy="form.sam.email"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_sam_email');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_sam_email')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Телефон</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_sam_phone')}">
                                                        <input type="text"
                                                               v-validate="'required|min:6|max:12'"
                                                               name="form_sam_phone"
                                                               v-model.lazy="form.sam.phone"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_sam_phone');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_sam_phone')">error</span>
                                                    </div>
                                                </div>
                                                <div class="place">
                                                    <div class="form-title">Выберите место для самовывоза товара </div>
                                                    <div class="option">
                                                        <input type="radio" name="place"  checked value="mun.Chisinau, str. Uzinelor, 10/2" id="place1">
                                                        <label for="place1">mun.Chisinau, str. Uzinelor, 10/2</label>
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="place" value="s. Mihailovca str. Ștefan Vodă" id="place2">
                                                        <label for="place2">s. Mihailovca str. Ștefan Vodă</label>
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="place" value="or. Fălești, str. Gagarin,  1" id="place3">
                                                        <label for="place3">or. Fălești, str. Gagarin,  1</label>
                                                    </div>
                                                    <div class="option">
                                                        <input type="radio" name="place" value="or. Cimișlia, str. Suverinității,  3A" id="place4">
                                                        <label for="place4">or. Cimișlia, str. Suverinității,  3A</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-bottom">
                                            <div class="butt-pannel">
                                                <button type="button" :class="{activePay:payMode === 1}" @click ="payMode=1">
                                                <span>Оплата наличными</span>

                                                </button>
                                                <button type="button" :class="{activePay:payMode === 2}" @click ="payMode=2">
                                                <span>Оплата перечислением</span>
                                                </button>
                                            </div>
                                            <div class="form-pay-trans" key="transfer" v-if="payMode ===2">
                                                <div class="input-wrapper">
                                                    <label for="">Название компании</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_trans_compName')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:20'"
                                                               name="form_trans_compName"
                                                               v-model.lazy="form.trans.compName"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_trans_compName');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_trans_compName')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Юридический адрес</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_trans_adress')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:20'"
                                                               name="form_trans_adress"
                                                               v-model.lazy="form.trans.adress"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_trans_adress');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_trans_adress')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Код банка</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_trans_bankCode')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:20'"
                                                               name="form_trans_bankCode"
                                                               v-model.lazy="form.trans.bankCode"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_trans_bankCode');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_trans_bankCode')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Фискальный код</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_trans_fiscCode')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:20'"
                                                               name="form_trans_fiscCode"
                                                               v-model.lazy="form.trans.fiscCode"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_trans_fiscCode');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_trans_fiscCode')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">IBAN</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_trans_iban')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:20'"
                                                               name="form_trans_iban"
                                                               v-model.lazy="form.trans.iban"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_trans_iban');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_trans_iban')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Код НДС</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_trans_nds')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:20'"
                                                               name="form_trans_nds"
                                                               v-model.lazy="form.trans.nds"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_trans_nds');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_trans_nds')">error</span>
                                                    </div>
                                                </div>

                                                <div class="input-wrapper">
                                                    <label for="">Номер телефона</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_trans_phone')}">
                                                        <input type="text"
                                                               v-validate="'required|min:2|max:20'"
                                                               name="form_trans_phone"
                                                               v-model.lazy="form.trans.phone"
                                                               data-vv-validate-on="none"
                                                               v-on:focus="removeError('form_trans_phone');"
                                                        >
                                                        <span class="error" v-if="errors.has('form_trans_phone')">error</span>
                                                    </div>
                                                </div>
                                                <div class="input-wrapper">
                                                    <label for="">Комментарии</label>
                                                    <div class="v-input"  :class="{ error: errors.has('form_trans_comments')}">
                                                    <textarea type="text"
                                                              v-validate="'required|min:2|max:20'"
                                                              name="form_trans_comments"
                                                              v-model.lazy="form.trans.comments"
                                                              data-vv-validate-on="none"
                                                              v-on:focus="removeError('form_trans_comments');"
                                                    ></textarea>
                                                        <span class="error" v-if="errors.has('form_trans_comments')">error</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </section>
                            </transition>
                        </div>
                        <transition name="fade">
                            <div class="cart-right" v-cloak v-if="total > 0" :class=" {top: step === 1}   ">
                                <div class="cart-count">
                                    <div class="price">
                                        <span class="cart-label">Итого</span>
                                        <span class="totalPrice"><span class="round" v-text="getRound(total)"></span><sup class="rest" v-text="getRest(total)"></sup></span>
                                        <span class="sufix" v-text="wordend(getRound(total) , sufix[info.language])"></span>
                                    </div>
                                    <transition name="fade">
                                        <div class="delivery-price" v-if="step===2">
                                            <span class="title-label">Доставка:</span>
                                            <span v-if="tab == 2">Бесплатно</span>
                                            <span v-else="tab ===1" >
                                            <span v-if="form.courier.city.summ" v-text="form.courier.city.summ > total ? form.courier.city.cost : 'Бесплатно'" ></span>
                                            <span v-if="!form.courier.city.summ">Выберите город</span></span>
                                        </div>
                                    </transition>

                                    <div class="submit" v-if="step === 1" v-on:click="nextStep">Оформить заказ</div>
                                    <div class="submit" v-if="step === 2" v-on:click="submitForm">Отправить заказ</div>
                                    <transition name="fade">
                                        <div class="cart-count_bottom" :class="{'big' : items.length>1}" v-if="step === 2">
                                            <div class="items-list" :class="{closed : items.length > 1}">

                                                <div class="item" v-for="(item,index) in items" key="'i'+index" >
                                                    <div class="img" :style="{backgroundImage : 'url('+item.img+')'}"></div>
                                                    <div class="info">
                                                        <a href="#" class="title" v-text="item.name"></a>
                                                        <div class="count-quant">
                                                            <span v-text="item.num"></span>
                                                            <span>x</span>
                                                            <span v-text="getRound(item.price.new)"></span>
                                                            <sup v-text="getRest(item.price.new)"></sup>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="more-info" id="moreItems" data-close="Скрыть" :data-open="'И еще ' + (items.length - 1) + ' товар(a)'" v-text="'И еще '+(items.length - 1) + ' товар(a)'"></div>
                                            <div class="pay-delivery">
                                                <div class="title">Выбранные способы доставки и оплаты</div>
                                                <div class="info-block">
                                                    <div class="title-label">Доставка</div>
                                                    <div class="value-label">
                                                        <span v-if="tab ===1">Курьером</span>
                                                        <span v-if="tab ===2">Самовывоз </span>
                                                        <span v-if="tab===1 && form.courier.city.name" v-text="' , '+form.courier.city.name"></span>
                                                        <span v-if="tab===1">
                                                        <span v-if="form.courier.adress" v-text="', '+form.courier.adress"></span>
                                                        <span  v-if="form.courier.house" v-text="',Дом '+form.courier.house"></span>
                                                        <span class="house" v-if="form.courier.door" v-text="form.courier.door"></span>
                                                        <span v-if="form.courier.level" v-text="',Етаж '+form.courier.level"></span>
                                                        <span v-if="form.courier.room" v-text="',кв. '+form.courier.room"></span>
                                                    </span>
                                                        <span v-if="tab === 2" v-text="form.sam.place"></span>
                                                    </div>
                                                </div>
                                                <div class="info-block">
                                                    <div class="title-label">Оплата</div>
                                                    <div class="value-label">
                                                        <span v-if="payMode === 1">наличными</span>
                                                        <span v-if="payMode === 2">перечислением</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <transition name="fade">
                                    <div class="cart-right_bottom" v-if="step === 1">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" width="30" xml:space="preserve" height="25">
                                            <g>
                                                <g>
                                                    <g>
                                                        <path d="M458.671,214.24v-11.571c0-17.645-14.354-32-32-32H320v-53.337c0-5.891-4.775-10.667-10.667-10.667h-32.001V74.67     c0-5.891-4.776-10.667-10.667-10.667H121.759L103.545,45.79c-4.164-4.165-10.918-4.165-15.084,0l-60.878,60.875H10.667     C4.776,106.666,0,111.441,0,117.332v298.668c0,5.89,4.776,10.667,10.667,10.667h43.739c1.605,7.878,4.954,15.129,9.622,21.333     H42.666C36.775,448,32,452.777,32,458.667s4.775,10.667,10.667,10.667h63.997c0.027,0,0.052-0.004,0.079-0.004     c25.72-0.037,47.231-18.373,52.181-42.662h150.409h43.747c1.605,7.878,4.955,15.129,9.623,21.333H341.34     c-5.89,0-10.667,4.776-10.667,10.667s4.776,10.667,10.667,10.667h63.997c0.027,0,0.053-0.004,0.08-0.004     c25.72-0.037,47.231-18.373,52.181-42.662h43.735c5.891,0,10.667-4.776,10.667-10.667v-96.001v-42.669     C512,245.679,488.896,219.336,458.671,214.24z M255.999,85.337v21.329h-91.576l-21.33-21.329H255.999z M96.003,68.417     l13.788,13.787c0.005,0.005,0.011,0.011,0.016,0.016l24.446,24.446H57.754L96.003,68.417z M106.666,447.998     c-17.646,0-32.001-14.354-32.001-31.998c0-17.646,14.355-32.002,32.001-32.002c17.644,0,31.998,14.356,31.998,32.002     C138.663,433.644,124.309,447.998,106.666,447.998z M298.666,181.336v181.332h-72.543c-5.891,0-10.667,4.776-10.667,10.667     s4.775,10.667,10.667,10.667h72.543v21.333H158.924c-4.955-24.316-26.503-42.668-52.258-42.668     c-25.755,0-47.306,18.353-52.261,42.668H21.333V234.668h42.665c5.89,0,10.667-4.775,10.667-10.667     c0-5.891-4.776-10.667-10.667-10.667H21.333v-21.332H149.33c5.891,0,10.667-4.775,10.667-10.667     c0-5.891-4.775-10.667-10.667-10.667H21.333v-42.671h10.66c0.006,0,0.012,0,0.017,0h266.656V181.336z M353.08,405.334H320     v-21.333h42.701C358.032,390.206,354.684,397.456,353.08,405.334z M437.337,416.035c-0.019,17.629-14.366,31.963-31.998,31.963     c-17.645,0-32.001-14.354-32.001-31.998c0-17.619,14.311-31.955,31.919-32h0.08c0.01,0,0.019-0.001,0.028-0.001     c17.621,0.014,31.953,14.346,31.972,31.967c0,0.012-0.001,0.022-0.001,0.034C437.336,416.012,437.337,416.023,437.337,416.035z      M490.667,405.334h-33.069c-4.956-24.316-26.504-42.668-52.259-42.668c-0.028,0-0.055,0.002-0.082,0.002h-85.258V192.003h106.672     c5.882,0,10.667,4.785,10.667,10.667v10.666h-74.666c-5.89,0-10.667,4.775-10.667,10.667v95.998     c0,5.891,4.776,10.667,10.667,10.667h127.995V405.334z M394.673,234.668v74.665h-21.334v-74.665H394.673z M490.667,309.333     h-74.661v-74.665h31.999c23.524,0,42.662,19.138,42.662,42.663V309.333z"/>
                                                        <path d="M184.397,384.001h6.658c5.89,0,10.667-4.776,10.667-10.667s-4.776-10.667-10.667-10.667h-6.658     c-5.891,0-10.667,4.776-10.667,10.667S178.507,384.001,184.397,384.001z"/>
                                                        <path d="M184.397,192.003h6.658c5.89,0,10.667-4.775,10.667-10.667c0-5.891-4.776-10.667-10.667-10.667h-6.658     c-5.891,0-10.667,4.775-10.667,10.667C173.731,187.227,178.507,192.003,184.397,192.003z"/>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <div class="text">
                                            <div class="title">Условия доставки</div>
                                            <div class="info">
                                                Стоимость доставки заказов до 40 000 руб. в пределах Кишинева и населенные пункты на расстоянии до 20 км от города составляет 300 лей.; в населенные пункты на расстоянии до 50 км  – 1100 лей.
                                                За исключением крупногабаритных товаров, стоимость доставки которых в пределах Кишинева и населенные пункты на расстоянии до 20 км от Кишинева составляет 1000 лей.
                                            </div>
                                        </div>
                                    </div>
                                </transition>

                            </div>
                        </transition>
                    </div>

                    <transition name="fade" v-cloak>
                        <div class="cart-wrapper" v-if="step === 3"  >
                            <div class="approved">
                                <div class="checked">
                                    <div class="check"></div>
                                </div>
                                <div class="approved-title">Ваш заказ оформлен</div>
                                <p>Благодарим Вас  за оформление заказа!<br>
                                    Номер Вашего заказа: <b>6586</b></p>
                                <p>Скоро с Вами свяжется отдел доставки для подтверждения заказа.<br>
                                    Полная информация о состоянии Вашего заказа отправлена на Ваш электронный адрес.</p>
                                <a href="#" class="main-butt">Продолжить покупки</a>
                            </div>

                        </div>
                    </transition>





            </div>
        </div>
    </div>

@stop