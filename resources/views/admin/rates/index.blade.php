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
        <form action="" method="get" class="submit-search-form form">
            <h5>البحث</h5>
            <div class="form-row">


                <div class="input-group col-3 mb-md-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="addon-wrapping">اسم العيادة</span>
                    </div>
                    <input type="text" class="form-control" autocomplete="chrome-off" name="clinic_name_ar"
                           value="{{request()->get('clinic_name_ar')}}"
                           aria-describedby="addon-wrapping">
                </div>


                <input type="hidden" name="is_search_opened" class="is_search_opened"
                       value="{{request()->has('is_search_opened') ? request()->get('is_search_opened') : 0}}">

                <div class="collapse w-100 mb-3 {{request()->get('is_search_opened') == 1 ? 'show' : ''}}"
                     id="collapseExample">
                    <div class="card card-body">

                        <div class="form-row">


                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">التقييم</span>
                                </div>
                                <select name="rate_value" class="form-control" id="">
                                    <option value="" {{request()->get('rate_value') == 0 ? 'selected' : ''}}>إختر
                                    </option>
                                    <option
                                        value="1" {{request()->get('rate_value') == 1 && request()->get('rate_value') == 0  ? 'selected':''}}>
                                        ⭐
                                    </option>
                                    <option
                                        value="2" {{request()->get('rate_value') ==2 ? 'selected':''}}>⭐⭐
                                    </option>
                                    <option
                                        value="3" {{request()->get('rate_value') ==3 ? 'selected':''}}>⭐⭐⭐
                                    </option>
                                    <option
                                        value="4" {{request()->get('rate_value') ==4 ? 'selected':''}}>⭐⭐⭐⭐
                                    </option>
                                    <option
                                        value="5" {{request()->get('rate_value') ==5 ? 'selected':''}}>⭐⭐⭐⭐⭐
                                    </option>
                                </select>
                            </div>

                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">اسم العميل</span>
                                </div>
                                <input type="text" class="form-control" autocomplete="chrome-off" name="user_name"
                                       value="{{request()->get('user_name')}}"
                                       aria-describedby="addon-wrapping">
                            </div>

                            <div class="input-group col-4 mb-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                          id="addon-wrapping">رقم جوال العميل</span>
                                </div>
                                <input type="text" class="form-control" name="phone"
                                       value="{{request()->get('phone')}}"
                                       aria-describedby="addon-wrapping">
                            </div>


                        </div>


                    </div>

                </div>


                <div class="input-group-append col-2 mb-md-3">
                    <button class="btn btn-success mr-1 " type="submit">بحث</button>
                    <button class="btn btn-success mr-1 search-advanced" type="button" data-toggle="collapse"
                            data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        متقدم
                    </button>
                </div>

                <div
                    class="input-group-append {{request()->get('is_search_opened') == 1 ? 'col-10' : 'col-7'}} mb-md-3 export-div">


                </div>


            </div>
        </form>
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
                                <td>
                                    <a href="{{route('admin.reservations.index')}}?user={{$rate->app_user->mobile ?? ''}}">
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
                        @if(count($rates) > 0)
                            <tr>
                                <td colspan="10" class="text-center">
                                    {{ $rates->appends(request()->all())->links() }}
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
        $(document).on('click', '.search-advanced', function () {
            var is_search_opened = $('.is_search_opened').val();
            if (is_search_opened == '0') {
                is_search_opened = '1';
                $('.export-div').removeClass('col-7');
                $('.export-div').addClass('col-10');
            } else {
                $('.export-div').removeClass('col-10');
                $('.export-div').addClass('col-7');
                is_search_opened = '0';
            }

            $('.is_search_opened').val(is_search_opened);
            return false;
        });
        function delete_rate(id, title) {
            $('#item_id').val(id);
            var url = "{{url('admin/clinics/rates/delete')}}/" + id;
            $('#delete_form_rate').attr('action', url);
            $('#grup_title').text(title);
            $('#del_label_title').html(title);
        }

    </script>

@endsection

