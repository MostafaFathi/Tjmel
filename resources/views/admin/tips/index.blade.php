@extends('admin.layouts.app')

@section('content')

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">التلميحات</span></h4>
            </div>
            <div class="header-elements">
                <a type="button" class="btn btn-primary" href="{{route('tips.create')}}">جديد</a>
            </div>

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> الرئيسية</a>
                    <a href="{{route('tips.index')}}" class="breadcrumb-item">الإعلانات</a>

                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <!-- Basic table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>

                    <tr>

                        <th class="numeric" style="width: 10%">#</th>

                        <th class="">صورة التلميح</th>
                        <th class="">الحالة</th>
                        <th class="" style="width: 20%">التحكم</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($tips as $tip)

                        <tr @if(session('id') === $tip->id)class="bg-green" @endif>
                            <td>{{$loop->index + 1 }}</td>
                            <td>
                                @if($tip->image)
                                    <img src="{{FileStorage::getUrl($tip->image)}}" alt="img"
                                         style="width: 40px;border-radius: 5px;">
                                @else
                                    --
                                @endif
                            </td>
                            <td>
                                @if(count($tips)-1 == $loop->index)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-secondary">معطل</span>
                                @endif
                            </td>


                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">إتخذ
                                    اجراء</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                    <a class="dropdown-item " data-placement="top" title="Show"
                                       href="{{route('tips.show',$tip->id)}}"
                                    ><i class="icon-eye"></i>عرض</a>

                                    <a class="dropdown-item" data-placement="top" title="Delete"
                                       href="javascript:void(0)"
                                       onclick="delete_item('{{$tip->id}}','{{$tip->name}}')" data-toggle="modal"
                                       data-target="#delete_item_modal"><i class="icon-cross3"></i>حذف</a>

                                    <a class="dropdown-item" data-toggle="tooltip" data-placement="top" title="Edit"
                                       href="{{route('tips.edit',$tip->id)}}"><i class="icon-pencil7"></i>تعديل</a>

                                </div>


                            </td>

                        </tr>

                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        <!-- /basic table -->
        {{----}}
        <div id="delete_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete_form" method="post" action="">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input name="id" id="item_id" class="form-control" type="hidden">
                        <input name="_method" type="hidden" value="DELETE">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">حذف إعلان <span id="del_label_title"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4>تأكيد حذف الاعلان</h4>
                            <p id="grup_title"></p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-danger waves-effect" id="delete_url">حذف</button>
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
@endsection

@section('js_code')

    <script>

        function delete_item(id, title) {
            $('#item_id').val(id);
            var url = "{{url('admin/tips')}}/" + id;
            $('#delete_form').attr('action', url);
            $('#grup_title').text(title);
            $('#del_label_title').html(title);
        }


        $('#LinkNotModal').on('show.bs.modal', function (event) {

            //linking_url
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            var hash = button.data('hash') // Extract info from data-* attributes
            var url = button.attr('href') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('.modal-title').html('<b>' + title + '</b>')
            modal.find('.modal-footer .Delete-Action').attr('href', url)

            $('#linking_url').val('{{url('api/link_mobile')}}?user_id=' + hash);
            $('#url_span').text('{{url('api/link_mobile')}}?user_id=' + hash);

            console.log(hash);

        });

    </script>

@endsection

