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
                    <li class="nav-item"><a href="#justified-right-icon-tab1"
                                            class="nav-link tab-link {{request()->get('page') == '' || request()->get('page') == 'today' ? 'active' : ''}}"
                                            name="today" data-toggle="tab">عملاء سيحضرون اليوم<span
                                class="badge badge-secondary mr-1 ml-1">{{count($todayReservations)}}</span></a></li>
                    <li class="nav-item"><a href="#justified-right-icon-tab2"
                                            class="nav-link tab-link {{request()->get('page') == 'now' ? 'active' : ''}}"
                                            name="now" data-toggle="tab">حجوزات نشطة <span
                                class="badge badge-primary mr-1 ml-1">{{count($nowReservations)}}</span></a></li>
                    <li class="nav-item"><a href="#justified-right-icon-tab3"
                                            class="nav-link tab-link {{request()->get('page') == 'completed' ? 'active' : ''}}"
                                            name="completed" data-toggle="tab">حجوزات مكتملة <span
                                class="badge badge-success mr-1 ml-1">{{count($completedReservations)}}</span></a></li>
                    <li class="nav-item"><a href="#justified-right-icon-tab4"
                                            class="nav-link tab-link {{request()->get('page') == 'un-completed' ? 'active' : ''}}"
                                            name="un-completed" data-toggle="tab">حجوزات غير مكتملة <span
                                class="badge badge-warning mr-1 ml-1">{{count($unCompletedReservations)}}</span></a>
                    </li>

                </ul>
                <div
                    style="    background: #f7f7f7;padding: 25px;border-radius: 20px;    box-shadow: 0px 1px 4px -2px;">


                    <div class="tab-content">
                        <div
                            class="tab-pane fade {{request()->get('page') == '' || request()->get('page') == 'today'  ? 'show active' : ''}} "
                            id="justified-right-icon-tab1">
                            @include('clinic.reservations.today_reservations')
                        </div>

                        <div class="tab-pane fade  {{request()->get('page') == 'now'  ? 'show active' : ''}}"
                             id="justified-right-icon-tab2">
                            @include('clinic.reservations.now_reservations')
                        </div>

                        <div class="tab-pane fade {{request()->get('page') == 'completed'  ? 'show active' : ''}}"
                             id="justified-right-icon-tab3">
                            @include('clinic.reservations.completed_reservations')
                        </div>

                        <div class="tab-pane fade {{request()->get('page') == 'un-completed'  ? 'show active' : ''}}"
                             id="justified-right-icon-tab4">
                            @include('clinic.reservations.un_completed_reservations')
                        </div>
                    </div>
                </div>


            </div>
        </div>

        {{----}}
        <div id="change_status_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete_form" method="post" action="">
                        @csrf
                        <input name="id" id="item_id" class="form-control" type="hidden">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4 id="modalDescription">تأكيد الموافقة/الرفض للخدمة</h4>
                            <div class="form-group">
                                <label class="control-labell" for="">تعليق</label>
                                <textarea name="comment" id="comment"  rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-success waves-effect" id="delete_url">حفظ الحالة الجديدة</button>
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
        function approve_item(id, status, title, description) {
            $('#item_id').val(id);
            var url = "{{url('clinic/reservations/')}}/" + id + "/status/" + status;
            $('#delete_form').attr('action', url);
            $('#myModalLabel').text(title);
            $('#modalDescription').html(description);
        }

        $(document).ready(function () {

            $(".btn-file").remove();
            $(document).on('click','.tab-link',function(){
                window.history.replaceState(null,
                    null, "?page="+$(this).attr('name'));
                return false;
            })
            $("#today-reservations-search,#now-reservations-search,#completed-reservations-search,#un-completed-reservations-search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(this).parent().next().find('table').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                return false;
            });
        });
    </script>
@endsection
