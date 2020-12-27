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


                <form class="rated" action="{{route('offers.store')}}" method="post"
                      enctype="multipart/form-data">


                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-3 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">إختر القسم المناسب للعرض</label>
                                <select name="section_id" required id="section_id" class="form-control"
                                        style="background: #e6e6e6;">
                                    <option value="">إختر</option>
                                    @foreach($sections as $section)
                                        <option
                                            value="{{$section->id}}" {{$section->id == old('section_id') ? 'selected' : ''}}>{{$section->title_ar}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">أكتب اسم العرض</label>
                                <input type="text" class="form-control" required name="name_ar" id="name_ar"
                                       value="{{old('name_ar')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-4 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">أكتب تفاصيل العرض</label>
                                <textarea name="description_ar" class="form-control" id="description_ar"
                                          rows="5">{{old('description_ar')}}</textarea>
                            </div>
                        </div>
                        <div class="col-4 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">أكتب تعليمات العرض</label>
                                <textarea name="instructions_ar" class="form-control" id="instructions_ar"
                                          rows="5">{{old('instructions_ar')}}</textarea>
                            </div>
                        </div>
                        <div class="col-2"></div>

                    </div>
                    <div class="row">
                        <div class="col-3 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">أكتب سعر العرض قبل</label>
                                <input type="number" class="form-control" required id="price_before" name="price_before"
                                       value="{{old('price_before')}}">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-3 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">أكتب سعر العرض بعد</label>
                                <input type="number" class="form-control" required id="price_after" name="price_after"
                                       value="{{old('price_after')}}">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-3 " style="margin: 0 auto">
                            <div class="form-group">
                                <button class="btn btn-outline-secondary">إضافة عرض</button>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">


                    </div>

                </form>
            </div>
        </div>


    </div>
@endsection
@section('js_assets')
    <script src="{{asset('portal/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&language=ar"></script>

@endsection
@section('js_code')
    <script>
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
