<table class="table table-bordered table-hover">
    <?php
    $units = \App\Models\Units::get();
    ?>

    @if(isset($product))
        <?php
            $active_caracteristic = \App\Models\ProductCaracteristic::where('product_id',$product->id)->get();
            $active_c = [];
            foreach ($active_caracteristic as $item){
                array_push($active_c,$item->caracterisitc_id);
            }

            $caracteristic = DB::table('caracteristic')
                ->join('caracteristic_category','caracteristic.id','=','caracteristic_category.caracterisitc_id')
                ->where('caracteristic_category.category_id',$product->category_id)->get();
        ?>

        <tr>
            <th> @lang('admin.name_caracteristic')</th>
            <th> @lang('admin.value_caracteristic')</th>
            <th>@lang('admin.unit_caracteristic')</th>
            <th>@lang('admin.priority')</th>
        </tr>
        <?php $i = 0 ?>
        @foreach ($caracteristic as $item)
            @if(!empty($active_c) && in_array($item->caracterisitc_id,$active_c))
                @foreach($active_caracteristic as $item2)
                    @if($item->caracterisitc_id == $item2->caracterisitc_id)
                        <tr>
                            <td style='max-width: 100px'>
                                {{$item->$name}}
                            </td>
                            <td>
                                <input type='hidden' class='form-control' name='car_id[]' value='{{$item->caracterisitc_id}}'>
                                <div class='col-md-12'>
                                    <div class='col-md-1'>
                                        RO
                                    </div>
                                    <div class='col-md-11'>
                                        <?php
                                        $data = isset( $item2)? $item2->value_ro:"";
                                        ?>
                                        <input type='text' class='form-control'  value="{{$data}}"  name='value_ro[]' style='margin-bottom:3px;'>
                                    </div>
                                    <div class='col-md-1'>
                                        RU
                                    </div>
                                    <div class='col-md-11'>
                                        <?php
                                        $data = isset( $item2)? $item2->value_ru:"";

                                        ?>
                                        <input type='text' class='form-control' value="{{$data}}"  name='value_ru[]' style='margin-bottom:3px;'>
                                    </div>
                                </div>
                            </td>

                            <td style='max-width: 100px'>
                                <select class='form-control' name='unit_id[]' style='margin: 0px 10px 0 10px'>";
                                    <option value='0'>-</option>
                                    @foreach ($units as $unit)
                                        <option @if($item2->unit_id == $unit->id) selected @endif value="{{$unit->id}}">{{$unit->$name}}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="text-center">
                                <input name="check[]" class="check" value="{{$item->caracterisitc_id}}" @if($item2->home) checked @endif type="checkbox">
                            </td>

                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td style='max-width: 100px'>
                        {{$item->$name}}
                    </td>
                    <td>
                        <input type='hidden' class='form-control' name='car_id[]' value='{{$item->caracterisitc_id}}'>
                        <div class='col-md-12'>
                            <div class='col-md-1'>
                                RO
                            </div>
                            <div class='col-md-11'>
                                <input type='text' class='form-control' @if(old('value_ro')[$i]) value="{{old('value_ro')[$i]}}" @endif  name='value_ro[]' style='margin-bottom:3px;'>
                            </div>
                            <div class='col-md-1'>
                                RU
                            </div>
                            <div class='col-md-11'>
                                <input type='text' class='form-control'  @if(old('value_ru'[$i])) value="{{old('value_ru')[$i]}}" @endif  name='value_ru[]' style='margin-bottom:3px;'>
                            </div>
                        </div>
                    </td>

                    <td style='max-width: 100px'>
                        <select class='form-control' name='unit_id[]' style='margin: 0px 10px 0 10px'>";
                            <option value='0'>-</option>
                            @foreach ($units as $unit)
                                <option @if($data == $unit->id) selected @endif value="{{$unit->id}}">{{$unit->$name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="text-center">
                        <input name="check[]" class="check" value="{{$item->caracterisitc_id}}" type="checkbox">
                    </td>
                </tr>
            @endif
            <?php $i++; ?>
        @endforeach
    @endif
</table>