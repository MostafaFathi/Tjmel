@extends('clinic.layouts.app')

@section('content')



    <div class="content">

        <div class="card">
            <div class="card-body">


                @if ($errors->any())
                    <div class="row">
                        <div class="col-4 " style="margin: 0 auto">
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if (session('success'))
                    <div class="row">
                        <div class="col-4 " style="margin: 0 auto">
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="6" class="text-center font-weight-bold" style="font-size: 22px;    color: #969696;">إدارة العروض التي تقدمها العيادة</th>
                            </tr>
                            <tr>

                                <th class="numeric">#</th>
                                <th class="">عنوان العرض</th>
                                <th class="">القسم</th>
                                <th class="">السعر</th>
                                <th class="">الحالة</th>
                                <th class="">التحكم</th>

                            </tr>

                            </thead>

                            <tbody>


                            @foreach($offers as $offer)

                                <tr @if(session('id') === $offer->id)class="bg-green" @endif>
                                    <td>{{$offer->id}}</td>
                                    <td>
                                        <a title="تعديل"
                                           href="{{route('offers.edit',$offer->id)}}"
                                        >{{$offer->name_ar}}</a>
                                    </td>
                                    <td>{{$offer->section->title_ar ?? '--'}}</td>
                                    <td>
                                        <div style="text-decoration: line-through;color: #9E9E9E;">قبل الخصم:{{$offer->price_before ?? '--'}}</div>
                                        <div class="font-weight-bold">بعد الخصم:{{$offer->price_after ?? '--'}}</div>

                                    </td>
                                    <td><span class="badge badge-{{$offer->status_color}}">{{$offer->status_name}}</span></td>
                                    <td>
                                        <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">اتخذ اجراء</a>

                                        <div class="dropdown-menu dropdown-menu-lg">
                                            <a class="dropdown-item " data-placement="top" title="تعديل"
                                               href="{{route('offers.edit',$offer->id)}}"
                                            ><i class="icon-pencil7"></i>تعديل</a>
                                            <a class="dropdown-item" data-placement="top" title="حذف" href="javascript:void(0)"
                                               onclick="delete_item('{{$offer->id}}','{{$offer->name}}')" data-toggle="modal"
                                               data-target="#delete_item_modal"><i class="icon-cross3"></i>حذف</a>

                                        </div>



                                    </td>

                                </tr>

                            @endforeach
                            <tr>
                                <td colspan="6" class="text-center">
                                    {{ $offers->links() }}
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

            </div>
        </div>

        <div id="delete_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete_form_delete" method="post" action="">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input name="id" id="item_id_delete" class="form-control" type="hidden">
                        <input name="_method" type="hidden" value="DELETE">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">حذف العرض <span id="del_label_title_delete"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4>تأكيد حذف العرض</h4>
                            <p id="grup_title_delete"></p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-danger waves-effect" id="delete_url_delete">حذف</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->



        </div>

    </div>
@endsection
@section('js_assets')
    <script src="{{asset('portal/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&language=ar"></script>

@endsection
@section('js_code')
    <script>
        function delete_item(id, title) {
            $('#item_id_delete').val(id);
            var url = "<?php echo e(url('clinic/offers/delete')); ?>/" + id;
            $('#delete_form_delete').attr('action', url);
            $('#grup_title_delete').text(title);
            $('#del_label_title_delete').html(title);
        }

        $(".city").on("change", function (e) {
            var city_id = $(this).val();
            $('#districts').html('<option value="">Firstly, Choose city</option>');
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{url('admin/city/districts')}}/' + city_id,
                data: {'district_id': '{{old('district_id') ?? ''}}'},
                cache: "false",
                success: function (data) {
                    $('#districts').html(data.options);
                }, error: function (data) {
                    if (city_id === '') {
                        $('#districts').html('<option value="">أولاً إختر مدينة</option>');
                    } else {
                        $('#districts').html('<option value="">لا يوجد أحياء مضافة</option>');
                    }
                }
            });
            return false;
        });
        $(".city").change();
    </script>
    <script>
        var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
            '  <div class="modal-content">\n' +
            '    <div class="modal-header align-items-center">\n' +
            '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
            '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
            '    </div>\n' +
            '    <div class="modal-body">\n' +
            '      <div class="floating-buttons btn-group"></div>\n' +
            '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</div>\n';

        // Buttons inside zoom modal
        var previewZoomButtonClasses = {
            toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
            fullscreen: 'btn btn-light btn-icon btn-sm',
            borderless: 'btn btn-light btn-icon btn-sm',
            close: 'btn btn-light btn-icon btn-sm'
        };

        // Icons inside zoom modal classes
        var previewZoomButtonIcons = {
            prev: '<i class="icon-arrow-left32"></i>',
            next: '<i class="icon-arrow-right32"></i>',
            toggleheader: '<i class="icon-menu-open"></i>',
            fullscreen: '<i class="icon-screen-full"></i>',
            borderless: '<i class="icon-alignment-unalign"></i>',
            close: '<i class="icon-cross2 font-size-base"></i>'
        };

        // File actions
        var fileActionSettings = {
            zoomClass: '',
            zoomIcon: '<i class="icon-zoomin3"></i>',
            dragClass: 'p-2',
            dragIcon: '<i class="icon-three-bars"></i>',
            removeClass: '',
            removeErrorClass: 'text-danger',
            removeIcon: '<i class="icon-bin"></i>',
            indicatorNew: '<i class="icon-file-plus text-success"></i>',
            indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
            indicatorError: '<i class="icon-cross2 text-danger"></i>',
            indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
        };

        $('.file-input').fileinput({
            browseLabel: 'إختر ملف',
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },
            initialCaption: "No file selected",
            allowedFileExtensions: ["jpg", "gif", "png"],
            maxFileCount: 9,
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        });

        $('.file-input-logo').fileinput({
            browseLabel: 'إختر ملف',
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },
            initialCaption: "No file selected",
            allowedFileExtensions: ["jpg", "gif", "png"],
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        });


    </script>
@endsection
