<a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">إتخذ
    اجراء</a>

<div class="dropdown-menu dropdown-menu-lg">
    <a class="dropdown-item " data-placement="top" title="Show"
       href="{{route('clinics.show',$clinic->id)}}"
    ><i class="icon-eye"></i>عرض</a>

    <a class="dropdown-item" data-placement="top" title="حذف" href="javascript:void(0)"
       onclick="delete_item('{{$clinic->id}}','{{$clinic->name}}')" data-toggle="modal"
       data-target="#delete_item_modal"><i class="icon-cross3"></i>حذف</a>

    <a class="dropdown-item" data-toggle="tooltip" data-placement="top" title="تعديل"
       href="{{route('clinics.edit',$clinic->id)}}"><i
            class="icon-pencil7"></i>تعديل</a>

</div>
