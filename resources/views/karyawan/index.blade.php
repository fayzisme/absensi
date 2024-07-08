@extends('templates.dashboard')
@section('isi')
    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 mt-2 p-0 d-flex">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="col-md-6 p-0">                    
                        <a href="{{ url('/pegawai/tambah-pegawai') }}" class="btn btn-primary btn-sm ms-2">+ Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <form action="{{ url('/pegawai') }}">
                        <div class="row mb-2">
                            <div class="col-2">
                                <input type="text" placeholder="Search...." class="form-control" value="{{ request('search') }}" name="search">
                            </div>
                            <div class="col">
                                <button type="submit" id="search"class="border-0 mt-3" style="background-color: transparent;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="mytable">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_user as $du)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $du->name }}</td>
                                        <td>{{ $du->username }}</td>
                                        <td>{{ $du->Role->nama_role ?? '-' }}</td>
                                        <td>
                                            <ul class="action"> 
                                                <li class="edit me-2"><a href="{{ url('/pegawai/detail/'.$du->id) }}" title="Edit Pegawai"><i class="icon-pencil-alt"></i></a></li>

                                                <li class="me-2"><a href="{{ url('/pegawai/edit-password/'.$du->id) }}" title="Ganti Password"><i class="fa fa-solid fa-key" style="color: rgb(11, 18, 222)"></i></a></li>

                                                <li class="me-2"> <a href="{{ url('/pegawai/shift/'.$du->id) }}" title="Input Shift Pegawai"><i style="color:coral" class="fa fa-solid fa-clock"></i></a></li>

                                                <li class="delete">
                                                    <form action="{{ url('/pegawai/delete/'.$du->id) }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button title="Delete Pegawai" class="border-0" style="background-color: transparent;" onClick="return confirm('Are You Sure')"><i class="icon-trash"></i></button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end me-4 mt-4">
                        {{ $data_user->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




