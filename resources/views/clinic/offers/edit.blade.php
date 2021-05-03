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

                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <form class="form-update" action="{{route('offers.update',$offer->id)}}" method="post"
                              enctype="multipart/form-data">
                            @method('put')

                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 " style="margin: 0 auto">
                                    <div class="form-group">
                                        <label class="control-label" for="name">عدل قسم العرض</label>
                                        <select name="section_id" required id="section_id" class="form-control"
                                                style="background: #e6e6e6;">
                                            <option value="">إختر</option>
                                            @foreach($sections as $section)
                                                <option
                                                    value="{{$section->id}}" {{$section->id == $offer->section_id ? 'selected' : ''}}>{{$section->title_ar}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 " style="margin: 0 auto">
                                    <div class="form-group">
                                        <label class="control-label" for="name">عدل اسم العرض</label>
                                        <input type="text" class="form-control" required name="name_ar" id="name_ar"
                                               value="{{$offer->name_ar}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-1"></div>
                                <div class="col-lg-4 col-md-4 col-sm-5 " style="margin: 0 auto">
                                    <div class="form-group">
                                        <label class="control-label" for="name">عدل تفاصيل العرض</label>
                                        <textarea name="description_ar" class="form-control" id="description_ar"
                                                  rows="5">{{$offer->description_ar}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-5 " style="margin: 0 auto">
                                    <div class="form-group">
                                        <label class="control-label" for="name">عدل تعليمات العرض</label>
                                        <textarea name="instructions_ar" class="form-control" id="instructions_ar"
                                                  rows="5">{{$offer->instructions_ar}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-1"></div>

                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 " style="margin: 0 auto">
                                    <div class="form-group">
                                        <label class="control-label" for="name">عدل سعر العرض قبل</label>
                                        <input type="number" class="form-control" required id="price_before"
                                               name="price_before"
                                               value="{{$offer->price_before}}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 " style="margin: 0 auto">
                                    <div class="form-group">
                                        <label class="control-label" for="name">عدل سعر العرض بعد</label>
                                        <input type="number" class="form-control" required id="price_after"
                                               name="price_after"
                                               value="{{$offer->price_after}}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 " style="margin: 0 auto">
                                    <div class="form-group">
                                        <button class="btn btn-outline-secondary">حفظ</button>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">


                            </div>

                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <img style="width: 350px;" src="{{asset('portal/assets/images/sample.jpg')}}" alt="">
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
        $(".offer_id").on("change", function (e) {
            var offer_id = $(this).val();
            $('.form-update').attr('action', '{{url('clinic/offers')}}/' + offer_id)
            $('.loader').removeClass('d-none');
            $.ajax({
                type: 'get',
                dataType: "json",
                url: '{{url('clinic/offers')}}/' + offer_id,
                data: '',
                cache: "false",
                success: function (data) {
                    $('.loader').addClass('d-none');
                    $('#name_ar').val(data.name_ar);
                    $('#description_ar').val(data.description_ar);
                    $('#instructions_ar').val(data.instructions_ar);
                    $('#price_before').val(data.price_before);
                    $('#price_after').val(data.price_after);
                    $('#section_id').val(data.section_id);
                }, error: function (data) {
                    $('.loader').addClass('d-none');
                }
            });
            return false;
        });

    </script>

@endsection
