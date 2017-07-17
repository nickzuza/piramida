@extends('admin.layouts')
@section('content')
    <?php
        $name= "name_".Lang::getLocale();
    ?>
    <div class="box box-primary">
        <div class="box-body">

            <div class="page-header">
                @lang('admin.list_customers')
            </div>
            <div class="add_user">
                <a href="{!! URL::route('add_customer') !!}">
                    <button class="btn btn-primary btn-add"><i class="glyphicon-plus"></i> @lang('admin.add_customer')</button>
                </a>
            </div>
            <div class="success">
                @if(session('success'))
                    <div class="alert alert-success fade in " id="alert-message" style="font-size: 14px;">
                        <a class="close" href="#" data-dismiss="alert">x</a>
                        <i class="fa fa-check-circle"></i> {!! session('success') !!}
                        {!! Session::forget('success') !!}
                    </div>
                @endif
                    <div style="padding: 10px" ><a href="{{URL::route('export_customer')}}">
                            Export Email
                        </a></div>
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th> @lang('admin.name_customer') </th>
                        <th> @lang('admin.email') </th>
                        <th> @lang('admin.address') </th>
                        <th> @lang('admin.phone') </th>
                        <th class="text-right"> @lang('admin.actions') </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user as $item)
                        <tr>
                            <td>
                                {!! $item->name !!}
                            </td>

                            <td>
                                {!! $item->email !!}
                            </td>

                            <td>{{$item->address}}</td>

                            <td> {{ $item->phone }} </td>

                            <td class="text-right" style="max-width: 100px">
                                <a href="{!! URL::route('edit_customer',$item->id ) !!}">
                                    <div data-toggle="modal" data-target="#edit_{{$item->id}}" class="edit-pencil btn btn-primary btn-xs">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </div>
                                </a>

                                @if($item->role != 2)
                                    <div data-toggle="modal" data-target="#delete_{{$item->id}}" class="delete-trash btn btn-danger btn-xs">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <div class="modal fade"  role="dialog" id="delete_{{ $item->id }}">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">
                                            {!! $item->name !!}
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        {{ trans('admin.sure-delete') }} - <strong> {!! $item->name !!} </strong> ?
                                    </div>
                                    <div class="modal-footer">
                                        <div class="clearfix"></div>
                                        {!! Form::open(['method' => 'DELETE']) !!}
                                        {!! Form::hidden('id', $item->id) !!}
                                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.cancel') }}</button>
                                        <button type="submit" class="btn btn-warning">{{ trans('admin.delete') }}</button>
                                        {!! Form::close() !!}
                                    </div>

                                </div><!-- /.modal-content -->

                            </div><!-- /.modal-dialog -->

                        </div><!-- /.modal -->
                    @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@stop