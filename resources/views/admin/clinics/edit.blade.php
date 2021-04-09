@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">تعديل العيادة </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية </a>
                    <a href="{{route('clinics.index')}}" class="breadcrumb-item">العيادات</a>
                    <span class="breadcrumb-item active">تعديل</span>
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


                <form class="rated" action="{{route('clinics.update',$clinic->id)}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="name">الإسم</label>
                                <input type="text" class="form-control" id="clinic_name_ar" name="clinic_name_ar"
                                       value="{{$clinic->name_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">رقم الجوال</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="{{$clinic->phone}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">العنوان بالكامل</label>
                                <input type="text" class="form-control" id="full_address_ar" name="full_address_ar"
                                       value="{{$clinic->full_address_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">المدينة - الحي</label>
                                <input name="city_district" id="city" readonly value="{{$clinic->city_district}}" class="city form-control" placeholder="يتم تحديدها عن طريق الخريطة بالاسفل" required>
                            </div>
                            <div class="form-group d-none">
                                <label class="control-label" for="name">الحي</label>
                                <select name="district_id" id="districts" class=" districts form-control">
                                    <option value="">أولاً إخنر مدينة</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="name">اسم المستخدم</label>
                                <input type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$clinic->user->name_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">البريد الالكتروني</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{$clinic->user->email}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">كلمة السر</label>
                                <input type="password" class="form-control" id="password" name="password" value="">
                            </div>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">شعار العيادة</label>
                            <input type="file" name="logo" class="file-input-logo" data-show-caption="false"
                                   data-show-upload="false" data-fouc>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label">صور العيادة</label>
                            <input type="file" name="images[]" class="file-input" data-show-caption="false"
                                   data-show-upload="false" multiple data-fouc>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="control-label">الموقع على الخريطة</label>
                            <div id="map_canvas" class="maps" style="width:100%; height:300px;"></div>
                            <input type="hidden" name="location" id="coordinates" value="{{$clinic->location}}">
                        </div>
                    </div>
                    <div class="form-group">

                        <button class="btn btn-success">حفظ التغييرات</button>

                    </div>

                </form>
            </div>
        </div>


    </div>
@endsection
@section('js_assets')
    <script src="{{asset('portal/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&language=ar&key=AIzaSyAzSJQ93PnItj-wB5HsNCBBUZQTzCqqCDM"></script>

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
                data: {'district_id':{{$clinic->district_id ?? ''}}},
                cache: "false",
                success: function (data) {
                    $('#districts').html(data.options);
                }, error: function (data) {
                    if (city_id === '') {
                        $('#districts').html('<option value="">أولاً إخنر مدينة</option>');
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
            showRemove: true,
            zoomIcon: '<i class="icon-zoomin3"></i>',
            dragClass: 'p-2',
            dragIcon: '<i class="icon-three-bars"></i>',
            removeClass: 'remove-image-btn',
            removeErrorClass: 'text-danger',
            removeIcon: '<i class="icon-bin"></i>',
            indicatorNew: '<i class="icon-file-plus text-success"></i>',
            indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
            indicatorError: '<i class="icon-cross2 text-danger"></i>',
            indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
        };
        var options = {
            browseLabel: 'إختر ملف',
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },
            deleteUrl: "{{url('admin/city/districts')}}",
            overwriteInitial: false,

            initialPreviewAsData: true,
            initialCaption: "No file selected",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        };
        @isset($clinic->images)
            options['initialPreview'] = [
            @foreach($clinic->images as $image)
                '{{FileStorage::getUrl($image)}}',
            @endforeach
        ];
        options['initialPreviewConfig'] = [
                @foreach($clinic->images as $image)
            {
                caption: 'Image',
                key: '{{$image}}',
                method: 'get',
                url: '{{url('admin/clinics/image/delete').'/'.$clinic->id}}',
                showDrag: false
            },
            @endforeach
        ];
        @endisset
        $('.file-input').fileinput(options);

        var options2 = {
            browseLabel: 'إختر ملف',
            browseIcon: '<i class="icon-file-plus mr-2"></i>',
            uploadIcon: '<i class="icon-file-upload2 mr-2"></i>',
            removeIcon: '<i class="icon-cross2 font-size-base mr-2"></i>',
            layoutTemplates: {
                icon: '<i class="icon-file-check"></i>',
                modal: modalTemplate
            },

            initialPreviewAsData: true,
            initialCaption: "No file selected",
            allowedFileExtensions: ["jpg", "gif", "png"],
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        };
        @isset($clinic->logo)
            options2['initialPreview'] = [
            '{{$clinic->logo}}',
        ];
        options2['initialPreviewConfig'] =  [
            {caption: 'Image',  key: 1, url: '{{url('admin/clinics/logo/delete').'/'.$clinic->id}}', showDrag: false},
        ];
        @endisset
        $('.file-input-logo').fileinput(options2);


        function initialize() {
            var stockholm = new google.maps.LatLng{{$clinic->location ?? $location}};
            var parliament = new google.maps.LatLng{{$clinic->location ?? $location}};
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
            const geocoder = new google.maps.Geocoder();
            const infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'dragend', function (e) {
                var pp = marker.getPosition();
                $("#coordinates").val(pp).keyup();
                console.log();
                // getAddress (e.latLng.lat(), e.latLng.lng())
                geocodeLatLng(geocoder, map, infowindow,marker);
                map.setCenter(marker.getPosition());

            });
        }

        initialize();
        function geocodeLatLng(geocoder, map, infowindow,marker) {
            const input = document.getElementById("coordinates").value;
           var value = input.replace('(','');
            value = value.replace(')','');


            const latlngStr = value.split(",");
            const latlng = {
                lat: parseFloat(latlngStr[0]),
                lng: parseFloat(latlngStr[1]),
            };
            geocoder.geocode({ location: latlng }, (results, status) => {
                if (status === "OK") {
                    if (results[0]) {
                        console.log(results[0],'results[0]')
                        var city_name = results[0].address_components[3].long_name+' - '+results[0].address_components[2].long_name;
                        $('.city').val(city_name);
                        infowindow.setContent(city_name);
                        infowindow.open(map, marker);
                    } else {
                        window.alert("No results found");
                    }
                } else {
                    window.alert("Geocoder failed due to: " + status);
                }
            });
        }
    </script>
@endsection
