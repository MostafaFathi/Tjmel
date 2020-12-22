@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">عيادة جديدة </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{route('clinics.index')}}" class="breadcrumb-item">العيادات</a>
                    <span class="breadcrumb-item active">جديد</span>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">تفاصيل العيادة</h5>

            </div>

            <div class="card-body">


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form class="rated" action="{{route('clinics.store')}}" method="post"
                      enctype="multipart/form-data">


                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="name">الإسم</label>
                                <input type="text" class="form-control" id="clinic_name_ar" name="clinic_name_ar" value="{{old('clinic_name_ar')}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">رقم الجوال</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">العنوان بالكامل</label>
                                <input type="text" class="form-control" id="full_address_ar" name="full_address_ar" value="{{old('full_address_ar')}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">المدينة</label>
                                <select name="city_id" id="city" class="city form-control" required>
                                    <option value="">إختر</option>
                                    @foreach($cities as $city)
                                        <option
                                            value="{{$city->id}}" {{old('city_id') == $city->id ? 'selected' : ''}}>{{$city->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">الحي</label>
                                <select name="district_id" id="districts" class=" districts form-control">
                                    <option value="">أولاً إخنر مدينة</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="name">إسم المستخدم</label>
                                <input type="text" class="form-control" id="user_name_ar" name="user_name_ar" value="{{old('user_name_ar')}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">البريد الالكتروني</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">كلمة السر</label>
                                <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
                            </div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">شعار العيادة</label>
                            <input type="file" name="logo" class="file-input-logo" data-show-caption="false" data-show-upload="false"  data-fouc>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">صور العيادة</label>
                            <input type="file" name="images[]"  class="file-input" data-show-caption="false" data-show-upload="false" multiple data-fouc>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="control-label">الموقع على الخريطة</label>
                            <div id="map_canvas" class="maps" style="width:100%; height:300px;"></div>
                            <input type="hidden" name="location" id="coordinates" value="{{old('location')}}">
                        </div>
                    </div>
                    <div class="form-group">

                        <button class="btn btn-success">حفظ</button>

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

        function initialize() {
            var stockholm = new google.maps.LatLng{{old('location') ?? $location}};
            var parliament = new google.maps.LatLng{{old('location') ?? $location}};
            $("#coordinates").val(stockholm);
            var mapOptions = {
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: stockholm
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: parliament
            });
            google.maps.event.addListener(marker, 'dragend', function () {
                var pp = marker.getPosition();
                $("#coordinates").val(pp).keyup();
                map.setCenter(marker.getPosition());

            });
        }

        initialize();
    </script>
@endsection
