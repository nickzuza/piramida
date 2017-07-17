@extends('admin.layouts')
@section('content')
    <style>
        .chosen-container
        {
            width: 500px !important;
        }

    </style>


<div class="box box-primary">
    <div class="box-body">
        <div class="page-header">
            @if(isset($filter))
                @lang('admin.edit_filter')
            @else
                @lang('admin.add_filter')
            @endif
        </div>
        <?php
        $name = "name_".Lang::getLocale();
        ?>
            <div class="errors">
                @if(isset($errors) && count($errors->all()) > 0)
                    {{--{!! dd($errors->all()) !!}--}}
                    <div class="alert alert-danger fade in alert-error" id="alert-message">
                        <a class="close" href="#" data-dismiss="alert">x</a>

                        <ul style="list-style-type: none">
                            <li>@lang('error.required')</li>
                        </ul>
                    </div>
                @endif
            </div>

            <div class="box-body pad table-responsive about_class">
                {!! Form::open(['method'=>'POST','name'=>'Form-addPages','files'=>true]) !!}
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
                            $name_f = 'name_'.$lang;
                            $url = 'url_'.$lang;
                            ?>
                            <div class="tab-pane @if(!$inc) active @endif" id="tab_{{$lang}}">
                                <div class="form-group row required">
                                    <label class="col-sm-2 control-label"><span class="red">*</span>{!! trans('admin.name') !!}</label>
                                    <div class="col-sm-10" @if($errors->has($name_f)) id="has_errors" @endif>
                                        <?php
                                        $data = isset( $filter)? $filter->$name_f:'';
                                        $data = old($name_f,$data);
                                        ?>
                                        <input type="text" name="{{$name_f}}" value="{{$data}}" class="form-control"/>
                                        <span class="errors">{!!  $errors->first($name_f) !!}</span>
                                    </div>
                                </div>
                            </div>
                            <?php $inc++ ?>
                        @endforeach

                        @if(!isset($filter))
                            <div class="form-group row required">
                                <label class="col-sm-2 control-label">{!! trans('admin.select_type') !!}</label>
                                <div class="col-sm-10">
                                    <?php
                                        $data = isset( $fiter )? $filter->type:"";
                                        $data = old('type',$data)
                                    ?>
                                    <select name="type" class="form-control">
                                        <option value="1" @if($data == 1) selected @endif >@lang('admin.simple_checkbox')</option>
                                        <option value="2" @if($data == 2) selected @endif >@lang('admin.interval_checkbox')</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                            <div class="form-group row required">
                                <label class="col-sm-2 control-label"><span>*</span>{!! trans('admin.select_category') !!}</label>
                                <div class="col-sm-10" @if($errors->has('filter_category')) id="has_errors" @endif>

                                    <select name="filter_category[]" id="category_product" class="form-control select2" multiple="multiple">
                                        <?php
                                            $data = isset($filter)? $active :"";
                                            $data = old('filter_category',$data)
                                        ?>
                                        @foreach($categories as $level1)
                                            @if(isset($level1['level2']))
                                                <option class="optionGroup" @if(!empty($data) && in_array($level1->id,$data)) selected @endif disabled="disabled" value="{{$level1->id}}">{{$level1->$name}}</option>
                                                @foreach($level1['level2'] as $level2)
                                                    @if(isset($level2['level3']))
                                                        <option  class="optionGroup" @if(!empty($data) && in_array($level2->id,$data)) selected @endif disabled="disabled" value="{{$level2->id}}">{{$level2->$name}}</option>
                                                        @foreach($level2['level3'] as $level3)
                                                            <option class="optionChild" @if(!empty($data) && in_array($level3->id,$data)) selected @endif value="{{$level3->id}}">{{$level3->$name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option class=" optionChild level2" @if(!empty($data) && in_array($level2->id,$data)) selected @endif value="{{$level2->id}}">{{$level2->$name}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option class="optionGroup level1" @if(!empty($data) && in_array($level1->id,$data)) selected @endif value="{{$level1->id}}">{{$level1->$name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="errors">{!!  $errors->first('filter_category') !!}</span>
                                </div>
                            </div>

                            <div class="form-group row required">
                                <label class="col-sm-2 control-label">{!! trans('admin.select_units') !!}</label>
                                <div class="col-sm-10">
                                    <select name="units" class="form-control chosen-select">
                                       <?php $units = \App\Models\Units::orderBy('id','desc')->get() ?>
                                           <option value="" selected disabled>@lang('admin.select_units') </option>
                                           <?php
                                            $data = isset( $filter )? $filter->units:"";
                                            $data = old('units',$data)
                                           ?>
                                        @foreach($units as $item)
                                               <option @if($data == $item->id) selected @endif value="{{$item->id}}">{{$item->$name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row required">
                                <label class="col-sm-2 control-label"><span>*</span>{!! trans('admin.iden') !!}</label>
                                <div class="col-sm-10" @if($errors->has('iden')) id="has_errors" @endif>
                                    <?php
                                        $data = isset($filter)?$filter->iden:"";
                                        $data = old('iden',$data);
                                    ?>
                                    <input type="text" name="iden" value="{{$data}}" class="form-control" >
                                        <span class="errors">{!!  $errors->first('iden') !!}</span>

                                </div>
                            </div>
                            <div class="form-group row required">
                                <label class="col-sm-2 control-label">{!! trans('admin.sort_order') !!}</label>
                                <div class="col-sm-10" @if($errors->has('sort_order')) id="has_errors" @endif>
                                    <?php
                                    $data = isset($filter)?$filter->sort_order:"";
                                    $data = old('sort_order',$data);
                                    ?>
                                    <input type="number" name="sort_order" value="{{$data}}" class="form-control" >
                                    <span class="errors">{!!  $errors->first('sort_order') !!}</span>

                                </div>
                            </div>
                        <div class="form-group row required">
                            <label class="col-sm-2 control-label">{!! trans('admin.status') !!}</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control">
                                    <option value="1">@lang('admin.enable')</option>
                                    <option value="0">@lang('admin.disable')</option>
                                </select>

                            </div>
                        </div>
                        <div class="clear" style="clear: both"></div>
                    </div>
                    <input type="hidden" name="_Token" value="{{ csrf_token() }}">
                    @if(isset($filter))
                        <input type="hidden" name="id" value="{{$filter->id}}">
                    @endif
                    <div class="clear" style="clear: both"></div>
                    <input type="submit" value="@lang('admin.save')" class="btn btn-primary btn-save">
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
@endsection
@section('script')

    {!! HTML::script("adminLTE/chosen.jquery.min.js") !!}
    <script>
        $(function(){
            var config = {
                '.chosen-select': {width:"100%",no_results_text:'Oops, nothing found!',allow_single_deselect:true},
            };
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
            });


    </script>



    <script src="{!! asset('adminLTE/plugins/select2/select2.min.js') !!}"></script>
    <script>
        $(document).ready(function () {
            $('#category_product').select2();
        });
    </script>
@stop