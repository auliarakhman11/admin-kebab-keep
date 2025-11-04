@extends('template.master')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-12">
                        <h2 class="float-left">User Kasir</h2>
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal"
                            data-target="#add-user">
                            <i class="fa fa-plus-circle"></i>
                            Tambah User
                        </button>
                        {{-- <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a>
                            </li>
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Analytical</li>
                        </ul> --}}
                    </div>
                    {{-- <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <button type="button" class="btn btn-primary"><i class="fa fa-download"></i>
                                    Download report</button>
                                <button type="button" class="btn btn-secondary"><i class="fa fa-send"></i> Send
                                    report</button>
                            </div>
                            <div class="p-2 d-flex">

                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="row justify-content-center clearfix row-deck">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table js-basic-example dataTable table-custom" id="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Outlet</th>
                                    <th>Edit Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($user_kasir as $u)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->username }}</td>
                                        <td>{{ $u->cabang_id != 0 ? $u->cabang->nama : '' }}</td>
                                        <td><button type="button" data-toggle="modal" data-target="#modal_edit_password"
                                                akun_id="{{ $u->id }}"
                                                class="btn btn-sm btn-primary btn_edit_password"><i
                                                    class="fa fa-edit"></i></button></td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <form action="{{ route('addUserKasir') }}" method="post">
        @csrf
        <div class="modal fade" id="add-user" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukan nama"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukan username"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukan password"
                                    required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Ulangi password" required>
                            </div>

                            <div class="col-12">
                                <label>Outlet</label>
                                <select name="cabang_id" class="form-control select2bs4" required>
                                    <option value="">-Pilih Outlet-</option>
                                    @foreach ($outlet as $o)
                                        <option value="{{ $o->id }}">{{ $o->nama }}</option>
                                    @endforeach
                                </select>
                            </div>



                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('editPasswordKasir') }}" method="post">
        @csrf
        <div class="modal fade" id="modal_edit_password" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">

                            <input type="hidden" name="id" id="akun_id">


                            <div class="col-12">
                                <label>Password Baru</label>
                                <input type="text" name="password" class="form-control" placeholder="Masukan password"
                                    required>
                            </div>





                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@section('script')
    <script>
        $(document).ready(function() {

            <?php if(session('success')): ?>
            // notification popup
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.showDuration = 1000;
            toastr['success']('<?= session('success') ?>');
            <?php endif; ?>

            <?php if(session('error')): ?>
            // notification popup
            toastr.options.closeButton = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.options.showDuration = 1000;
            toastr['error']('<?= session('error') ?>');
            <?php endif; ?>


        });
    </script>
@endsection
@endsection
