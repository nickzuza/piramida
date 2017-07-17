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
                            $name = 'name_'.$lang;
                            $url = 'url_'.$lang;
                            ?>
                            <div class="tab-pane @if(!$inc) active @endif" id="tab_{{$lang}}">

                                <div class="form-group row required">
                                    <label class="col-sm-2 control-label"><span class="red">*</span>{!! trans('admin.name') !!}</label>
                                    <div class="col-sm-10" @if($errors->has($name)) id="has_errors" @endif>
                                        <?php
                                        $data = isset( $filter)? $filter->$name:'';
                                        $data = old($name,$data);
                                        ?>
                                        <input type="text" name="{{$name}}" value="{{$data}}" class="form-control"/>
                                        <span class="errors">{!!  $errors->first($name) !!}</span>
                                    </div>
                                </div>
                            </div>
                            <?php $inc++ ?>
                        @endforeach
                            <div class="form-group row required">
                                <label class="col-sm-2 control-label">{!! trans('admin.sort_order') !!}</label>
                                <div class="col-sm-10">
                                    <?php
                                    $data = isset( $filter )? $filter->sort_order:"";
                                    $data = old('sort_order',$data)
                                    ?>
                                    <input type="number" name="sort_order" class="form-control" value="{{$data}}">

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
                        <input type="hidden" name="filter_id" value="{{$slug}}">
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
                '.chosen-select': {
                    width:"100%",
                    no_results_text:'Oops, nothing found!',
                    allow_single_deselect:true

                },
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