@extends('layouts.app')
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">System Security</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">API</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" id="btnAdd" onclick="AddNew()"><i class="bx bx-plus"></i>Add</button>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">API Name</th>
                    <th class="text-center">Default Url</th>
                    <th class="text-center">API User</th>
                    <th class="text-center">API Key</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody id="bodyItem"></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="frmAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">API</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <input type="hidden" id="id" value="0" data-required="0">
                                <label>API Name <span class="text-danger">(*)</span></label>
                                <select class="form-select" id="api_id" onchange="SetUrl(this.id)">
                                    <option value="0">-- select --</option>
                                    @foreach($api_url as $item)
                                        <option value="{{$item->id}}" data-id="{{$item->url}}">{{$item->api_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>URL <span class="text-danger">(*)</span></label>
                                <input type="text" maxlength="255" class="form-control" id="api_url" data-required="1" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>API User<span class="text-danger">(*)</span></label>
                                <input type="text" maxlength="255" class="form-control" id="username" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>API Key<span class="text-danger">(*)</span></label>
                                <input type="text" maxlength="100" class="form-control" id="api_key" data-required="1" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="Save()"><i class="bx bxs-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function (){
            LoadData();
        })

        function SetUrl(url){
            var url_name = $("#api_id").find(':selected').data('id');
            $("#api_url").val(url_name);
        }
        function generateUUID() { // Public Domain/MIT
            var d = new Date().getTime();//Timestamp
            var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now()*1000)) || 0;//Time in microseconds since page-load or 0 if unsupported
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16;//random number between 0 and 16
                if(d > 0){//Use timestamp until depleted
                    r = (d + r)%16 | 0;
                    d = Math.floor(d/16);
                } else {//Use microseconds since page-load if supported
                    r = (d2 + r)%16 | 0;
                    d2 = Math.floor(d2/16);
                }
                return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });
        }
        function LoadData(){
            $("#bodyItem").html("");
            $.ajax({
                type:'GET',
                url:"{{ route('api.GetData') }}",
                data:{},
                success:function(data){
                    // console.log(data);
                    var item =data;
                    for (var i = 0; i < item.length; i++) {
                        var btnEdit ='<span class="text-primary" style="cursor: pointer;font-size: 24px" title="Edit" onclick="actionEdit('+item[i].id+','+item[i].api_id+',\''+item[i].url+'\',\''+item[i].username+'\',\''+item[i].api_key+'\',\''+item[i].deactivate+'\')"><i class="bx bx-edit"></i> </span>';
                        // var btnDelete ='<span class="text-danger" style="cursor: pointer;font-size: 24px" title="Delete" onclick="actionDelete('+item[i].id+')"><i class="bx bx-trash"></i></span>';

                        $("#bodyItem").append('<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            '<td class="text-left">'+item[i].api_name+'</td>'+
                            '<td class="text-left">'+item[i].url+'</td>'+
                            '<td class="text-center">'+item[i].username+'</td>'+
                            '<td class="text-center">'+item[i].api_key+'</td>'+
                            // '<td class="text-center">'+item[i].deactivate+'</td>'+
                            '<td class="text-center">'+btnEdit+'</td>'+
                            '</tr>');
                    }
                }
            });
        }
        function clearForm(){
            $('#frmAddNew input').each(function(){
                $(this).val('');
            });
            $('#frmAddNew select').each(function(){
                $(this).val(0);
            });
            $("#id").val(0);
        }
        function AddNew(){
            clearForm();
            $("#frmAddNew").modal("show");
            $("#api_key").val(generateUUID());
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#api_name').focus();
            })
        }
        function actionEdit(Id,api_id,default_url,user,key,deactivate){
            clearForm();
            $("#id").val(Id);
            $("#api_id").val(api_id);
            $("#api_url").val(default_url);
            $("#username").val(user);
            $("#api_key").val(key);
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#api_name').focus();
            })
            if(key == "null"){
                $("#api_key").val(generateUUID());
            }
        }
        function Save(){
            var id = $("#id").val();
            var api_id = $("#api_id").val();
            var username = $("#username").val();
            var api_key = $("#api_key").val();
            if(api_id == 0){
                MSG.Validation("Please select api name !!!");
            }
            else if(username == ""){
                MSG.Validation("Please input api user !!!");
            }
            else if(api_key == ""){
                MSG.Validation("Please input api key!!!");
            }

            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('api.Save') }}",
                    data:{
                        id: id,
                        api_id: api_id,
                        username: username,
                        api_key: api_key
                    },
                    success:function(result){
                        // console.log(result);
                        if(result.code == 0){
                            MSG.Success();
                            $("#frmAddNew").modal('hide');
                            LoadData();
                        }
                    }
                });
            }
        }

    </script>
@endsection
