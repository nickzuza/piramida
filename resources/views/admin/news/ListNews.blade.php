@extends('admin.layouts')
@section('content')
    <?php
    $mini_description = 'mini_description_'.Lang::getLocale();
    $name =  'name_'.Lang::getLocale();
    ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="page-header">
                @lang('admin.list_news')
            </div>
            <div class="page-content">
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
                    <a href="{!! URL::route('add_news') !!}">
                        <button class="btn btn-primary add_button"><i class="glyphicon-plus"></i> @lang('admin.add_news')</button>
                    </a>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <th>@lang('admin.name')</th>
                        <th>@lang('admin.image')</th>
                        <th>@lang('admin.description')</th>
                        <th class="text-right">@lang('admin.actions')</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($news as $item)
                        <tr>
                            <td>{{$item->$name}}</td>
                            <td>
                                @if( !empty($item->image) && file_exists(public_path().'/images/news/'.$item->image))
                                    <img src="{{asset('images/news/'.$item->image)}}" alt="" style="width: 100px;max-height: 100px">
                                @else
                                    <img style="width: 100px ; max-height: 100px" src="{{asset('adminLTE/images/no-image.png')}}" alt="">
                                @endif
                            </td>
                            <td>{{$item->$mini_description}}</td>
                            <td class="text-right">
                                <a href="{!! URL::route('edit_news',$item->id ) !!}">
                                    <div data-toggle="modal" data-target="#edit_{{$item->id }}" class="edit-pencil btn btn-primary btn-xs">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </div>
                                </a>
                                <div data-toggle="modal" onclick="deleteProducts('{{$item->id}}','{{$item->$name}}')" data-target="#delete_{{$item->id}}" class="delete-trash btn btn-danger btn-xs">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </div>
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
                </table>
                {{$news->links()}}
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