@extends('admin.layouts')
@section('style')
<style>
    #products_filter{
        text-align: right;
    }
</style>
@stop
@section('content')
    {!! Form::open() !!}
                    <?php
                            $langs = ['ro'=>'ro','ru'=>'ru','en'=>'en'];
                        ?>
               <div class="box  box-primary">
                <div class="box-body">
                    <div class="col-md-12">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <?php $increment = 0;?>

                                @foreach( $langs as $key=>$item )
                                    <li class="@if( $increment == 0 ) active @endif ">
                                        <a href="#tab_{!! $key !!}" data-toggle="tab"
                                           aria-expanded="false">{!! $item !!}</a>
                                    </li>
                                    <?php $increment++;?>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                <?php
                                    $increment = 0;
                                    $resources = resource_path();
                                ?>
                                @foreach( $langs as $key=>$item )
                                    <div class="tab-pane @if( $increment == 0 ) active @endif" id="tab_{!! $key !!}">

                                        <?php
                                        $arrays = [];

                                        if (file_exists( $resources . '/lang/' . $key . '/v.php')) {
                                            $arrays = include($resources . '/lang/' . $key . '/v.php');

                                        }
                                        ?>
                                        @if( $arrays )
                                                <table class="table table-bordered products">
                                                <thead>
                                                <tr>
                                                    <th>Key</th>
                                                    <th>Value</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach( $arrays as $key2=>$value)
                                                    <tr>
                                                        <th>
                                                            {!! $key2 !!}
                                                        </th>
                                                        <td width="80%">
                                                            <p style="display: none">{!!nl2br(e($value))!!}</p>
                                                            <input type="text"  name="{!! $key.'_'.$key2 !!}" class="form-control" style="width: 100%"  value="{!!nl2br(e($value))!!}" required>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                                </table>

                                            @endif

                                    </div>
                                    <?php $increment++;?>
                                    @endforeach
                                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                    </div>
                </div>
    </div>
                <!-- /.box-body -->

                <!-- /.box-footer-->
                <div class="clearfix"></div>
                <button type="submit"  class="btn btn-app" >
                    <i class="fa fa-save"></i> @lang('admin.save')
                </button>
                {!! Form::close() !!}

@stop
@section('script')
    <!-- DataTables -->
    {!! HTML::script('/js/jquery.dataTables.min.js') !!}
    {!! HTML::script('/js/dataTables.bootstrap.min.js') !!}
    <script>


        $(function(){
            $('.products').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "iDisplayLength": 25,
                "aaSorting": [],


                @if(Lang::getLocale()=='ro')
                "language": {
                    "sProcessing":   "Proceseaza...",
                    "sLengthMenu":   "Afiseaza _MENU_ inregistrari pe pagina",
                    "sZeroRecords":  "Nu am gasit nimic - ne pare rau",
                    "sInfo":         "Afisate de la _START_ la _END_ din _TOTAL_ inregistrari",
                    "sInfoEmpty":    "Afisate de la 0 la 0 din 0 inregistrari",
                    "sInfoFiltered": "(filtrate dintr-un total de _MAX_ inregistrari)",
                    "sInfoPostFix":  "",
                    "sSearch":       "Cauta:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Prima",
                        "sPrevious": "Precedenta",
                        "sNext":     "Urmatoarea",
                        "sLast":     "Ultima"
                    }
                },
                @else
                "language": {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показать _MENU_ записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                },
                @endif


            });
        });
    </script>
@stop
