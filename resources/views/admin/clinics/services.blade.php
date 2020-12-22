
            <div class="table-responsive">
                <table class="table">
                    <thead>

                    <tr>

                        <th class="numeric">id</th>
                        <th class="">Name</th>
                        <th class="">Section</th>
                        <th class="">Price</th>
                        <th class="">Status</th>
                        <th class="">Control</th>

                    </tr>

                    </thead>

                    <tbody>


                    @foreach($clinic->services as $service)

                        <tr @if(session('id') === $service->id)class="bg-green" @endif>
                            <td>{{$service->id}}</td>
                            <td>{{$service->name_ar}}</td>
                            <td>{{$service->section->title_ar ?? '--'}}</td>
                            <td>{{$service->price ?? '--'}}</td>
                            <td><span class="badge badge-{{$service->status_color}}">{{$service->status_name}}</span></td>
                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Take
                                    action</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                <a class="dropdown-item " data-placement="top" title="Show"
                                   href="{{route('admin.services.show',$service->id)}}"
                                  ><i class="icon-eye"></i>Show</a>

                                <a class="dropdown-item" data-placement="top" title="{{$service->status == 0 || $service->status == 2 ? 'Approve' : 'Reject'}}" href="javascript:void(0)"
                                   onclick="approve_item('{{$service->id}}','{{$service->name}}')" data-toggle="modal"
                                   data-target="#delete_item_modal"><i class="{{$service->status == 0 || $service->status == 2 ? 'icon-check2' : 'icon-cross3'}} "></i>{{$service->status == 0 || $service->status == 2 ? 'Approve' : 'Reject'}}</a>

                                </div>



                            </td>

                        </tr>

                    @endforeach
                    @if(count($clinic->services) == 0)
                        <tr>
                            <td colspan="6" class="text-center">
                                There is no rows
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

        <!-- /basic table -->
        {{----}}
        <div id="delete_item_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete_form" method="post" action="">
                        @csrf
                        <input name="id" id="item_id" class="form-control" type="hidden">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Approve/Reject service <span id="del_label_title"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4>Confirm Approve/Reject service</h4>
                            <p id="grup_title"></p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success waves-effect" id="delete_url">Save New Status</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->



        </div>


