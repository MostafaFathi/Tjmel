@extends('admin.layouts.app')

@section('content')
    <style>
        .nav-tabs .nav-item .nav-link .badge{
            position: relative;
            top: -4px;
        }
    </style>
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">عرض تفاصيل العيادة </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسة</a>
                    <a href="{{route('clinics.index')}}" class="breadcrumb-item">العيادات</a>
                    <span class="breadcrumb-item active">عرض</span>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">تفاصيل العيادة</h6>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                    <li class="nav-item"><a href="#justified-right-icon-tab1" class="nav-link tab-link {{request()->get('page') == '' || request()->get('page') == 'details' ? 'active' : ''}}" name="details" data-toggle="tab"><i class="icon-grid4 mr-2"></i>معلومات عامة </a></li>
                    <li class="nav-item"><a href="#justified-right-icon-tab2" class="nav-link tab-link {{request()->get('page') == 'services' ? 'active' : ''}}" name="services" data-toggle="tab"><i class="icon-yin-yang mr-2"></i>الخدمات <span class="badge badge-warning mr-1 ml-1">{{count($clinic->services)}}</span></a></li>
                    <li class="nav-item"><a href="#justified-right-icon-tab3" class="nav-link tab-link {{request()->get('page') == 'offers' ? 'active' : ''}}" name="offers" data-toggle="tab"><i class="icon-price-tag2 mr-2"></i>العروض <span class="badge badge-success mr-1 ml-1">{{count($clinic->offers)}}</span></a></li>
                    <li class="nav-item"><a href="#justified-right-icon-tab4" class="nav-link tab-link {{request()->get('page') == 'rating' ? 'active' : ''}}" name="rating" data-toggle="tab"><i class="icon-star-full2 mr-2"></i>التقييم <span class="badge badge-primary mr-1 ml-1">{{count($clinic->rates)}}</span></a></li>
                    <li class="nav-item"><a href="#justified-right-icon-tab5" class="nav-link tab-link {{request()->get('page') == 'reservations' ? 'active' : ''}}" name="reservations" data-toggle="tab"><i class="icon-cross3 mr-2"></i>حجوزات ملغية <span class="badge badge-danger mr-1 ml-1">{{count($clinic->rejectedReservationsByClinic)}}</span></a></li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade {{request()->get('page') == '' || request()->get('page') == 'details'  ? 'show active' : ''}} " id="justified-right-icon-tab1">
                        <form class="rated" action="{{route('clinics.update',$clinic->id)}}" method="post"
                              enctype="multipart/form-data">
                            @method('put')

                            {{csrf_field()}}
                            <div class="row">

                                <div class="col-6 ">

                                    <div class="form-group">
                                        <label class="control-label" for="name">الاسم</label>
                                        <input type="text" class="form-control" disabled id="clinic_name_ar" name="clinic_name_ar"
                                               value="{{$clinic->name_ar}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="name">رقم الجوال</label>
                                        <input type="text" class="form-control" disabled id="phone" name="phone"
                                               value="{{$clinic->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="name">العنوان بالكامل</label>
                                        <input type="text" class="form-control" disabled id="full_address_ar" name="full_address_ar"
                                               value="{{$clinic->full_address_ar}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="name">المدينة - الحي</label>
                                        <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                               value="{{$clinic->city_district}}">
                                    </div>
{{--                                    <div class="form-group">--}}
{{--                                        <label class="control-label" for="name"></label>--}}
{{--                                        <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"--}}
{{--                                               value="{{$clinic->district->name_ar}}">--}}
{{--                                    </div>--}}
                                </div>
                                <div class="col-6 ">

                                    <div class="form-group">
                                        <label class="control-label" for="name">اسم المستخدم</label>
                                        <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                               value="{{$clinic->user->name_ar}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="name">البريد الالكتروني</label>
                                        <input disabled type="email" class="form-control" id="email" name="email"
                                               value="{{$clinic->user->email}}">
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

                        </form>
                    </div>

                    <div class="tab-pane fade  {{request()->get('page') == 'services'  ? 'show active' : ''}}" id="justified-right-icon-tab2">
                        @include('admin.clinics.services')
                    </div>

                    <div class="tab-pane fade {{request()->get('page') == 'offers'  ? 'show active' : ''}}" id="justified-right-icon-tab3">
                        @include('admin.clinics.offers')
                    </div>

                    <div class="tab-pane fade {{request()->get('page') == 'rating'  ? 'show active' : ''}}" id="justified-right-icon-tab4">
                        @include('admin.clinics.rates')
                    </div>
                    <div class="tab-pane fade {{request()->get('page') == 'reservations'  ? 'show active' : ''}}" id="justified-right-icon-tab5">
                        @include('admin.clinics.reservations')
                    </div>
                </div>
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
        function approve_item(id, title) {
            $('#item_id').val(id);
            var url = "{{url('admin/clinics/services/approve')}}/" + id;
            $('#delete_form').attr('action', url);
            $('#grup_title').text(title);
            $('#del_label_title').html(title);
        }
        function approve_item_offer(id, title) {
            $('#item_id').val(id);
            var url = "{{url('admin/clinics/offers/approve')}}/" + id;
            $('#delete_form_offer').attr('action', url);
            $('#grup_title').text(title);
            $('#del_label_title').html(title);
        }
        function delete_rate(id, title) {
            $('#item_id').val(id);
            var url = "{{url('admin/clinics/rates/delete')}}/" + id;
            $('#delete_form_rate').attr('action', url);
            $('#grup_title').text(title);
            $('#del_label_title').html(title);
        }

        $(document).ready(function () {

            $(".btn-file").remove();
            $(document).on('click','.tab-link',function(){
                window.history.replaceState(null,
                    null, "?page="+$(this).attr('name'));
                return false;
            })
        });

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
            showRemove: false,
            showUpload: false, // will be always false for resumable uploads
            showDownload: false,
            showZoom: true,
            showDrag: false,
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
            browseLabel: 'Browse',
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
            browseLabel: 'Browse',
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
            {caption: 'Image',  key: 1, url: '{{$clinic->logo}}', showDrag: false},
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
            google.maps.event.addListener(marker, 'dragend', function () {
                var pp = marker.getPosition();
                $("#coordinates").val(pp).keyup();
                map.setCenter(marker.getPosition());

            });
        }

        initialize();
    </script>
@endsection
