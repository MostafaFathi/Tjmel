@extends('clinic.layouts.app')

@section('content')



    <div class="content">

        <div class="card">
            <div class="card-body"
                 style="    background:white;border-radius: 30px;margin-top: 21px;">


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

                        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                            <li class="nav-item"><a href="#justified-right-icon-tab1" class="nav-link tab-link {{request()->get('page') == '' || request()->get('page') == 'details' ? 'active' : ''}}" name="details" data-toggle="tab">عملاء سيحضرون اليوم<span class="badge badge-warning mr-1 ml-1">{{count($todayReservations)}}</span></a>  </li>
                            <li class="nav-item"><a href="#justified-right-icon-tab2" class="nav-link tab-link {{request()->get('page') == 'services' ? 'active' : ''}}" name="services" data-toggle="tab">حجوزات نشطة <span class="badge badge-warning mr-1 ml-1">{{count($nowReservations)}}</span></a></li>
                            <li class="nav-item"><a href="#justified-right-icon-tab3" class="nav-link tab-link {{request()->get('page') == 'offers' ? 'active' : ''}}" name="offers" data-toggle="tab">حجوزات مكتملة <span class="badge badge-success mr-1 ml-1">{{count($completedReservations)}}</span></a></li>
                            <li class="nav-item"><a href="#justified-right-icon-tab4" class="nav-link tab-link {{request()->get('page') == 'rating' ? 'active' : ''}}" name="rating" data-toggle="tab">حجوزات غير مكتملة <span class="badge badge-primary mr-1 ml-1">{{count($unCompletedReservations)}}</span></a></li>

                        </ul>
                    <div style="    background: #f7f7f7;padding: 25px;border-radius: 20px;    box-shadow: 0px 1px 4px -2px;">
                       <div class="row" style="    padding: 0px 25px 12px 0px;">
                           <input type="text" class="form-control col-5"  id="price_after" name="price_after" value="{{old('search')}}">
                           <i class="icon-search4" style="    padding: 12px;font-size: 25px;color: #cecece;"></i>
                       </div>

                        <div class="tab-content">
                            <div class="tab-pane fade {{request()->get('page') == '' || request()->get('page') == 'details'  ? 'show active' : ''}} " id="justified-right-icon-tab1">
                                @include('clinic.reservations.today_reservations')
                            </div>

                            <div class="tab-pane fade  {{request()->get('page') == 'services'  ? 'show active' : ''}}" id="justified-right-icon-tab2">
                                @include('clinic.reservations.today_reservations')
                            </div>

                            <div class="tab-pane fade {{request()->get('page') == 'offers'  ? 'show active' : ''}}" id="justified-right-icon-tab3">
                                @include('clinic.reservations.today_reservations')
                            </div>

                            <div class="tab-pane fade {{request()->get('page') == 'rating'  ? 'show active' : ''}}" id="justified-right-icon-tab4">
                                @include('clinic.reservations.today_reservations')
                            </div>
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
        $(".click-month").on("click", function (e) {
            var month = $(this).attr('month');
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{url('clinic/appointments/date')}}/' + month,
                data: '',
                cache: "false",
                success: function (data) {
                    $('.next').attr('month',data.nextMonth);
                    $('.prev').attr('month',data.prevMonth);
                    $('.current-month').attr('month',data.currentMonth);
                    $('.current-month-input').val(data.currentMonth);
                    $('.current-month').text(data.currentMonthName);
                    $('.monthList').html(data.monthList);
                    $('.service_id').change();
                }, error: function (data) {
                }
            });
            return false;
        });
        $(document).on("click",".day-btn", function (e) {
            var date =  $(this).attr('date');
            if($(this).hasClass('checked')){
                $(this).find('.day-date').val('');
                $(this).removeClass('checked');
            }else{
                $(this).find('.day-date').val(date);
                $(this).addClass('checked');
            }
            return false;
        });
        $(document).on("click",".all-days-btn", function (e) {
            if($(this).hasClass('checked')){
                $(this).removeClass('checked');
                $('.month-days li').each(function(i){
                    $(this).find('.day-date').val('');
                    $(this).removeClass('checked');
                });
            }else{
                $(this).addClass('checked');
                $('.month-days li').each(function(i){
                    var date =  $(this).attr('date');
                    $(this).find('.day-date').val(date);

                    $(this).addClass('checked');
                });
            }

            return false;
        });
        $(document).on("click",".time-btn", function (e) {
            var time =  $(this).attr('time');
            if($(this).hasClass('checked')){
                $(this).find('.my-time').val('');
                $(this).removeClass('checked');
            }else{
                $(this).find('.my-time').val(time);
                $(this).addClass('checked');
            }
            return false;
        });
        $(document).on("click",".all-times-btn", function (e) {
            if($(this).hasClass('checked')){
                $(this).removeClass('checked');
                $('.ul-times li').each(function(i){
                    $(this).find('.my-time').val('');
                    $(this).removeClass('checked');
                });
            }else{
                $(this).addClass('checked');
                $('.ul-times li').each(function(i){
                    var time =  $(this).attr('time');
                    $(this).find('.my-time').val(time);
                    $(this).addClass('checked');
                });
            }

            return false;
        });
        $(".service_id").on("change", function (e) {
            var service_id = $(this).val();
            var month = $('.current-month').attr('month');
            $('.loader').removeClass('d-none');
            $('.ul-times li').each(function(i){
                $(this).find('.my-time').val('');
                $(this).removeClass('checked');
            });
            $('.month-days li').each(function(i){
                $(this).find('.day-date').val('');
                $(this).removeClass('checked');
            });
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{url('clinic/appointments/date')}}/' +month +'/'+service_id,
                data: '',
                cache: "false",
                success: function (data) {
                    $('.loader').addClass('d-none');
                    $('.monthList').html(data.monthList);
                    for (let i = 0; i < data.selectedTimes.length; i++) {
                        $('.ul-times li').each(function(j){
                            var time =  $(this).attr('time');
                            if (data.selectedTimes[i] == time){
                                $(this).find('.my-time').val(time);
                                $(this).addClass('checked');
                            }

                        });
                    }
                }, error: function (data) {
                    $('.loader').addClass('d-none');
                }
            });
            return false;
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
