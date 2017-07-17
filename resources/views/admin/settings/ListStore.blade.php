@extends('admin.layouts')
@section('content')
<div class="box box-primary">
    <div class="box-body">
        <div class="page-header">
            @lang('admin.list_store')
        </div>
        <div class="page-body">
            <?php
            $address = 'address_'.Lang::getLocale() ?>
            <div class="success">
                @if(session('success'))
                    <div class="alert alert-success fade in " id="alert-message" style="font-size: 14px;">
                        <a class="close" href="#" data-dismiss="alert">x</a>
                        <i class="fa fa-check-circle"></i> {!! session('success') !!}
                        {!! Session::forget('success') !!}
                    </div>
                @endif
            </div>
            <div class="new-btn">
                <a href="{!! URL::route('add_store') !!}">
                    <button class="btn btn-primary add_button"><i class="glyphicon-plus"></i> @lang('admin.add_store')</button>
                </a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <th>@lang('admin.address')</th>
                    <th>@lang('admin.phone')</th>
                    <th>@lang('admin.coordonate')</th>
                    <th class="text-center">@lang('admin.sort_order')</th>
                    <th class="text-right">@lang('admin.actions')</th>
                    <th></th>
                </thead>
                <tbody>
                                 
                @foreach($store as $item)
                    <tr>
                        <td>{{$item->$address}}</td>
                        <td>
                            {{$item->phone1}}<br>

                            @if(!empty(trim($item->phone2)))
                                {{$item->phone2}}<br>
                            @endif

                            @if(!empty(trim($item->phone3)))
                                {{$item->phone3}}<br>
                            @endif
                        </td>
                        <td>
                            @if(!empty(trim($item->coordonate_x)))
                                X - {{$item->coordonate_x}} <br>
                            @endif

                            @if(!empty(trim($item->coordonate_y)))
                                Y - {{$item->coordonate_y}} <br>
                            @endif
                        </td>

                        <td class="text-center">{{$item->sort_order}}</td>
                            <td class="text-right">
                                <a href="{!! URL::route('edit_store',$item->id ) !!}">
                                    <div data-toggle="modal" data-target="#edit_{{$item->id }}" class="edit-pencil btn btn-primary btn-xs">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </div>
                                </a>
                               
                                 @if($item->id != 6)
                                <div data-toggle="modal" onclick="deleteProducts('{{$item->id}}','@lang('admin.store')')" data-target="#delete_{{$item->id}}" class="delete-trash btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </div>
                               @endif
                            </td>
                            <td class="text-center">
                                @if($item->status == 0)
                                    <span class="status-no-active "></span>
                                @else
                                    <span class="status-active"></span>
                                @endif
                            </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="modal fade delete_dialog"  role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">

                            </h4>
                        </div>

                        <div class="modal-body">
                            {{ trans('admin.sure-delete') }} - <strong class="modal_name"></strong> ?
                        </div>

                        <div class="modal-footer">
                            <div class="clearfix"></div>
                            {!! Form::open(['method' => 'DELETE']) !!}
                            {!! Form::hidden('id', 1) !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.cancel') }}</button>
                            <button type="submit" class="btn btn-warning">{{ trans('admin.delete') }}</button>
                            {!! Form::close() !!}
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>
    </div>
</div>
@stop
@section('script')
    <script>
        function deleteProducts($id,$name) {
            $('.modal-title').html($name);
            $('.modal_name').html($name);
            $('input[name="id"]').val($id);
            $('.delete_dialog').modal();

        }
    </script>
@stop
