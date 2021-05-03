@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">التقييمات</span></h4>
            </div>

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="#" class="breadcrumb-item">التقييمات</a>

                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <!-- Basic table -->
        <div class="card">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table">
                        <thead>

                        <tr>

                            <th class="numeric">#</th>
                            <th class="">العيادة</th>
                            <th class="">المستخدم</th>
                            <th class="">التعليق</th>
                            <th class="">التقييم</th>
                            <th class="">التحكم</th>

                        </tr>

                        </thead>

                        <tbody>


                        @foreach($rates as $rate)

                            <tr @if(session('id') === $rate->id)class="bg-green" @endif>
                                <td>{{$rate->id}}</td>
                                <td><a title="Show" href="{{route('clinics.show',$rate->clinic->id ?? 0)}}">
                                        {{$rate->clinic->name_ar ?? ''}}
                                    </a></td>
                                <td><a href="{{route('admin.reservations.index')}}?user={{$rate->app_user->mobile ?? ''}}">
                                        {{$rate->app_user->mobile ?? ''}}
                                    </a></td>
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
                                    <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ
                                        اجراء</a>
                                    <div class="dropdown-menu dropdown-menu-lg">
                                        <a class="dropdown-item" data-placement="top" title="حذف"
                                           href="javascript:void(0)"
                                           onclick="delete_rate('{{$rate->id}}','{{$rate->name}}')" data-toggle="modal"
                                           data-target="#delete_item_modal_rate"><i class="icon-cross3"></i>حذف</a>
                                    </div>
                                </td>

                            </tr>

                        @endforeach
                        @if(count($rates) == 0)
                            <tr>
                                <td colspan="6" class="text-center">
                                    لا يوجد بيانات
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- /basic table -->
            {{----}}
            <div id="delete_item_modal_rate" class="modal fade" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel"
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
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق
                                </button>
                                <button type="submit" class="btn btn-danger waves-effect" id="delete_url">حذف</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->


            </div>

        </div>
        <!-- /basic table -->
    {{----}}


    <!-- /.modal-dialog -->


    </div>
@endsection

@section('js_assets')
@endsection

@section('js_code')

    <script>
        function delete_rate(id, title) {
            $('#item_id').val(id);
            var url = "{{url('admin/clinics/rates/delete')}}/" + id;
            $('#delete_form_rate').attr('action', url);
            $('#grup_title').text(title);
            $('#del_label_title').html(title);
        }

    </script>

@endsection

