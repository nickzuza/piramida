@extends('admin.layouts')
<?php

$name_table='name_'.Lang::getLocale();
?>
@section('title')
    @if(isset($news))
        <title>{{$news->$name_table}}</title>
    @else
        <title>@lang('trans.add_news')</title>
    @endif
@stop
@section('content')
    <div class="box  box-primary">
        <div class="box-body">
            <div class="page-header">
                @if(isset($news))
                    <h3>{{$news->$name_table}}</h3>
                @else
                    <h3>@lang('admin.add_news')</h3>
                @endif
            </div>
            <div class="page-body">
                {!! Form::open(['files'=>'true']) !!}
                    @if(isset($news))
                        <input type="hidden" name="id"  value="{{$news->id}}">
                    @endif
                <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <?php $inc = 0;  ?>
                            @foreach($lang_data as $lang )
                                <li class="@if(! $inc ) active @endif">
                                    <a href="#tab_{!! $lang!!}" data-toggle="tab">
                                        {!! HTML::image("adminLTE/images/icon-".$lang.".png") !!}
                                    </a>
                                    <?php $inc++;?>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            <?php
                                $inc = 0;
                            ?>
                            @foreach( $lang_data as $lang )
                                <?php
                                $name               ='name_'.$lang;
                                $meta_name          ='meta_name_'.$lang;
                                $meta_description   ='meta_description_'.$lang;
                                $description        ='description_'.$lang;
                                $mini_description   ='mini_description_'.$lang;
                                $image              ='image_'.$lang;
                                ?>
                                <div class="tab-pane @if(! $inc ) active @endif" id="tab_{!! $lang!!}">

                                    <div class="form-group row">
                                        <?php
                                        $data = isset( $news )? $news->$name:'';
                                        $data = old($name,$data);
                                        ?>
                                         <label for="{{$name}}" class="col-sm-2 control-label"><span class="red">*</span>{!! trans('admin.name') !!}</label>
                                         <div class="col-sm-10" @if($errors->has($name)) id="has_errors" @endif>
                                            <input type="text" name="{!! $name !!}" value="{{ $data  }}" maxlength="150"  class="form-control"/>
                                            <span class="errors">{!!  $errors->first($name) !!}</span>
                                         </div>
                                    </div>

                                    <div class="form-group row">
                                        <?php
                                        $data = isset( $news )? $news->$meta_name:'';
                                        $data = old($meta_name,$data);
                                        ?>
                                         <label for="{{$meta_name}}" class="col-sm-2 control-label"><span class="red">*</span>{!! trans('admin.meta_title') !!}</label>
                                         <div class="col-sm-10" @if($errors->has($meta_name)) id="has_errors" @endif>
                                            <input type="text" name="{!! $meta_name !!}" value="{{ $data  }}" maxlength="255"  class="form-control"/>
                                            <span class="errors">{!!  $errors->first($meta_name) !!}</span>
                                         </div>
                                    </div>


                                    <div class="form-group row">
                                        <?php
                                            $data = isset( $news )? $news->$meta_description:'';
                                            $data = old($meta_description,$data);
                                        ?>
                                            <label for="{{$meta_description}}" class="col-sm-2 control-label">
                                                {!! trans('admin.meta_description') !!}
                                            </label>
                                            <div class="col-sm-10">
                                                <textarea  style="height: 80px" maxlength="255"  name="{!! $meta_description !!}" rows="2" class="form-control">{!! $data  !!}</textarea>
                                            </div>
                                    </div>


                                    <div class="form-group row">
                                        <?php
                                        $data = isset( $news )? $news->$mini_description:'';
                                        $data = old($mini_description,$data);
                                        ?>
                                        <label for="{{$mini_description}}" class="col-sm-2 control-label">{!! trans('admin.mini_description') !!}</label>
                                        <div class="col-sm-10" @if($errors->has($mini_description)) id="has_errors" @endif>
                                            <textarea  class="form-control" name="{!! $mini_description !!}" style="height:139px;" maxlength="190" >{!! $data  !!}</textarea>
                                            <span class="errors">{!!  $errors->first($mini_description) !!}</span>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <?php
                                        $data = isset( $news )? $news->$description:'';
                                        $data = old($description,$data);
                                        ?>
                                        <label for="{{$description}}" class="col-sm-2 control-label">{!! trans('admin.description') !!}</label>
                                        <div class="col-sm-10" @if($errors->has($description)) id="has_errors" @endif>
                                            <textarea   class="form-control"  name="{!! $description !!}"   >{!! $data  !!}</textarea>
                                        </div>
                                    </div>



                                </div>
                                <?php $inc++;?>
                            @endforeach
                        </div>

                        <div class="form-group row">
                            <?php
                            $data = isset( $news )? $news->image:'';
                            $data = old('image',$data);
                            ?>
                                <label for="image" class="col-sm-2 control-label">{!! trans('admin.image') !!}</label>
                                <div class="col-sm-10">
                                    @if(isset($news) && !empty($news->image))
                                        <div class="image_admin" style="margin-bottom:10px ">
                                            @if (file_exists('images/news/'.$news->image))
                                                <img src="{{asset('images/news')."/".$news->image}}" alt="">
                                            @else
                                                <img src="{{asset('adminLTE/images/no-image.png')}}" alt="">
                                            @endif
                                        </div>
                                    @elseif(isset($news))
                                        <div class="image_admin">
                                            <img src="{{asset('adminLTE/images/no-image.png')}}" alt="">
                                        </div>
                                    @endif

                                    {!! Form::file('image',['accept'=>'image/*','single ','class'=>'form-control']) !!}

                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">{!! trans('admin.status') !!}</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control">
                                    <option value="1" @if(isset($news->status) && $news->status == 1) selected @endif >@lang('admin.enable')</option>
                                    <option value="0" @if(isset($news->status) && $news->status == 0) selected @endif >@lang('admin.disable')</option>
                                </select>
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
        CKEDITOR.replace('description_ru', {height: 200});
        CKEDITOR.replace('description_ro', {height: 200});
    </script>
@stop