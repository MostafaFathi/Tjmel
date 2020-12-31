@extends('clinic.layouts.app')

@section('content')



    <div class="content">

        <div class="card">
            <div class="card-body"
                 style="    background: #f7f7f7;border-radius: 30px;margin-top: 21px;box-shadow: 0px 1px 4px -2px;">


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


                <form class="rated" action="{{route('appointments.store')}}" method="post"
                      enctype="multipart/form-data">


                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-12 " style="margin: 0 auto">
                            <div class="inline-form-group">
                                <label class="" style="float: right;padding: 12px;font-weight: bold;" for="name">إختر الخدمة المراد فتح او اغلاق مواعيد لها في تطبيق تجميل</label>
                                <select name="service_id" required id="service_id"  class="form-control col-3 service_id"
                                        style="background: white;float: right">
                                    <option value="">إختر</option>
                                    @foreach($services as $service)
                                        <option
                                            value="{{$service->id}}" {{$service->id == old('service_id') ? 'selected' : ''}}>{{$service->name_ar}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <i class="icon-spinner9 spinner loader d-none" style="margin-top: 12px;margin-right: 10px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="    background: white;border-radius: 30px;border: 1px solid #c1c1c1;">
                        <div class="row" style="padding: 18px;">
                            <div class="col-1"></div>
                            <div class="col-11 " >
                                <div class="row" style="margin: 0 auto;height: 70px">
                                    <div class="col-3" style="    height: inherit;"></div>
                                    <ul class="month-header  col-5">
                                        <li><a href="#" class="click-month next" month="{{$nextMonth}}"><i style="font-size: 28px;color: #71758e;" class="icon-arrow-left5"></i></a> </li>
                                        <li class="current-month" month="{{$currentMonth}}"> {{$currentMonthName}} </li>
                                        <li><a href="#" class="click-month prev" month="{{$prevMonth}}"><i style="font-size: 28px;color: #71758e;" class="icon-arrow-right5"></i></a> </li>
                                    </ul>
                                    <div class="col-3"  style="    height: inherit;"></div>
                                </div>
                                <input type="hidden" name="current_month" class="current-month-input" value="{{$currentMonth}}">
                                <div class="row monthList">
                                    <ul class="month-days">
                                        @for($i = 1;$i <= $days;$i++)
                                            <li class="day-btn" date="{{$currentMonth.'-'.$i}}">
                                                <input type="hidden" class="day-date" name="dates[]" value="">
                                                {{$i}}
                                                <span>{{\Carbon\Carbon::parse($currentMonth.'-'.$i)->translatedFormat('l')}}</span></li>
                                        @endfor
                                        <li class="all-days-btn">حدد كل الشهر <span>جميع الايام</span></li>
                                    </ul>
                                </div>
                                <div class="row timeList">
                                    <ul class="ul-times">
                                        @foreach($times as $time)
                                            <li class="time-btn" time="{{$time}}" status="">
                                                <input type="hidden" class="my-time" name="times[]" value="">
                                                <input type="hidden" class="my-time-status" name="status[]" value="">
                                                {{$time}}
                                            </li>
                                        @endforeach
                                        <li class="all-times-btn">حدد كل الاوقات </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 " style="margin: 0 auto">
                                <div class="form-group">
                                    <button class="btn btn-orange" style="">حفظ</button>
                                </div>
                            </div>

                        </div>
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
            var status =  $(this).attr('status');
            if($(this).hasClass('checked')){
                $(this).find('.my-time').val('');
                $(this).find('.my-time-status').val('');
                $(this).removeClass('checked');
            }else{
                $(this).find('.my-time').val(time);
                $(this).find('.my-time-status').val(status);
                $(this).addClass('checked');
            }
            return false;
        });
        $(document).on("click",".all-times-btn", function (e) {
            if($(this).hasClass('checked')){
                $(this).removeClass('checked');
                $('.ul-times li').each(function(i){
                    $(this).find('.my-time').val('');
                    $(this).find('.my-time-status').val('');
                    $(this).removeClass('checked');
                });
            }else{
                $(this).addClass('checked');
                $('.ul-times li').each(function(i){
                    var time =  $(this).attr('time');
                    var status =  $(this).attr('status');
                    $(this).find('.my-time').val(time);
                    $(this).find('.my-time-status').val(status);
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
                $(this).find('.my-time-status').val('');
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
                            var status =  $(this).attr('status');
                            if (data.selectedTimes[i].time == time){
                                $(this).find('.my-time').val(time);
                                $(this).find('.my-time-status').val(status);
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
