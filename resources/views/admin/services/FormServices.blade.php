@extends('admin.layouts')
@section('content')
    <?php
    $name = "name_".Lang::Locale();
    ?>

    <div class="box box-primary">
        <div class="box-body">

            <div class="page-header">
                @if(isset($section))
                    @lang('admin.edit_services')
                @else
                    @lang('admin.add_services')
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
                                $meta_description = 'meta_description_'.$lang;
                                $meta_name = 'meta_name_'.$lang;
                                $description = 'description_'.$lang;

                                ?>
                                <div class="tab-pane @if(!$inc) active @endif" id="tab_{{$lang}}">
                                    <div class="form-group row required">
                                        <label class="col-sm-2 control-label"><span class="red">*</span>{!! trans('admin.name_services') !!}</label>
                                        <div class="col-sm-10"  @if($errors->has($name_pr)) id="has_errors" @endif>
                                            <?php
                                            $data = isset( $section )? $section->$name_pr:'';
                                            $data = old($name_pr,$data);
                                            ?>
                                            <input type="text" placeholder="{!! trans('admin.services') !!}" name="{{$name_pr}}"  value="{{$data}}" class="form-control" >
                                            <span class="errors">{!!  $errors->first($name_pr) !!}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row required">
                                        <label class="col-sm-2 control-label"><span class="red">*</span>{!! trans('admin.meta_title') !!}</label>
                                        <div class="col-sm-10"  @if($errors->has($meta_name)) id="has_errors" @endif>
                                            <?php
                                            $data = isset( $section )? $section->$meta_name:'';
                                            $data = old($meta_name,$data);
                                            ?>
                                            <input type="text" placeholder="{!! trans('admin.meta_title') !!}" name="{{$meta_name}}"  value="{{$data}}" class="form-control" >
                                            <span class="errors">{!!  $errors->first($meta_name) !!}</span>
                                        </div>
                                    </div>

                                    <div class="form-group row required">
                                        <label class="col-sm-2 control-label">{!! trans('admin.meta_description') !!}</label>
                                        <div class="col-sm-10"  @if($errors->has($meta_description)) id="has_errors" @endif>
                                            <?php
                                                $data = isset( $section )? $section->$meta_description:'';
                                                $data = old($meta_description,$data);
                                            ?>
                                            <input type="text" placeholder="{!! trans('admin.meta_description') !!}" name="{{$meta_description}}"  value="{{$data}}" class="form-control" >
                                            <span class="errors">{!!  $errors->first($meta_description) !!}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row required">
                                        <label class="col-sm-2 control-label">{!! trans('admin.description') !!}</label>
                                        <div class="col-sm-10"  @if($errors->has($description)) id="has_errors" @endif>
                                            <?php
                                                $data = isset( $section )? $section->$description:'';
                                                $data = old($description,$data);
                                            ?>
                                                <textarea name="{{$description}}" class="form-control">{{$data}}</textarea>
                                            <span class="errors">{!!  $errors->first($description) !!}</span>
                                        </div>
                                    </div>
                                </div>
                                <?php $inc++ ?>
                            @endforeach
                                <?php
                                $sect = App\Models\ServiceCategory::get();
                                ?>
                                @if(count($sect))
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label">{!! trans('admin.service_category') !!}</label>
                                        <div class="col-sm-10">
                                            <?php
                                                $data = isset($active)? $active: [''];
                                                $data = old('section',$data)
                                            ?>

                                            <select name="section[]" class="form-control select2" multiple>
                                                @foreach($sect as $item)
                                                    <option @if(in_array($item->id,$data)) selected @endif value="{{$item->id}}">{{$item->$name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

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
@section('script')
    <script>
        CKEDITOR.replace('description_ru', {height: 200});
        CKEDITOR.replace('description_ro', {height: 200});
    </script>
    <script src="{!! asset('adminLTE/plugins/select2/select2.min.js') !!}"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@stop



