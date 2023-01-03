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
                <li class="breadcrumb-item active" aria-current="page">MCCD Notification</li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        @if($permission->a_create == 1)
            <a href="{{route('mccd.create')}}" type="button" class="btn btn-primary" id="btnAdd"><i class="bx bx-plus"></i>បន្ថែម</a>
        @endif
    </div>
</div>
<!--end breadcrumb-->
@endsection
