@extends('layouts.app')
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">System Setting</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Setting Items</li>
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
                    <th class="text-center">Type Name</th>
                    <th class="text-center">Item ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Name KH</th>
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
                    <h5 class="modal-title">Module</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Type <span class="text-danger">(*)</span></label>
                                <select class="form-select" id="txtTypeID">
                                    <option value="0">-- select --</option>
                                    @foreach($setting_type as $item)
                                        <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <input type="hidden" id="txtId" value="0" data-required="0">
                                <label>Item ID <span class="text-danger">(*)</span></label>
                                <input type="number" class="form-control" id="txtItemID" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Name <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="txtName" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Name KH<span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="txtNameKH" data-required="1">
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
        function LoadData(){
            $("#bodyItem").html("");
            $.ajax({
                type:'GET',
                url:"{{ route('setting_items.GetData') }}",
                data:{},
                success:function(data){
                    // console.log(data);
                    var item =data;
                    for (var i = 0; i < item.length; i++) {
                        var btnEdit ='<span class="text-primary" style="cursor: pointer;font-size: 24px" title="Edit" onclick="actionEdit('+item[i].id+',\''+item[i].name+'\',\''+item[i].name_kh+'\','+item[i].type_id+','+item[i].item_id+')"><i class="bx bx-edit"></i> </span>';
                        var btnDelete ='<span class="text-danger" style="cursor: pointer;font-size: 24px" title="Delete" onclick="actionDelete('+item[i].id+')"><i class="bx bx-trash"></i></span>';

                        $("#bodyItem").append('<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            '<td class="text-left">'+item[i].type_name+'</td>'+
                            '<td class="text-left">'+item[i].item_id+'</td>'+
                            '<td class="text-left">'+item[i].name+'</td>'+
                            '<td class="text-center">'+item[i].name_kh+'</td>'+
                            '<td class="text-center">'+btnEdit+btnDelete+'</td>'+
                            '</tr>');
                    }
                }
            });
        }
        function clearForm(){
            $('#frmAddNew input').each(function(){
                $(this).val('');
            });
            $("#txtId").val(0);
        }
        function AddNew(){
            clearForm();
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#txtName').focus();
            })
        }
        function actionEdit(Id,Name,NameKH,TypeID,ItemID){
            clearForm();
            $("#txtId").val(Id);
            $("#txtName").val(Name);
            $("#txtNameKH").val(NameKH);
            $("#txtTypeID").val(TypeID);
            $("#txtItemID").val(ItemID);
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#txtName').focus();
            })
        }
        function Save(){
            var Id = $("#txtId").val();
            var ItemId = $("#txtItemID").val();
            var Name = $("#txtName").val();
            var NameKH = $("#txtNameKH").val();
            var TypeId = $("#txtTypeID").val();
            if(TypeId == 0){
                MSG.Validation("Please select type !!!");
            }
            else if(ItemId == ""){
                MSG.Validation("Please input item id !!!");
            }
            else if(Name == ""){
                MSG.Validation("Please input name !!!");
            }
            else if(NameKH == ""){
                MSG.Validation("Please input name kh!!!");
            }

            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('setting_items.Save') }}",
                    data:{
                        id: Id,
                        type_id: TypeId,
                        item_id: ItemId,
                        name: Name,
                        name_kh: NameKH
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
