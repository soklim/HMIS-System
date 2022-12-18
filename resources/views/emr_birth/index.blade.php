@extends('layouts.app')
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Transactions</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Birth Notification</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('emr_birth.create')}}">
                <button type="button" class="btn btn-primary" id="btnAdd"><i class="bx bx-plus"></i>Add</button>
            </a>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-12">
            <table class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="tblUser">
                    <tr>
                        <th class="text-center">ល.រ</th>
                        <th class="text-left">មូលដ្ឋានសុខាភិបាល</th>
                        <th class="text-center">លេខឯកសារពេទ្យ</th>
                        <th class="text-left">ឈ្មោះទារក</th>
                        <th class="text-center">ព័ត៌មានកំណើត</th>
                        <th class="text-center">ប្រភេទកំណើត</th>
                        <th class="text-center">ភេទ</th>
                        <th class="text-center">ថ្ងៃខែឆ្នាំកំណើត</th>
                        <th class="text-center"></th>
                    </tr>
                    <tbody id="bodyDeath">
                    @foreach($data as $item)
                        <tr>
                            <td class="text-center">{{$item->birth_no}}</td>
                            <td class="text-left">{{$item->hfac_label}}</td>
                            <td class="text-center">{{$item->medicalid}}</td>
                            <td class="text-left">{{$item->babyname}}</td>
                            <td class="text-center">{{$item->birth_info}}</td>
                            <td class="text-center">{{$item->birth_type}}</td>
                            <td class="text-center">{{$item->sex}}</td>
                            <td class="text-center">{{$item->dateofbirth}} | {{$item->time_of_birth}}</td>
                            <td class="text-center">
                                <a href="{{ route('emr_birth.edit', $item->bid) }}" class="text-primary" style="font-size:24px" title="Edit"><i class="bx bx-edit"></i></a>
                                <a href="{{ route('emr_birth.show', $item->bid) }}" class="text-warning" target="_blank" style="font-size:24px"><i class="bx bx-printer"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var emailList=[];
        var prevEmail ="";
        $(document).ready(function (){
            $(".datefield").pickadate({
                selectMonths: true,
                selectYears: true,
                format: 'yyyy-mm-dd',
                hiddenName: true
            });

            $('.timefield').bootstrapMaterialDatePicker({
                date: false,
                format: 'HH:mm'
            });


        })

    </script>
@endsection
