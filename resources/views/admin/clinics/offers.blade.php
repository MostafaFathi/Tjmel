
            <div class="table-responsive">
                <table class="table">
                    <thead>

                    <tr>

                        <th class="numeric">#</th>
                        <th class="">الاسم</th>
                        <th class="">القسم</th>
                        <th class="">السعر</th>
                        <th class="">الحالة</th>
                        <th class="">التحكم</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($clinic->offers as $offer)

                        <tr @if(session('id') === $offer->id)class="bg-green" @endif>
                            <td>{{$offer->id}}</td>
                            <td>{{$offer->name_ar}}</td>
                            <td>{{$offer->section->title_ar ?? '--'}}</td>
                            <td>
                            <div style="text-decoration: line-through;color: #9E9E9E;">قبل الخصم:{{$offer->price_before ?? '--'}}</div>
                            <div class="font-weight-bold">بعد الخصم:{{$offer->price_after ?? '--'}}</div>

                            </td>
                            <td><span class="badge badge-{{$offer->status_color}}">{{$offer->status_name}}</span></td>
                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">إتخذ إجراء</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                <a class="dropdown-item " data-placement="top" title="عرض"
                                   href="{{route('admin.offers.show',$offer->id)}}"
                                  ><i class="icon-eye"></i>عرض</a>
                                    <a class="dropdown-item " data-placement="top" title="تعديل"
                                       href="{{route('admin.offers.edit',$offer->id)}}"
                                    ><i class="icon-pencil7"></i>تعديل</a>
                                <a class="dropdown-item" data-placement="top" title="{{$offer->status == 0 or $offer->status == 2 ? 'موافقة ونشر' : 'رفض وإخفاء'}}" href="javascript:void(0)"
                                   onclick="approve_item_offer('{{$offer->id}}','{{$offer->name}}')" data-toggle="modal"
                                   data-target="#delete_item_modal_offer"><i class="{{$offer->status == 0 || $offer->status == 2 ? 'icon-check2' : 'icon-cross3'}} "></i>{{$offer->status == 0 || $offer->status == 2 ? 'موافقة ونشر' : 'رفض وإخفاء'}}</a>

                                </div>



                            </td>

                        </tr>

                    @endforeach
                    @if(count($clinic->offers) == 0)
                        <tr>
                            <td colspan="6" class="text-center">
                                لا يوجد بيانات
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        <!-- /basic table -->
        {{----}}
        <div id="delete_item_modal_offer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete_form_offer" method="post" action="">
                        @csrf
                        <input name="id" id="item_id" class="form-control" type="hidden">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">موافقة/رفض العرض <span id="del_label_title"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4>تأكيد الموافقة/الرفض للعرض</h4>
                            <p id="grup_title"></p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-success waves-effect" id="delete_url">حفظ الحالة الجديدة</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->



        </div>


        <!-- /.modal-dialog -->




