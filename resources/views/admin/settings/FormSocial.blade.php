@extends('admin.layouts')
@section('content')
    <style>
        label.control-label
        {
            text-align: right;
            font-weight: 400;
            margin-top: 7px;
        }

    </style>
            <div class="box box-primary">
                <div class="box-body">

                    <div class="page-header">
                        @if(isset($social))
                            @lang('admin.edit_social')
                        @else
                            @lang('admin.add_social')
                        @endif
                    </div>
                    <div class="page-body">
                        {!! Form::open(['files'=>true]) !!}

                        @if(isset($social))
                            <input type="hidden" name="id" value="{{$social->id}}">
                        @endif

                        <div class="form-group row">
                            <?php
                            $data = isset($social) ? $social->image : '';
                            $data = old('image', $data);
                            ?>
                            <label for="{{'image'}}" class="col-sm-2 control-label"><span
                                        class="red">*</span>{!! trans('admin.image') !!}</label>
                            <div class="col-sm-10" @if($errors->has('image')) id="has_errors" @endif>
                                @if(isset($social) && !empty($social->image))
                                    <div class="image_admin" style="margin-bottom:10px ">
                                        @if (file_exists('images/social/'.$social->image))
                                            <img src="{{asset('images/social')."/".$social->image}}" alt="">
                                        @else
                                            <img src="{{asset('adminLTE/images/no-image.png')}}" alt="">
                                        @endif
                                    </div>
                                @elseif(isset($social))
                                    <div class="image_admin">
                                        <img src="{{asset('adminLTE/images/no-image.png')}}" alt="">
                                    </div>
                                @endif

                                <input type="file" name="{!! 'image'!!}" class="form-control"/>
                                <span class="errors">{!!  $errors->first('image') !!}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <?php
                            $data = isset($social) ? $social->url : '';
                            $data = old('url', $data);
                            ?>
                            <label for="'url'" class="col-sm-2 control-label">{!! trans('admin.url') !!}</label>
                            <div class="col-sm-10" @if($errors->has('url')) id="has_errors" @endif>
                                <input type="text" value="{{$data}}" name="url" class="form-control"/>
                                <span class="errors">{!!  $errors->first('url') !!}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <?php
                            $data = isset($social) ? $social->sort_order : '';
                            $data = old('sort_order', $data);
                            ?>
                            <label for="sort_order" class="col-sm-2 control-label">{!! trans('admin.sort_order') !!}</label>
                            <div class="col-sm-10" @if($errors->has('sort_order')) id="has_errors" @endif>
                                <input type="number" value="{{$data}}" name="sort_order" class="form-control"/>
                                <span class="errors">{!!  $errors->first('sort_order') !!}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <?php
                            $data = isset($social) ? $social->status : '';
                            $data = old('status', $data);
                            ?>
                            <label for="status" class="col-sm-2 control-label">{!! trans('admin.status') !!}</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control">
                                    <option value="1"
                                            @if(isset($social) && $social->status == 1) selcted @endif>@lang('admin.enable')</option>
                                    <option value="0"
                                            @if(isset($social) && $social->status == 0) selected @endif>@lang('admin.disable')</option>
                                </select>
                            </div>
                        </div>

                        <input type="submit" value="{!! trans('admin.save') !!}" class="btn btn-primary btn-save">
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
@stop