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
                                        <li class="text-center">{{ $error }}</li>
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


                <form class="form-update" action="{{route('services.update',0)}}" method="post"
                      enctype="multipart/form-data">
                    @method('put')

                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-3 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">إختر الخدمة</label>
                                <select name="service_id" required id="service_id" class="form-control service_id"
                                        style="background: #e6e6e6;">
                                    <option value="">إختر</option>
                                    @foreach($services as $service)
                                        <option
                                            value="{{$service->id}}" {{$service->id == old('service_id') ? 'selected' : ''}}>{{$service->name_ar}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <i class="icon-spinner9 spinner loader d-none"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">عدل قسم الخدمة</label>
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
                                <label class="control-label" for="name">عدل اسم الخدمة</label>
                                <input type="text" class="form-control" required name="name_ar" id="name_ar"
                                       value="{{old('name_ar')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-4 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">عدل تفاصيل الخدمة</label>
                                <textarea name="description_ar" class="form-control" id="description_ar"
                                          rows="5">{{old('description_ar')}}</textarea>
                            </div>
                        </div>
                        <div class="col-4 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">عدل تعليمات الخدمة</label>
                                <textarea name="instructions_ar" class="form-control" id="instructions_ar"
                                          rows="5">{{old('instructions_ar')}}</textarea>
                            </div>
                        </div>
                        <div class="col-2"></div>

                    </div>
                    <div class="row">
                        <div class="col-3 " style="margin: 0 auto">
                            <div class="form-group">
                                <label class="control-label" for="name">عدل سعر الخدمة</label>
                                <input type="number" class="form-control" required id="price" name="price"
                                       value="{{old('price')}}">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-3 " style="margin: 0 auto">
                            <div class="form-group">
                                <button class="btn btn-outline-secondary">حفظ</button>
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
        $(".service_id").on("change", function (e) {
            var service_id = $(this).val();
            $('.form-update').attr('action','{{url('clinic/services')}}/' + service_id)
            $('.loader').removeClass('d-none');
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{url('clinic/services')}}/' + service_id,
                data: '',
                cache: "false",
                success: function (data) {
                    $('.loader').addClass('d-none');
                   $('#name_ar').val(data.name_ar);
                   $('#description_ar').val(data.description_ar);
                   $('#instructions_ar').val(data.instructions_ar);
                   $('#price').val(data.price);
                   $('#section_id').val(data.section_id);
                }, error: function (data) {
                    $('.loader').addClass('d-none');
                }
            });
            return false;
        });

    </script>

@endsection
