<div class="row pt-3">
    <div class="col-12 text-center ">

        <div class="form-group">
            <label class="control-label font-weight-bold" for="name">التقييم العام : </label>

            @for($i = 0;$i < round($clinic->rating);$i++)
                <i class="icon-star-full2" style="color: orange;font-size: 22px"></i>
            @endfor
            @for($i = 0;$i < (5 - round($clinic->rating));$i++)
                <i class="icon-star-empty3" style="color: #cdcdcd;font-size: 22px"></i>
            @endfor
            <span class="font-weight-bold">{{ ($clinic->rating / 5) * 100 }} %</span>

            <div></div>
        </div>
    </div>

</div>
<div class="table-responsive">
    <table class="table">
        <thead>

        <tr>

            <th class="numeric">#</th>
            <th class="">التعليق</th>
            <th class="">التقييم</th>
            <th class="">التحكم</th>

        </tr>

        </thead>

        <tbody>


        @foreach($clinic->rates as $rate)

            <tr @if(session('id') === $rate->id)class="bg-green" @endif>
                <td>{{$rate->id}}</td>
                <td>{{$rate->comment ?? '--'}}</td>
                <td>
                    @for($i = 0;$i < $rate->rate;$i++)
                        <i class="icon-star-full2" style="color: orange;font-size: 22px"></i>
                    @endfor
                    @for($i = 0;$i < (5 - $rate->rate);$i++)
                        <i class="icon-star-empty3" style="color: #cdcdcd;font-size: 22px"></i>
                    @endfor
                </td>
                <td>
                    <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ اجراء</a>
                    <div class="dropdown-menu dropdown-menu-lg">
                        <a class="dropdown-item" data-placement="top" title="حذف" href="javascript:void(0)"
                           onclick="delete_rate('{{$rate->id}}','{{$rate->name}}')" data-toggle="modal"
                           data-target="#delete_item_modal_rate"><i class="icon-cross3"></i>حذف</a>
                    </div>
                </td>

            </tr>

        @endforeach
        @if(count($clinic->rates) == 0)
            <tr>
                <td colspan="4" class="text-center">
                    لا يوجد بيانات
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<!-- /basic table -->
{{----}}
<div id="delete_item_modal_rate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="delete_form_rate" method="post" action="">
                @csrf
                {{ method_field('DELETE') }}
                <input name="id" id="item_id" class="form-control" type="hidden">
                <input name="_method" type="hidden" value="DELETE">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">حذف تقييم <span id="del_label_title"></span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h4>تأكيد حذف التقييم</h4>
                    <p id="grup_title"></p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-danger waves-effect" id="delete_url">حذف</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->


</div>


<!-- /.modal-dialog -->




