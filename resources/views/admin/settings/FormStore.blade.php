@extends('admin.layouts')
@section('content')
    <style>
        .coordonate
        {
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
        }
    </style>
    <div class="box box-primary">
        <div class="box-body">
            <div class="page-header">
                @if(isset($store))
                    @lang('admin.edit_store')
                @else
                    @lang('admin.add_store')
                @endif
            </div>
            <div class="page-body">
                {!! Form::open(['files'=>true]) !!}
                    <?php $langs = ['ru','ro']?>
                        @if(isset($store))
                            <input type="hidden" name="id" value="{{$store->id}}">
                        @endif
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <?php $inc = 0 ?>
                            @foreach($langs as $lang)
                                    <li class="@if(! $inc ) active @endif">
                                        <a href="#tab_{!! $lang!!}" data-toggle="tab">
                                            {!! HTML::image("adminLTE/images/icon-".$lang.".png") !!}
                                        </a>
                                        <?php $inc++;?>
                                    </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            <?php $inc = 0?>
                            @foreach($langs as $lang)
                                <?php
                                    $name = 'name_'.$lang;
                                    $image = 'image_'.$lang;
                                    $address = 'address_'.$lang;
                                    $grafic = 'grafic_'.$lang;
                                ?>

                                    <div class="tab-pane @if(! $inc ) active @endif" id="tab_{!! $lang!!}">
                                        <div class="form-group row">
                                            <?php
                                                $data = isset( $store )? $store->$address:'';
                                                $data = old($address,$data);
                                            ?>
                                            <label for="{{$address}}" class="col-sm-2 control-label"><span>*</span>{!! trans('admin.address') !!}</label>
                                            <div class="col-sm-10" @if($errors->has($address)) id="has_errors" @endif>
                                                <input type="text" value="{{$data}}" name="{!! $address!!}" class="form-control" />
                                                <span class="errors">{!!  $errors->first($address) !!}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <?php
                                                $data = isset( $store )? $store->$grafic:'';
                                                $data = old($grafic,$data);
                                            ?>
                                            <label for="{{$grafic}}" class="col-sm-2 control-label"><span>*</span>{!! trans('admin.grafic') !!}</label>
                                            <div class="col-sm-10" @if($errors->has($grafic)) id="has_errors" @endif>
                                                <input type="text" value="{{$data}}" name="{!! $grafic!!}" class="form-control" />
                                                <span class="errors">{!!  $errors->first($grafic) !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $inc++;?>
                            @endforeach
                                <div class="form-group row">
                                    <?php
                                    $data = isset( $store )? $store->phone1:'';
                                    $data = old('phone1',$data);
                                    ?>
                                    <label for="sort_order" class="col-sm-2 control-label"><span>*</span>{!! trans('admin.phone') !!} (1) </label>
                                    <div class="col-sm-10" @if($errors->has('phone1')) id="has_errors" @endif>
                                        <input type="text" value="{{$data}}" id="number" name="phone1" class="form-control" />
                                        <span class="errors">{!!  $errors->first('phone1') !!}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <?php
                                    $data = isset( $store )? $store->phone2:'';
                                    $data = old('phone2',$data);
                                    ?>
                                    <label for="sort_order" class="col-sm-2 control-label">{!! trans('admin.phone') !!} (2) </label>
                                    <div class="col-sm-10" @if($errors->has('phone2')) id="has_errors" @endif>
                                        <input type="text" value="{{$data}}" id="number" name="phone2" class="form-control" />
                                        <span class="errors">{!!  $errors->first('phone2') !!}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <?php
                                    $data = isset( $store )? $store->phone3:'';
                                    $data = old('phone3',$data);
                                    ?>
                                    <label for="sort_order" class="col-sm-2 control-label">{!! trans('admin.phone') !!} (3) </label>
                                    <div class="col-sm-10" @if($errors->has('phone3')) id="has_errors" @endif>
                                        <input type="text" value="{{$data}}" id="number" name="phone3" class="form-control" />
                                        <span class="errors">{!!  $errors->first('phone3') !!}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <?php
                                    $data = isset( $store )? $store->coordonate_x:'';
                                    $data = old('coordonate_x',$data);
                                    ?>
                                    <?php
                                    $data1 = isset( $store )? $store->coordonate_y:'';
                                    $data1 = old('coordonate_y',$data1);
                                    ?>
                                    <label for="sort_order" class="col-sm-2 control-label">{!! trans('admin.coordonate') !!}</label>
                                    <div class="col-sm-10" @if($errors->has('coordonate_x')) id="has_errors" @endif>
                                        <input type="text" value="{{$data}}" class="coordonate" name="coordonate_x" /> -
                                        <input type="text" value="{{$data1}}" class="coordonate" name="coordonate_y" />
                                        <span class="errors">{!!  $errors->first('coordonate_x') !!}</span>
                                        <span class="errors">{!!  $errors->first('coordonate_y') !!}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <?php
                                    $data = isset( $store )? $store->sort_order:'';
                                    $data = old('sort_order',$data);
                                    ?>
                                    <label for="sort_order" class="col-sm-2 control-label">{!! trans('admin.sort_order') !!}</label>
                                    <div class="col-sm-10" @if($errors->has('sort_order')) id="has_errors" @endif>
                                        <input type="number" value="{{$data}}" name="sort_order" class="form-control" />
                                        <span class="errors">{!!  $errors->first('sort_order') !!}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <?php
                                    $data = isset( $store )? $store->status:'';
                                    $data = old('status',$data);
                                    ?>
                                    <label for="status" class="col-sm-2 control-label">{!! trans('admin.status') !!}</label>
                                    <div class="col-sm-10">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" @if(isset($store) && $store->status == 1) selcted @endif>@lang('admin.enable')</option>
                                            <option value="0" @if(isset($store) && $store->status == 0) selected @endif>@lang('admin.disable')</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <input type="submit" value="{!! trans('admin.save') !!}" class="btn btn-primary btn-save" >
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $("#number").keydown(function (e) {

            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [8, 9, 27, 13, 110, 190,95,45,189,32]) !== -1 ||
                // Allow: Ctrl/cmd+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+C
                (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+X
                (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    </script>
@stop