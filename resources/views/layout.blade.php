<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Exo+2:400,500,700|Exo:400,700&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=cyrillic" rel="stylesheet">
    {{--<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    @yield('meta')
</head>
<body>

<div class="content">


    <header id="header" class="header">
        <transition name="fade">
            <div class="preloader" v-if="loader" v-cloak>
                <div class="el-loading-mask is-fullscreen" style="">
                    <div class="el-loading-spinner">
                        <svg viewBox="25 25 50 50" class="circular">
                            <circle cx="50" cy="50" r="20" fill="none" class="path"></circle>
                        </svg>
                    </div>
                </div>
            </div>
        </transition>
        <modal v-if="modal.log" v-on:close="modal.log = false" v-cloak class="modal-base registration mobilemenu">
            <section v-if="modal.auth === 1 || modal.auth === 2">
                <div class="header-log_title">
                    <button v-on:click="modal.auth = 1"
                            :class="{active:modal.auth === 1}"
                    >Войти</button>
                    <button v-on:click="modal.auth = 2"
                            :class="{active:modal.auth === 2}"
                    >Зарегистрироваться</button>
                </div>
            </section>
            <section key="auth" v-if="modal.auth === 1">
                <section class="header-log_enter">
                    <div class="header-mob">enter</div>
                    <div class="input-wrapper">
                        <label>Ваш E-mail:</label>
                        <input type="text"
                               v-validate="'required|email'"
                               v-model="user.enter.email"
                               name="user_enter_email"
                               data-vv-validate-on="none"
                               v-on:focus="removeError('user_enter_email')"
                               v-on:change="user.enter.error = false"
                        >
                        <span :class="{error: errors.has('user_enter_email')}"
                              v-if="errors.has('user_enter_email')"
                        >@lang('l.email_valid')</span>
                        <span class="error" v-if="user.enter.error">@lang('l.user_not_exist')</span>
                    </div>
                    <div class="input-wrapper">
                        <label>Пароль:</label>
                        <input type="password"
                               v-validate="'required|min:3|max:20'"
                               v-model="user.enter.pas"
                               name="user_enter_pas"
                               data-vv-validate-on="none"
                               v-on:focus="removeError('user_enter_pas')"
                        >
                        <span :class="{error: errors.has('user_enter_pas')}"
                              v-if="errors.has('user_enter_pas')"
                        >@lang('l.password_valid')</span>
                    </div>
                    <div class="btn-wrapper">
                        <button v-on:click="validate">Войти</button>
                        <span v-on:click="modal.auth = 3">Забыли пароль?</span>
                    </div>
                </section>

            </section>
            <section key="reg" v-if="modal.auth === 2">
                <section class="header-log_reg">
                    <div class="header-mob">registration</div>
                    <div class="input-wrapper">
                        <label>Ваш E-mail:</label>
                        <input type="text"
                               maxlength="255"
                               v-validate="'required|email'"
                               v-model="user.reg.email"
                               name="user_reg_email"
                               key="user-reg-email"
                               data-vv-validate-on="none"
                               v-on:focus="removeError('user_reg_email');user.req.error = false"
                        >
                        <span :class="{error: errors.has('user_reg_email')}"
                              v-if="errors.has('user_reg_email')"
                        >@lang('l.email_valid') 1111</span>
                        <span class="error" v-if="user.req.error">@lang('l.email_exists')</span>

                    </div>
                    <div class="input-wrapper">
                        <label>Пароль:</label>
                        <input type="password"
                               v-validate="'required|min:6|max:20'"
                               minlength="6"
                               maxlength="20"
                               required
                               v-model="user.reg.pas"
                               name="user_reg_pas"
                               key="user-reg-pass"
                               data-vv-validate-on="none"
                               v-on:focus="removeError('user_reg_pas')"
                        >
                        <span :class="{error: errors.has('user_reg_pas')}"
                              v-if="errors.has('user_reg_pas')"
                        >@lang('l.password_valid')</span>
                    </div>
                    <div class="input-wrapper">
                        <label>Подтверждение пароля:</label>
                        <input type="password"
                               v-validate="'required|confirmed:user_reg_pas'"
                               required
                               minlength="6"
                               maxlength="20"
                               v-model="user.reg.pasrepeat"
                               name="reg_password_confirmation"

                               data-vv-validate-on="none"
                               v-on:focus="removeError('reg_password_confirmation')"
                        >
                        <span :class="{error: errors.has('reg_password_confirmation')}"
                              v-if="errors.has('reg_password_confirmation')"
                        >@lang('l.password_confirmation')</span>
                    </div>
                    <div class="input-wrapper">
                        <label>Ваше Имя:</label>
                        <input type="text"
                               v-validate="'required|min:2|max:50'"
                               required
                               minlength="2"
                               maxlength="50"
                               v-model="user.reg.name"
                               name="user_reg_name"

                               data-vv-validate-on="none"
                               v-on:focus="removeError('user_reg_name')"
                        >
                        <span :class="{error: errors.has('user_reg_name')}"
                              v-if="errors.has('user_reg_name')"
                        >@lang('l.name_valid')</span>
                    </div>
                    <div class="input-wrapper">
                        <label>Ваш телефон:</label>
                        <input type="text"
                               v-validate="'min:6|max:12'"
                               maxlength="12"
                               minlength="6"
                               v-model="user.reg.tel"
                               name="user_reg_tel"

                               data-vv-validate-on="none"
                               v-on:focus="removeError('user_reg_tel')"
                        >
                        <span :class="{error: errors.has('user_reg_tel')}"
                              v-if="errors.has('user_reg_tel')"
                        >@lang('l.mobile_phone_valid')</span>
                    </div>
                    <div class="btn-wrapper">
                        <button v-on:click="validate">Зарегистрироваться</button>
                    </div>
                </section>

            </section>
            <section key="fog" v-if="modal.auth === 3">

                <h2 class="header-fog_title">Востановление пароля</h2>
                <div class="editor header-fog_text">
                    После заполнения формы мы отправим специальную ссылку на указан
                </div>
                <section>
                    <div class="input-wrapper">
                        <label>Введите Ваш E-mail:</label>
                        <input type="text"
                               v-validate="'required|email'"
                               required
                               maxlength="255"
                               v-model="user.fog.email"
                               name="user_fog_email"
                               placeholder="@lang('l.email')"
                               data-vv-validate-on="none"
                               v-on:focus="removeError('user_fog_email')"
                        >
                        <span :class="{error: errors.has('user_fog_email')}"
                              v-if="errors.has('user_fog_email')"
                        >@lang('l.email_valid')</span>
                        <span class="error" v-if="user.fog.error">@lang('l.email_not_exist')</span>
                    </div>
                    <div class="btn-wrapper">
                        <button v-on:click="validate">@lang('l.send')</button>
                    </div>
                </section>
            </section>
            <section key="conf" v-if="modal.auth === 4">
                <div class="input-wrapper">
                    <label>Новый пароль:</label>
                    <input type="password"
                           v-validate="'required|min:6'"
                           required
                           maxlength="255"
                           v-model="user.conf.new"
                           name="user_conf_new"
                           placeholder="@lang('l.email')"
                           data-vv-validate-on="none"
                           v-on:focus="removeError('user_conf_new')"
                    >
                    <span :class="{error: errors.has('user_conf_new')}"
                          v-if="errors.has('user_conf_new')"
                    >@lang('l.email_valid')</span>
                    <span class="error" v-if="user.conf.error">error</span>
                </div>
                <div class="input-wrapper">
                    <label>Новый пароль: ещё раз</label>
                    <input type="password"
                           v-validate="'required|confirmed:user_conf_new'"
                           required
                           maxlength="255"
                           v-model="user.conf.confNew"
                           name="user_conf_confNew"
                           placeholder="@lang('l.email')"
                           data-vv-validate-on="none"
                           v-on:focus="removeError('user_conf_confNew')"
                    >
                    <span :class="{error: errors.has('user_conf_confNew')}"
                          v-if="errors.has('user_conf_confNew')"
                    >@lang('l.email_valid')</span>
                    <span class="error" v-if="user.conf.error">error</span>
                </div>
                <div class="btn-wrapper">
                    <button v-on:click="validate">@lang('l.send')</button>
                </div>
            </section>
            <section key="text" v-if="modal.auth === 5">
                <h2 class="header-fog_title">Good Job</h2>
                <div class="editor header-fog_text">
                    После заполнения формы мы отправим специальную ссылку на указан
                </div>
            </section>
            <section key="text" v-if="modal.auth === 6">
                <h2 class="header-fog_title">Got FeedBack</h2>
                <div class="editor header-fog_text">
                    После заполнения формы мы отправим специальную ссылку на указан
                </div>
            </section>

        </modal>
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
                    <button v-on:click="validateOneC">Отправить</button>
                </div>
            </div>
            <div v-if="modal.oneC.isSent">
                <div class="editor header-fog_text">
                    Ждите звонка
                </div>
            </div>

        </modal>
        <div class="header-wrapper">
            <div class="header-top">
                <div class="header-language">
                    <ul>
                        <li :class="{active : lang === 1} " v-on:click="lang = 1"><a >ro</a></li>
                        <li :class="{active : lang === 2  }" v-on:click="lang = 2"><a >ru</a></li>
                        <li :class="{active :lang === 3 }" v-on:click="lang = 3"><a>en</a></li>
                    </ul>
                </div>
                <div class="header-company_title">SRL"CATADENI-LUx"</div>
                <div class="header-phone"><span><b>022</b>85-40-30</span><span><b>022</b>85-40-30</span></div>
                <div class="header-top-links">
                    <ul>
                        <li><a href="">О компании</a></li>
                        <li><a href="">Наши партнеры </a></li>
                        <li><a href="">Контакт</a></li>
                    </ul>
                </div>
            </div>
            <div class="header-main">
                <a href="" class="header-logo"><img src="../../img/logo.png" alt="logo">
                <span>un partener de incredere</span>
                </a>
                <div class="header-search">
                    <ajax-search place-holder ="Поиск по сайту" ></ajax-search>
                </div>
                <div class="header-user-prods">
                    <button>
                        <a :href='favProducts >0 ? "#" : ""'>
                            <div class="icon">
                                <span class="ellipsis" v-if="favProducts >0" v-text="favProducts" v-cloak></span>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" x="0px" y="0px" viewBox="0 0 455 455" style="enable-background:new 0 0 455 455;" xml:space="preserve">
                                    <path d="M326.632,10.346c-38.733,0-74.991,17.537-99.132,46.92c-24.141-29.383-60.399-46.92-99.132-46.92  C57.586,10.346,0,67.931,0,138.714c0,55.426,33.049,119.535,98.23,190.546c50.162,54.649,104.729,96.96,120.257,108.626l9.01,6.769  l9.009-6.768c15.53-11.667,70.099-53.979,120.26-108.625C421.95,258.251,455,194.141,455,138.714  C455,67.931,397.414,10.346,326.632,10.346z"/>
                                </svg>
                            </div>
                            <span>Избранные</span>
                        </a>
                    </button>
                    <button>
                        <a :href='cartProducts >0 ? "#" : ""'>
                            <div class="icon">
                                <span class="ellipsis" v-if="cartProducts >0" v-text="cartProducts" v-cloak></span>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20px" height="22px" x="0px" y="0px" width="30.861px" height="30.861px" viewBox="0 0 30.861 30.861" style="enable-background:new 0 0 30.861 30.861;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <g>
                                                <circle cx="11.212" cy="26.398" r="2.673"/>
                                            </g>
                                            <g>
                                                <circle cx="23.823" cy="26.398" r="2.673"/>
                                            </g>
                                            <g>
                                                <path d="M8.748,8.439c-0.325,0-0.621-0.186-0.763-0.478L5.353,2.53C5.134,2.077,4.675,1.79,4.172,1.79H0.676     C0.303,1.79,0,2.092,0,2.465v0.853c0,0.373,0.303,0.675,0.676,0.675h2.502c0.173,0,0.324,0.117,0.369,0.284L7.741,20.2     c0.401,1.525,1.781,2.589,3.358,2.589h13.042c1.521,0,2.863-0.989,3.315-2.44l3.367-10.811C30.902,9.281,30.855,9,30.697,8.784     c-0.16-0.217-0.413-0.345-0.684-0.345H8.748z"/>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span>Корзина</span>
                        </a>
                    </button>

                    <div class="mob-menu-butt"></div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="catalog-butt" v-on:click="categMenu = !categMenu">
                    <span>Каталог товаров</span>
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 185.344 185.344"  xml:space="preserve" width="12px" height="9px">
                            <g>
                                <g>
                                    <path d="M92.672,144.373c-2.752,0-5.493-1.044-7.593-3.138L3.145,59.301c-4.194-4.199-4.194-10.992,0-15.18    c4.194-4.199,10.987-4.199,15.18,0l74.347,74.341l74.347-74.341c4.194-4.199,10.987-4.199,15.18,0    c4.194,4.194,4.194,10.981,0,15.18l-81.939,81.934C98.166,143.329,95.419,144.373,92.672,144.373z"/>
                                </g>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="mob-menuWrapper">
                        <div class="mob-menu-header">
                            <div class="header-language">
                                <ul>
                                    <li :class="{active : lang === 1} " v-on:click="lang = 1"><a >ro</a></li>
                                    <li :class="{active : lang === 2  }" v-on:click="lang = 2"><a >ru</a></li>
                                    <li :class="{active :lang === 3 }" v-on:click="lang = 3"><a>en</a></li>
                                </ul>
                            </div>
                            <div class="mob-men-Close">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 47.971 47.971" xml:space="preserve" width="13px" height="13px">
                                <g>
                                    <path d="M28.228,23.986L47.092,5.122c1.172-1.171,1.172-3.071,0-4.242c-1.172-1.172-3.07-1.172-4.242,0L23.986,19.744L5.121,0.88   c-1.172-1.172-3.07-1.172-4.242,0c-1.172,1.171-1.172,3.071,0,4.242l18.865,18.864L0.879,42.85c-1.172,1.171-1.172,3.071,0,4.242   C1.465,47.677,2.233,47.97,3,47.97s1.535-0.293,2.121-0.879l18.865-18.864L42.85,47.091c0.586,0.586,1.354,0.879,2.121,0.879   s1.535-0.293,2.121-0.879c1.172-1.171,1.172-3.071,0-4.242L28.228,23.986z"/>
                                </g>
                           </svg>
                            </div>
                        </div>
                        <div class="mob-phones">
                            <span><b>022</b>85-40-30</span>
                            <span><b>022</b>85-40-30</span>
                        </div>
                        <ul class="mob-top-links">
                            <li><a href="">О компании</a></li>
                            <li><a href="">Наши партнеры </a></li>
                            <li><a href="">Контакт</a></li>

                        </ul>
                        <ul class="menu-bottom">
                            <li><a href="">Доставка</a></li>
                            <li><a href="">Оплата</a></li>
                            <li><a href="">Оптовикам</a></li>
                            <li><a href="">Акций</a></li>
                        </ul>
                        <ul class="mob-userCab">
                            <li v-if="!log" v-on:click="mobModal(1)">Вход</li>
                            <li v-if="!log" v-on:click="mobModal(2)">Регистрация</li>
                            <li v-if="log">Кабинет</li>
                        </ul>
                    </div>

                </div>

                <div class="header-user_cabinet">
                    <div class="option-wrapper" v-cloak>
                        <a class="option" v-if="log=== true" href="#">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 350 350" style="enable-background:new 0 0 350 350;" xml:space="preserve" width="17" height="17">
                                    <g>
                                        <path d="M175,171.173c38.914,0,70.463-38.318,70.463-85.586C245.463,38.318,235.105,0,175,0s-70.465,38.318-70.465,85.587   C104.535,132.855,136.084,171.173,175,171.173z"/>
                                        <path d="M41.909,301.853C41.897,298.971,41.885,301.041,41.909,301.853L41.909,301.853z"/>
                                        <path d="M308.085,304.104C308.123,303.315,308.098,298.63,308.085,304.104L308.085,304.104z"/>
                                        <path d="M307.935,298.397c-1.305-82.342-12.059-105.805-94.352-120.657c0,0-11.584,14.761-38.584,14.761   s-38.586-14.761-38.586-14.761c-81.395,14.69-92.803,37.805-94.303,117.982c-0.123,6.547-0.18,6.891-0.202,6.131   c0.005,1.424,0.011,4.058,0.011,8.651c0,0,19.592,39.496,133.08,39.496c113.486,0,133.08-39.496,133.08-39.496   c0-2.951,0.002-5.003,0.005-6.399C308.062,304.575,308.018,303.664,307.935,298.397z"/>
                                    </g>
                                </svg>
                            </div>
                            <span>Nume Prenume</span>
                        </a>
                    </div>
                    <div class="option-wrapper" v-cloak>
                        <div class="option" v-if="log=== false"  v-cloak>
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 15.804 15.804"  xml:space="preserve" width="13px" height="17px">
                                <g>
                                    <path  d="M12.639,6.909V4.785C12.639,2.147,10.493,0,7.854,0S3.071,2.147,3.071,4.785v2.124H2.141v8.895   h11.521V6.909H12.639z M8.981,11.512v1.881c0,0.49-0.397,0.887-0.887,0.887c-0.491,0-0.888-0.396-0.888-0.887v-1.881   c-0.309-0.256-0.51-0.639-0.51-1.071c0-0.772,0.626-1.397,1.398-1.397S9.49,9.669,9.49,10.441   C9.491,10.874,9.29,11.256,8.981,11.512z M10.899,6.909H4.811V4.785c0-1.679,1.366-3.045,3.045-3.045   c1.678,0,3.044,1.366,3.044,3.045V6.909z"/>
                                </g>
                            </svg>
                            </div>
                            <span v-on:click="modal.log = true" >Личный кабинет</span>
                        </div>
                    </div>

                </div>
                <div class="search-mob">
                    <div class="opened">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 451 451" style="enable-background:new 0 0 451 451;" xml:space="preserve" width="18px" height="18px">
                                    <g>
                                        <path d="M447.05,428l-109.6-109.6c29.4-33.8,47.2-77.9,47.2-126.1C384.65,86.2,298.35,0,192.35,0C86.25,0,0.05,86.3,0.05,192.3   s86.3,192.3,192.3,192.3c48.2,0,92.3-17.8,126.1-47.2L428.05,447c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4   C452.25,441.8,452.25,433.2,447.05,428z M26.95,192.3c0-91.2,74.2-165.3,165.3-165.3c91.2,0,165.3,74.2,165.3,165.3   s-74.1,165.4-165.3,165.4C101.15,357.7,26.95,283.5,26.95,192.3z"/>
                                    </g>
                        </svg>
                    </div>
                    <div class="closed">

                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="17" height="17" viewBox="0 0 357 357" xml:space="preserve">
                            <g>
                                <g >
                                    <polygon points="357,35.7 321.3,0 178.5,142.8 35.7,0 0,35.7 142.8,178.5 0,321.3 35.7,357 178.5,214.2 321.3,357 357,321.3     214.2,178.5   "/>
                                </g>
                            </g>
                        </svg>

                    </div>

                </div>

            </div>
        </div>
        <transition name="fade">
            <div class="header-categories" v-if="categMenu === true" v-cloak>
                <div class="container categories-block">
                    <ul class="categories-list">
                        <li>
                            <a class="category-title deep" href="">Механические инструменты</a>
                            <div class="subcategories-list">
                                <div class="category-back">Механические инструменты</div>
                                <ul>
                                    <li class="subcategory deeper">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>

                                    </li>
                                    <li class="subcategory deeper">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>

                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory deeper">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory deeper">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li>
                            <a class="category-title deep" href="">Инструменты защиты</a>
                            <div class="subcategories-list">
                                <div class="category-back">Инструменты защиты</div>
                                <ul>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>

                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="subcategory">
                                        <a class="subcategory-title" href="">Бетонные изделия</a>
                                        <div>
                                            <ul class="subSubCategory">
                                                <li><a href="">Кирпич</a></li>
                                                <li><a href="">Блоки стеновые</a></li>
                                                <li><a href="">Трубы асбестоцементные</a></li>
                                                <li><a href=""> Колодцы</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </div>

                        </li>
                        <li><a class="category-title" href="">Замки</a></li>
                        <li><a class="category-title" href="">Инструмент автомобилистов</a></li>
                        <li><a class="category-title" href="">Строительные материалы</a></li>
                        <li><a class="category-title" href="">Вагонка</a></li>
                        <li><a class="category-title" href="">Изоляционные материалы</a></li>
                        <li><a class="category-title" href="">Абразивные материалы</a></li>
                        <li><a class="category-title" href="">ДЛЯ автомобилистов</a></li>

                    </ul>
                </div>
            </div>
        </transition>


    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer-wrapper">
            <div class="footer-top">
                <div class="column">
                    <div class="column-title">О нас</div>
                    <ul>
                        <li><a href="">Дисконтные карты   </a></li>
                        <li><a href="">Контактная информация</a></li>
                        <li><a href="">Поставщикам</a></li>
                    </ul>
                </div>
                <div class="column">
                    <div class="column-title">Покупателю</div>
                    <ul>
                        <li><a href="">Акции</a></li>
                        <li><a href="">Доставка</a></li>
                        <li><a href="">Оплата</a></li>
                        <li><a href="">Информация для потребителя</a></li>
                    </ul>
                </div>
                <div class="column">
                    <div class="column-title">Контакты</div>
                    <ul>
                        <li><a href="">Служба поддержки   </a></li>
                        <li><a href="">Сотрудничество</a></li>
                        <li><a href="">Оптовые продажи</a></li>
                    </ul>
                </div>
                <div class="column">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="21.854px" height="21.854px" viewBox="0 0 21.854 21.854" style="enable-background:new 0 0 21.854 21.854;" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M12.915,16.32c-1.3-0.685-2.755-1.715-4.21-3.168c-1.456-1.457-2.487-2.914-3.171-4.216l1.127-3.026l-3.799-5.91    L1.61,1.254l0.001,0.003C1.603,1.266,1.593,1.271,1.583,1.282c-3.158,3.157-1.457,9.621,3.957,15.035    c5.414,5.413,11.877,7.113,15.036,3.957c0.009-0.01,0.016-0.02,0.024-0.029l1.252-1.254l-5.908-3.799L12.915,16.32z"/>
                            <path d="M20.101,11.375h1.75C21.851,5.104,16.749,0,10.477,0v1.75C15.784,1.75,20.101,6.069,20.101,11.375z"/>
                            <path d="M16.601,11.375h1.75c0-4.343-3.531-7.875-7.875-7.875v1.75C13.853,5.25,16.601,7.998,16.601,11.375z"/>
                            <path d="M13.101,11.375h1.75C14.851,8.962,12.888,7,10.477,7v1.75C11.925,8.75,13.101,9.928,13.101,11.375z"/>
                        </g>
                    </g>
                </svg>
                    <ul>
                        <li class="phone"><a href="">022 85-40-30  </a></li>
                        <li class="phone"><a href="">022 85-40-30  </a></li>
                        <li class="email"><a href="">info@piramida.md</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright">
                    © 2017 Piramida.md. Все права защищены.
                </div>
                <div class="socials">
                    <a href="" class="social" style="background-size: 12px;background-image: url(../../img/fb.png)"></a>
                    <a href="" class="social" style="background-size: 20px; background-image: url(../../img/yt.png)"></a>
                    <a href="" class="social" style="background-size: 20px;background-image: url(../../img/tw.png)"></a>
                    <a href="" class="social" style="background-size: 12px;background-image: url(../../img/ok.png)"></a>
                    <a href="" class="social" style="background-size: 20px;background-image: url(../../img/insta.png)"></a>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- ========= scripts ========= -->
<script>
    window.Laravel = <?php echo json_encode([
        'auth' =>false,

        'csrfToken' => csrf_token(),
        'language' => 'ro',
        'cartNumber'=>'1',
        'cartData'=>'20434',
    ]); ?>
</script>

<script src="{{asset('js/app.js')}}"></script>
@yield('script')
<!-- ========= /scripts ========= -->
</body>
</html>


