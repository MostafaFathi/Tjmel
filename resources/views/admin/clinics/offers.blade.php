
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


                    @foreach($clinic->offers as $offer)

                        <tr @if(session('id') === $offer->id)class="bg-green" @endif>
                            <td>{{$offer->id}}</td>
                            <td>{{$offer->name_ar}}</td>
                            <td>{{$offer->section->title_ar ?? '--'}}</td>
                            <td>
                            <div style="text-decoration: line-through;color: #9E9E9E;">before:{{$offer->price_before ?? '--'}}</div>
                            <div class="font-weight-bold">after:{{$offer->price_after ?? '--'}}</div>

                            </td>
                            <td><span class="badge badge-{{$offer->status_color}}">{{$offer->status_name}}</span></td>
                            <td>
                                <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Take
                                    action</a>

                                <div class="dropdown-menu dropdown-menu-lg">
                                <a class="dropdown-item " data-placement="top" title="Show"
                                   href="{{route('admin.offers.show',$offer->id)}}"
                                  ><i class="icon-eye"></i>Show</a>

                                <a class="dropdown-item" data-placement="top" title="{{$offer->status == 0 or $offer->status == 2 ? 'Approve' : 'Reject'}}" href="javascript:void(0)"
                                   onclick="approve_item_offer('{{$offer->id}}','{{$offer->name}}')" data-toggle="modal"
                                   data-target="#delete_item_modal_offer"><i class="{{$offer->status == 0 || $offer->status == 2 ? 'icon-check2' : 'icon-cross3'}} "></i>{{$offer->status == 0 || $offer->status == 2 ? 'Approve' : 'Reject'}}</a>

                                </div>



                            </td>

                        </tr>

                    @endforeach
                    @if(count($clinic->offers) == 0)
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
        <div id="delete_item_modal_offer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="delete_form_offer" method="post" action="">
                        @csrf
                        <input name="id" id="item_id" class="form-control" type="hidden">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Approve/Reject offer <span id="del_label_title"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <h4>Confirm Approve/Reject offer</h4>
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


        <!-- /.modal-dialog -->




