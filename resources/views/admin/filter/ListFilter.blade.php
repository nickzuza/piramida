@extends('admin.layouts')
@section('content')
    <?php
        $name = 'name_'.Lang::getLocale();
    ?>
    <style>
        .parent
        {
            background-color: #f5f5f5;
        }
    </style>
    <div class="box box-primary">
        <div class="box-body ">
            <div class="page-header">
                @lang('admin.list_filter')
            </div>
            <div class="success"> @if(session('success'))
                    <div class="alert alert-success fade in " id="alert-message" style="font-size: 14px;"><a class="close"
                                                                                                             href="#"
                                                                                                             data-dismiss="alert">x</a>
                        <i class="fa fa-check-circle"></i> {!! session('success') !!} {!! Session::forget('success') !!}
                    </div> @endif </div>
            <div class="page-body">
                <a href="{{URL::route('add_filter')}}">
                <button type="button" class="btn btn-primary top_button_admin" data-toggle="modal" data-target="#add">
                    <span class="glyphicon glyphicon-plus"></span> @lang('admin.add_filter')
                </button>
                </a>
                <table class="table table-bordered">
                    <thead>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.sort_order')</th>
                        <th>@lang('admin.type')</th>
                        <th class="text-right">@lang('admin.actions')</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($filter as $item)
                        <tr class="parent">
                             <td>{{$item->$name}}[{{$item->iden}}]</td>
                             <td>{{$item->sort_order}}</td>
                             <td>@if($item->type == 1)
                                        @lang('admin.simple_checkbox')
                                  @else
                                        @lang('admin.interval_checkbox')
                                  @endif
                             </td>
                        <td class="text-right">
                            <a href="{!! URL::route('edit_filter',$item->id ) !!}">
                                <div data-toggle="modal" data-target="#edit_{{$item->id }}"
                                     class="edit-pencil btn btn-primary btn-xs"><span
                                            class="glyphicon glyphicon-pencil"></span>
                                </div>
                            </a>
                            <a href="{{URL::route('add_filter_prop',$item->id)}}">
                                <button class="btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
                            </a>
                            <div data-toggle="modal"
                                 onclick="deleteProducts('{{$item->id }}','{{$item->$name}}','1')"
                                 data-target="#delete_{{$item->id}}" class="delete-trash btn btn-danger btn-xs"><span
                                        class="glyphicon glyphicon-trash"></span></div>
                        </td>
                            <td class="text-center">

                                @if($item->status == 0)

                                    <span class="no-active"></span>

                                @else

                                    <span class="active"></span>

                                @endif

                            </td>
                      </tr>
                           @if(isset($item['prop']))
                               @foreach($item['prop'] as $prop)
                               <tr class="children">
                                   <td style="padding-left: 20px">{{$prop->$name}}</td>
                                   <td>{{$prop->sort_order}}</td>
                                   <td></td>
                                   <td class="text-right">
                                       <a href="{!! URL::route('edit_filter_prop',$prop->id ) !!}">
                                           <div
                                                class="edit-pencil btn btn-primary btn-xs"><span
                                                       class="glyphicon glyphicon-pencil"></span>
                                           </div>
                                       </a>
                                       <div data-toggle="modal"
                                            onclick="deleteProducts('{{$prop->id }}','{{$prop->$name}}','2')"
                                            data-target="#delete_{{$prop->id}}" class="delete-trash btn btn-danger btn-xs"><span
                                                   class="glyphicon glyphicon-trash"></span></div>
                                   </td>
                                   <td class="text-center">

                                       @if($prop->status == 0)

                                           <span class="no-active"></span>

                                       @else

                                           <span class="active"></span>

                                       @endif

                                   </td>
                               </tr>
                               @endforeach
                           @endif
                     @endforeach
                    </tbody>
                    <div class="modal fade delete_dialog"  role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    {{ trans('admin.sure-delete') }} - <strong class="modal_name">  </strong> ?
                                </div>

                                <div class="modal-footer">
                                    <div class="clearfix"></div>
                                    {!! Form::open(['method' => 'DELETE']) !!}
                                    {!! Form::hidden('id', 1) !!}
                                    {!! Form::hidden('type', 0) !!}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.cancel') }}</button>
                                    <button type="submit" class="btn btn-warning">{{ trans('admin.delete') }}</button>
                                    {!! Form::close() !!}
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </table>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        function deleteProducts($id,$name,$type) {
            $('.modal-title').html($name);
            $('.modal_name').html($name);
            $('input[name="id"]').val($id);
            $('input[name="type"]').val($type);
            $('.delete_dialog').modal();
        }
    </script>
@stop