@extends('admin.layouts.app')

@section('content')
    <link href="{{asset('js/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .ms-container {
            width: 40% !important;
        }
    </style>
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><span class="font-weight-semibold">Create </span></h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>


        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <a href="{{route('users.index')}}" class="breadcrumb-item">Users</a>
                    <span class="breadcrumb-item active">Create</span>
                </div>

            </div>


        </div>
    </div>
    <!-- /page header -->


    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">User Details</h5>

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


                <form class="rated" action="{{route('users.store')}}" method="post"
                      enctype="multipart/form-data">


                    {{csrf_field()}}
                    <div class="row">

                        <div class="col-5 ">

                            <div class="form-group">
                                <label class="control-label" for="name">Name (AR)</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" value="">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="name">Name (EN)</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" value="">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="name">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                       value="">
                            </div>



                        </div>


                        <div class="col-5 offset-md-1">
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                       value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Role</label>


                                <select required class="form-control" type="text"
                                        name="user_group" id="permissions">

                                    @foreach($roles as $users_group)
                                        <option value="{{$users_group->id}}">{{$users_group->name}}</option>
                                    @endforeach
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>


                        </div>
                    </div>

                    <div class="row d-none permissions_div">
                        <div class="col-12">


                            <div class="form-group">
                                <label class="control-label">صلاحيات المستخدم</label>
                                <select class="form-control"
                                        name="permissions[]" id="user_permissions" multiple>
                                    @foreach($permissions as $permission)
                                        <option value="{{$permission->id}}" >{{$permission->name}}</option>
                                    @endforeach
                                </select>
                                <small class="form-control-feedback"></small>
                            </div>

                            <div class="button-box m-t-20 m-b-20">
                                <a id="select-all" class="btn btn-danger" href="javascript:void(0)">Select all</a>
                                <a id="deselect-all" class="btn btn-info" href="javascript:void(0)">De-select all</a>

                            </div>

                        </div>

                    </div>
                    <div class="form-group pt-3">

                        <button class="btn btn-success">Save</button>

                    </div>

                </form>
            </div>
        </div>


    </div>
@endsection
@section('js_assets')

    <script type="text/javascript"
            src="{{asset('js/multiselect/js/jquery.multi-select.js')}}"></script>
    <script>
        $(document).on('change', '#permissions', function () {
            if ($(this).val() == 3) {
                $('.permissions_div').removeClass('d-none');
            }else{
                $('.permissions_div').addClass('d-none');
            }
            return false;
        });
        $('#permissions').change();
        $('#user_permissions').multiSelect();

        $('#select-all').click(function () {
            $('#user_permissions').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function () {
            $('#user_permissions').multiSelect('deselect_all');
            return false;
        });
        $('#refresh').on('click', function () {
            $('#user_permissions').multiSelect('refresh');
            return false;
        });
    </script>

@endsection
