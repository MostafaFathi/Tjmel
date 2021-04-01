@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">عرض تفاصيل العرض </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{route('offers.acceptance')}}" class="breadcrumb-item">العروض</a>
                    <span class="breadcrumb-item active">عرض</span>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">تفاصيل العرض</h5>

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


                <form class="rated" action="{{route('admin.offers.update',$offer->id)}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-6 ">

                            <div class="form-group">
                                <label class="control-label" for="name">الاسم</label>
                                <input type="text" class="form-control" disabled id="clinic_name_ar"
                                       name="clinic_name_ar"
                                       value="{{$offer->name_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name"> العيادة</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$offer->clinic->name_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">القسم</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$offer->section->title_ar}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">السعر قبل</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$offer->price_before}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">السعر بعد</label>
                                <input disabled type="text" class="form-control" id="user_name_ar" name="user_name_ar"
                                       value="{{$offer->price_after}}">
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="form-group">
                                <label class="control-label" for="name">الوصف</label>
                                <textarea name="" id="" rows="5" disabled
                                          class="form-control">{{$offer->description_ar}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">التعليمات</label>
                                <textarea name="" id="" rows="5" disabled
                                          class="form-control">{{$offer->instructions_ar}}</textarea>

                            </div>


                        </div>

                    </div>
                    <div class="form-group row d-none">
                        <div class="col-md-12">
                            <input type="file" name="image" class="file-input" data-show-caption="false" data-show-upload="false" data-fouc>
                        </div>
                    </div>
                    <div class="form-group d-none">

                        <button class="btn btn-primary"  style="background-color: #2196f3;" name="save_type" value="save_only">حفظ </button>
                        <button class="btn btn-success" style="background-color: #4caf50;" name="save_type" value="save_and_accept">حفظ وموافقة</button>

                    </div>
                </form>
            </div>
        </div>


    </div>
@endsection

@section('js_assets')
    <script src="{{asset('portal/global_assets/js/plugins/uploaders/fileinput/fileinput.min.js')}}"></script>
@endsection
@section('js_code')
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

            initialPreviewAsData: true,
            initialCaption: "No file selected",
            previewZoomButtonClasses: previewZoomButtonClasses,
            previewZoomButtonIcons: previewZoomButtonIcons,
            fileActionSettings: fileActionSettings
        };
        @isset($offer->image)
            options['initialPreview'] = [
            '{{FileStorage::getUrl($offer->image)}}',
        ];
        options['initialPreviewConfig'] =  [
            {caption: 'Image',  key: 1, url: '{{FileStorage::getUrl($offer->image)}}', showDrag: false},
        ];
        @endisset
        $('.file-input').fileinput(options);
    </script>
@endsection
