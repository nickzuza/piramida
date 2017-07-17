@extends('layouts')
@section('meta')
    <?php
    $lang = Lang::getLocale();
    $meta_name= 'meta_name_'.$lang;
    $meta_description = 'meta_description_'.$lang;
    ?>
    <title>{{$settings->name_project}}</title>
    <meta name=“robots” content=“noindex,nofollow”>
    <meta name="googlebot" content="noindex">
@stop
@section('content')
    <?php
    $name = 'name_'.$lang;
    $address = 'address_'.$lang;
    $grafic = 'grafic_'.$lang;
    $description = 'description_'.$lang;
    ?>
    <main>
        <h1 class="deco-h1">@lang('v.reset_pass')</h1>
        <div class="reset">
            {{Form::open(['method'=>'POST','id'=>'resetUserPas'])}}
            <div class="input-wrapper">
                <span>@lang('v.new_pass')</span>
                <input type="password" class="base-input" name="resetUserNewPas" id="resetUserNewPas">
                <div class="input-error">@lang('v.error_pass_new')</div>
            </div>
            <div class="input-wrapper">
                <span>@lang('v.confirm_new_pass')</span>
                <input type="password" class="base-input" name="resetUserPasRepeat">
                <div class="input-error">@lang('v.error_pass_confirm')</div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div>
                <button class="btn-base" type="submit">@lang('v.change')</button>
            </div>
            {{Form::close()}}
        </div>
    </main>
@stop