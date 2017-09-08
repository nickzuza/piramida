@extends('layout')
@section('meta')

@stop
@section('content')
    <script>
        var locations=[
            {
                name: 'Магазин в Кишиневе',
                contacts: {
                    address:'г. Кишинев, ул. Узинелор 10/2',
                    phones:'022 85-40-30<br>022 85-40-30'.split('<br>'),
                    fax:['022 85-40-30'],
                    email:'info@piramida.md'
                },
                map:{lat: -25.363, lng: 131.044}
            },
            {
                name: 'Магазин в г. Чимишлия',
                contacts: {
                    address:'г. Кишинев, ул. Узинелор 10/2',
                    phones:['022 85-40-30'],
                },
                map:{lat: -25.363, lng: 131.044}
            },
            {
                name: 'Магазин в г. Чимишлия',
                contacts: {
                    address:'г. Кишинев, ул. Узинелор 10/2',
                    phones:['022 85-40-30'],
                },
                map:{lat: -25.363, lng: 131.044}
            },
            {
                name: 'Магазин в г. Чимишлия',
                contacts: {
                    address:'г. Кишинев, ул. Узинелор 10/2',
                    phones:['022 85-40-30'],
                },
                map:{lat: -25.363, lng: 131.044}
            }


        ]
    </script>
    <div id="contacts" class="contactsPage">
        <div class="page-content">
            <div class="container">
                <div class="breadcrumbs">
                    <div class="breadcrumb"><a href="">Главная</a></div>
                    <div class="breadcrumb"><a href="">Строительные материалы</a></div>
                    <div class="breadcrumb"><span>Строительные материалы</span></div>
                </div>
                <div class="h1-title"><h1>Строительные материалы</h1></div>
                <div class="contacts-wrapper" >

                    <section v-cloak  v-for="(item,index) in items" :class="[{mainLocation:index === 0} , {location:index > 0}]">
                        <a href="#" class="location-title" v-text="item.name"></a>
                        <div class="location-info">
                            <div class="col">
                                <span class="title-label">Адрес</span>
                                <span v-text="item.contacts.address"></span>
                            </div>
                            <div class="col">
                                <span class="title-label">Телефон</span>
                                <span class="phone" v-for="phone in item.contacts.phones" v-text="phone"></span>
                            </div>
                            <div v-if="item.contacts.fax" class="col">
                                <span class="title-label">Факс</span>
                                <span class="phone" v-for="phone in item.contacts.fax" v-text="phone"></span>
                            </div>
                            <div v-if="item.contacts.email"  class="col">
                                <span class="title-label">E-mail</span>
                                <span>info@piramida.md</span>
                            </div>
                        </div>
                        <div class="map" :id="'loc'+index "></div>
                    </section>

                    <div class="feedback-title" v-cloak>
                        Обратная связь
                    </div>

                    <form  novalidate  class="feedback" key="feedback">
                        <div class="block" v-cloak>
                            <div class="input-wrapper">
                                <label for="">Имя</label>
                                <div class="v-input"  :class="{ error: errors.has('form_feedback_uName')}">
                                    <input type="text"
                                           v-validate="'required|min:6'"
                                           name="form_feedback_uName"
                                           v-model.lazy="form.feedback.uName"
                                           data-vv-validate-on="none"
                                           v-on:focus="removeError('form_feedback_uName')"
                                    >
                                    <span class="error" v-if="errors.has('form_feedback_uName')">error</span>
                                </div>
                            </div>
                            <div class="input-wrapper">
                                <label for="">Телефон</label>
                                <div class="v-input"  :class="{ error: errors.has('form_feedback_phone')}">
                                    <input type="text"
                                           v-validate="'required'"
                                           name="form_feedback_phone"
                                           v-model.lazy="form.feedback.phone"
                                           data-vv-validate-on="none"
                                           v-on:focus="removeError('form_feedback_phone');"
                                    >
                                    <span class="error" v-if="errors.has('form_feedback_phone')">error</span>
                                </div>
                            </div>
                            <div class="input-wrapper">
                                <label for="">E-mail</label>
                                <div class="v-input"  :class="{ error: errors.has('form_feedback_email')}">
                                    <input type="text"
                                           v-validate="'required'"
                                           name="form_feedback_email"
                                           v-model.lazy="form.feedback.email"
                                           data-vv-validate-on="none"
                                           v-on:focus="removeError('form_feedback_email');"
                                    >
                                    <span class="error" v-if="errors.has('form_feedback_email')">error</span>
                                </div>

                            </div>
                        </div>
                        <div class="block" v-cloak>
                            <div class="input-wrapper big">
                                <label class="big" for="">Комментарий</label>
                                <div class="v-input"  :class="{ error: errors.has('form_feedback_comment')}">
                                    <textarea type=text"
                                              v-validate="'required'"
                                              name="form_feedback_comment"
                                              v-model.lazy="form.feedback.comment"
                                              data-vv-validate-on="none"
                                              v-on:focus="removeError('form_feedback_comment');"
                                    ></textarea>
                                    <span class="error" v-if="errors.has('form_feedback_comment')">error</span>
                                </div>

                            </div>
                            <button  class="main-butt" type="butt" @click="validate" >Отправить </button>
                        </div>
                    </form>



                </div>


            </div>
        </div>
    </div>


    <script async defer src="https://maps.googleapis.com/maps/api/js?key= AIzaSyCgCQ65uHUd-ta9V-TUPdoZ9aRKnB1jL3M&callback=initMap">

    </script>
    <script>
        function initMap() {
            setTimeout(function () {
                for(var i=0;i<window.locations.length;i++){
                    var point= new google.maps.LatLng(window.locations[i].map.lat ,  window.locations[i].map.lng);
                    var map = new google.maps.Map(document.getElementById('loc'+i), {
                        zoom: 12,
                        center:point
                    });
                    var marker = new google.maps.Marker({
                        position: point,
                        map: map,
                        icon: '../img/contacts.png'

                    })
                }
            },300);

        };
    </script>

@stop