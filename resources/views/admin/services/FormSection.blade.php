@extends('admin.layouts')
@section('content')
    <?php
    $name = "name_".Lang::Locale();
    ?>

    <div class="box box-primary">
        <div class="box-body">

            <div class="page-header">
                @if(isset($section))
                    @lang('admin.edit_section')
                @else
                    @lang('admin.add_section')
                @endif
            </div>

            <div class="errors">
                @if(isset($errors) && count($errors->all()) > 0)
                    <div class="alert alert-danger fade in alert-error" id="alert-message">
                        <a class="close" href="#" data-dismiss="alert">x</a>
                        <ul style="list-style-type: none">
                            <li>@lang('error.required')</li>
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success fade in " id="alert-message" style="font-size: 14px;">
                        <a class="close" href="#" data-dismiss="alert">x</a>
                        <i class="fa fa-check-circle"></i>
                        {!! session('success') !!}
                        {!! Session::forget('success') !!}
                    </div>
                @endif
            </div>

            <div class="box-body pad table-responsive about_class">
                {!! Form::open(['method'=>'POST','name'=>'Form-addCategory','files'=>true]) !!}
               <div class="tab-content">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <?php $inc = 0 ?>
                                @foreach($lang_data as $lang)
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
                                @foreach($lang_data as $lang)
                                    <?php
                                    $name_pr = 'name_'.$lang;

                                    ?>
                                    <div class="tab-pane @if(!$inc) active @endif" id="tab_{{$lang}}">
                                        <div class="form-group row required">
                                            <label class="col-sm-2 control-label"><span class="red">*</span>{!! trans('admin.name_section') !!}</label>
                                            <div class="col-sm-10"  @if($errors->has($name_pr)) id="has_errors" @endif>
                                                <?php
                                                $data = isset( $section )? $section->$name_pr:'';
                                                $data = old($name_pr,$data);
                                                ?>
                                                <input type="text" placeholder="{!! trans('admin.name_section') !!}" name="{{$name_pr}}"  value="{{$data}}" class="form-control" >
                                                <span class="errors">{!!  $errors->first($name_pr) !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $inc++ ?>
                                @endforeach

                                    <div class="form-group row required">
                                        <label class="col-sm-2 control-label">{!! trans('admin.image') !!}</label>
                                        <div class="col-sm-10"  @if($errors->has('image')) id="has_errors" @endif>
                                            <input type="file" name="image" class="form-control">
                                            @if(isset($section) && !empty($section->image))
                                                <div class="image_admin" style="margin-bottom:10px ">
                                                        <img src="{{asset('images/section')."/".$section->image}}" alt="">
                                                </div>
                                            @endif

                                            <span class="errors">{!!  $errors->first('image') !!}</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">{!! trans('admin.show_home') !!}</label>
                                        <div class="col-sm-10">
                                            <?php
                                            $data = isset( $section)? $section->home:'';
                                            $data = old('home',$data);
                                            ?>
                                            <input type="checkbox" @if($data) checked @endif value="1" name="home" @if((!isset($section)&& $total>=$limit)|| (isset($section) && $total>=$limit && $section->home != 1)) disabled @endif>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">{!! trans('admin.sort_order') !!}</label>
                                        <div class="col-sm-10">
                                            <?php
                                            $data = isset( $section)? $section->sort_order:'';
                                            $data = old('sort_order',$data);
                                            ?>
                                            <input type="number" value="{{$data}}" name="sort_order" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">{!! trans('admin.status') !!}</label>
                                        <div class="col-sm-10">
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" @if(isset($section->status) && $section->status == 1) selected @endif >@lang('admin.enable')</option>
                                                <option value="0" @if(isset($section->status) && $section->status == 0) selected @endif >@lang('admin.disable')</option>
                                            </select>
                                        </div>
                                    </div>

                                <input id="next" type="submit" value="{!! trans('admin.save') !!}" class="btn btn-primary btn-save" >
                            </div>
                        </div>
                    </div>{{--General--}}

                    <input type="hidden" name="_Token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="@if(isset($section->id )){!!$section->id  !!}@endif">
                    <div class="clear" style="clear: both;"></div>
                </div>{{--tab-content--}}
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@stop
<style>
    .image_admin img{
        margin-top:10px;

    }
    .image_admin{
        margin-bottom: 0px !important;
    }
</style>



