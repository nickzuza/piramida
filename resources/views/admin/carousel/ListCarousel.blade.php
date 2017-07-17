@extends('admin.layouts')
@section('content')
<div class="box box-primary">
    <div class="box-body">
        <div class="page-header">
            @lang('admin.list_carousel')
        </div>
        <div class="page-body">
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
                <a href="{!! URL::route('add_carousel') !!}">
                    <button class="btn btn-primary add_button"><i class="glyphicon-plus"></i> @lang('admin.add_carousel')</button>
                </a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <th>@lang('admin.image')(RU)</th>
                    <th>@lang('admin.image')(RO)</th>
                    <th>@lang('admin.url')</th>
                    <th class="text-center">@lang('admin.sort_order')</th>
                    <th class="text-right">@lang('admin.actions')</th>
                    <th></th>
                </thead>
                <tbody>
                                 
                @foreach($carousel as $item)
                    <tr>
                        <?php $langs = $lang_data ?>
                        @foreach($langs as $lang)
                            <?php $image = "image_".$lang?>
                            <td ><img style="width: 200px" src="{!! asset('images/carousel').'/'.$item->$image !!}" alt=""></td>
                        @endforeach
                        <td>
                            @foreach($langs as $lang)
                              <?php $url = "url_".$lang?>
                              {{strtoupper($lang)."- ".$item->$url}}<br>
                             @endforeach
                        </td>
                        <td class="text-center">{{$item->sort_order}}</td>
                            <td class="text-right">
                                <a href="{!! URL::route('edit_carousel',$item->id ) !!}">
                                    <div data-toggle="modal" data-target="#edit_{{$item->id }}" class="edit-pencil btn btn-primary btn-xs">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </div>
                                </a>
                               

                                <div data-toggle="modal" onclick="deleteProducts('{{$item->id}}','@lang('admin.carousel')')" data-target="#delete_{{$item->id}}" class="delete-trash btn btn-danger btn-xs">
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
