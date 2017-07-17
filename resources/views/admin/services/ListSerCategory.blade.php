@extends('admin.layouts')
@section('content')
    <?php $name = "name_" . Lang::getLocale(); ?>
<div class="box box-primary">
    <div class="box-body">
        <div class="page-header"> @lang('admin.list_cat') </div>
        <div class="success"> @if(session('success'))
                <div class="alert alert-success fade in " id="alert-message" style="font-size: 14px;"><a class="close"
                                                                                                         href="#"
                                                                                                         data-dismiss="alert">x</a>
                    <i class="fa fa-check-circle"></i> {!! session('success') !!} {!! Session::forget('success') !!}
                </div> @endif </div>
        <div class="box-body pad table-responsive">
            <div class="add_cat"><a href="{!! URL::route('add_serv_category') !!}">
                    <button class="btn btn-primary btn-add"><i class="glyphicon-plus"></i> @lang('admin.add_cat')
                    </button>
                </a></div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>{!! trans('admin.name_cat') !!}</th>
                    <th class="text-center">{!! trans('admin.sort_order') !!}</th>
                    <th class="text-right">@lang('admin.actions')</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody> @foreach($cat as $item)
                    <tr>
                        <td> {!! $item->$name !!} </td>
                        <td class="text-center"> {!! $item->sort_order!!} </td>
                        <td class="text-right"><a href="{!! URL::route('edit_serv_category',$item->id ) !!}">
                                <div data-toggle="modal" data-target="#edit_{{$item->id }}"
                                     class="edit-pencil btn btn-primary btn-xs"><span
                                            class="glyphicon glyphicon-pencil"></span></div>
                            </a>
                            <div data-toggle="modal" data-target="#delete_{{$item->id }}"
                                 class="delete-trash btn btn-danger btn-xs"><span
                                        class="glyphicon glyphicon-trash"></span></div>
                        </td>
                        <td class="text-center">
                            @if($item->status == 0)
                                <span class="status-no-active "></span>
                            @else
                                <span class="status-active"></span>
                            @endif
                        </td>
                    </tr>
                    <div class="modal fade" role="dialog" id="delete_{{ $item->id  }}">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title"> {!! $item->$name !!} </h4></div>
                                <div class="modal-body"> {{ trans('admin.sure-delete') }} -
                                    <strong> {!! $item->$name !!} </strong> ?
                                </div>
                                <div class="modal-footer">
                                    <div class="clearfix"></div> {!! Form::open(['method' => 'DELETE']) !!} {!! Form::hidden('id', $item->id ) !!}
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">{{ trans('admin.cancel') }}</button>
                                    <button type="submit"
                                            class="btn btn-warning">{{ trans('admin.delete') }}</button> {!! Form::close() !!}
                                </div>
                            </div><!-- /.modal-content --> </div><!-- /.modal-dialog --> </div>
                    <!-- /.modal --> @endforeach </tbody>
            </table> {{$cat->links()}} </div>
    </div>
</div> @stop