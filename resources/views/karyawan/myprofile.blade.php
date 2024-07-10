@extends('templates.dashboard')
@section('isi')
    <div class="row">
        <div class="col-md-12 m project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 p-0 d-flex mt-2">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="col-md-6 p-0">                    
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if(auth()->user()->foto_karyawan == null)
                            <img class="profile-user-img img-fluid img-circle" src="{{ url('assets/img/foto_default.jpg') }}" alt="User profile picture">
                        @else
                            <img class="profile-user-img img-fluid img-circle" src="{{ url('storage/'.auth()->user()->foto_karyawan) }}" alt="User profile picture">
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                        <b>Email</b> <a class="float-end" style="color: black">{{ auth()->user()->email }}</a>
                        </li>
                        <li class="list-group-item">
                        <b>Username</b> <a class="float-end" style="color: black">{{ auth()->user()->username }}</a>
                        </li>
                        <li class="list-group-item">
                        <b>Telepon</b> <a class="float-end" style="color: black">{{ auth()->user()->telepon }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <form method="post" action="{{ url('/my-profile/update/'.auth()->user()->id) }}" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="form-row">
                                    <div class="col mb-4">
                                        <label for="name">Nama Pegawai</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old('name', auth()->user()->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-4">
                                        <label for="foto_karyawan" class="form-label">Foto Karyawan</label>
                                        <input class="form-control @error('foto_karyawan') is-invalid @enderror" type="file" id="foto_karyawan" name="foto_karyawan">
                                        @error('foto_karyawan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="foto_karyawan_lama" value="{{ auth()->user()->foto_karyawan }}">
                                </div>
                                <div class="form-row">
                                    <div class="col mb-4">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-4">
                                        <label for="telepon">Nomor Telfon</label>
                                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', auth()->user()->telepon) }}">
                                        @error('telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col mb-4">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', auth()->user()->username) }}">
                                        @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-4">
                                        <label for="is_admin">Level User</label>
                                        <input type="text" id="is_admin" value="{{ auth()->user()->Role->nama_role }}" class="form-control" disabled>
                                    </div>
                                    <input type="hidden" name="password" value="{{ auth()->user()->password }}">
                                </div>
                                <div class="form-row">
                                    <div class="col mb-4">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <input type="datetime" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', auth()->user()->tgl_lahir) }}">
                                        @error('tgl_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-4">
                                        <?php $gender = array(
                                        [
                                            "gender" => "L"
                                        ],
                                        [
                                            "gender" => "P"
                                        ]);
                                        ?>
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror selectpicker" data-live-search="true">
                                            @foreach ($gender as $g)
                                                @if(old('gender', auth()->user()->gender) == $g["gender"])
                                                <option value="{{ $g["gender"] }}" selected>{{ $g["gender"] == 'L' ? 'Laki-laki' : 'Perempuan' }}</option>
                                                @else
                                                <option value="{{ $g["gender"] }}">{{ $g["gender"] == 'L' ? 'Laki-laki' : 'Perempuan' }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col mb-4">
                                        <label for="tgl_join">Tanggal Masuk Perusahaan</label>
                                        <input type="datetime" class="form-control @error('tgl_join') is-invalid @enderror" id="tgl_join" name="tgl_join" value="{{ old('tgl_join', auth()->user()->tgl_join) }}">
                                        @error('tgl_join')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-4">
                                        <?php $sNikah = array(
                                        [
                                            "status" => "menikah"
                                        ],
                                        [
                                            "status" => "jomblo"
                                        ]);
                                        ?>
                                        <label for="status_nikah">Status Nikah</label>
                                        <select name="status_nikah" id="status_nikah" class="form-control @error('status_nikah') is-invalid @enderror selectpicker" data-live-search="true">
                                            @foreach ($sNikah as $s)
                                            @if(old('status_nikah', auth()->user()->status_nikah) == $s["status"])
                                            
                                            <option value="{{ $s["status"] }}" selected>{{ ucfirst($s["status"]) }}</option>
                                            @else
                                            <option value="{{ $s["status"] }}">{{ ucfirst($s["status"]) }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('status_nikah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col mb-4">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                                        @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.money').mask('000,000,000,000,000', {
                    reverse: true
                });
            });
        </script>
    @endpush
@endsection
