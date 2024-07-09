@extends('templates.app')
@section('container')
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="inner-left d-flex justify-content-between align-items-center">
                        @if(auth()->user()->foto_karyawan == null)
                            <img src="{{ url('assets/img/foto_default.jpg') }}" alt="image">
                        @else
                            <img src="{{ url('/storage/'.auth()->user()->foto_karyawan) }}" alt="image">
                        @endif
                        <p class="fw_7 on_surface_color">{{ auth()->user()->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tf-spacing-20"></div>
    <div class="transfer-content">
        <form class="tf-form" action="{{ url('/my-profile/update/'.auth()->user()->id) }}" enctype="multipart/form-data" method="POST">
            @method('PUT')
            @csrf
            <div class="tf-container">
                <h3>Informasi Pegawai</h3>
                <br>
                <div class="group-input">
                    <label>Nama Pegawai</label>
                    <input type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name', auth()->user()->name) }}" />
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="group-input input-group">
                    <input type="file" class="form-control @error('foto_karyawan') is-invalid @enderror" name="foto_karyawan" />
                    <span class="input-group-text" id="basic-addon2">Foto</span>
                    @error('foto_karyawan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <input type="hidden" name="foto_karyawan_lama" value="{{ auth()->user()->foto_karyawan }}">
                </div>
                <div class="group-input">
                    <label>Email</label>
                    <input type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email', auth()->user()->email) }}" />
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="group-input">
                    <label>Telepon</label>
                    <input type="text" class="@error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon', auth()->user()->telepon) }}" />
                    @error('telepon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="group-input">
                    <label>Username</label>
                    <input type="text" class="@error('username') is-invalid @enderror" name="username" value="{{ old('username', auth()->user()->username) }}" />
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="group-input">
                    <label>Roles</label>
                    <input type="text" class="@error('is_admin') is-invalid @enderror" name="is_admin" value="{{ auth()->user()->Role->nama_role }}" readonly />
                    @error('is_admin')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <input type="hidden" name="password" value="{{ auth()->user()->password }}">
                </div>
                <div class="group-input">
                    <label>Tanggal Lahir</label>
                    <input type="datetime" class="@error('tgl_lahir') is-invalid @enderror" name="tgl_lahir" value="{{ old('tgl_lahir', auth()->user()->tgl_lahir) }}" />
                    @error('tgl_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="group-input">
                    <label>Tanggal Masuk Perusahaan</label>
                    <input type="datetime" class="@error('tgl_join') is-invalid @enderror" name="tgl_join" value="{{ old('tgl_join', auth()->user()->tgl_join) }}" />
                    @error('tgl_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="group-input">
                    @php
                        $gender = array(
                            [
                                "gender" => "L"
                            ],
                            [
                                "gender" => "P"
                            ]
                        );
                    @endphp
                    <label style="z-index: 1000">Gender</label>
                    <select name="gender" id="gender" class="form-select">
                        <option value="">- - Pilih - -</option>
                        @foreach ($gender as $g)
                            @if(old('gender', auth()->user()->gender) == $g["gender"])
                                <option value="{{ $g["gender"] }}" selected>{{ $g["gender"] }}</option>
                            @else
                                <option value="{{ $g["gender"] }}">{{ $g["gender"] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('tgl_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="group-input">
                    @php
                        $status_nikah = array(
                            [
                                "status_nikah" => "menikah"
                            ],
                            [
                                "status_nikah" => "jomblo"
                            ]
                        );
                    @endphp
                    <label style="z-index: 1000">Status Nikah</label>
                    <select name="status_nikah" id="status_nikah" class="form-select">
                        <option value="">- - Pilih - -</option>
                        @foreach ($status_nikah as $sn)
                            @if(old('status_nikah', auth()->user()->status_nikah) == $sn["status_nikah"])
                                <option value="{{ $sn["status_nikah"] }}" selected>{{ $sn["status_nikah"] }}</option>
                            @else
                                <option value="{{ $sn["status_nikah"] }}">{{ $sn["status_nikah"] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('tgl_lahir')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="group-input">
                    <label>Alamat</label>
                    <textarea name="alamat" class="@error('alamat') is-invalid @enderror">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="tf-btn accent large">Save</button>
            </div>
            <br>
            <br>
            <br>
            <br>
        </form>
    </div>
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script>
            $('.money').mask('000,000,000,000,000', {
                reverse: true
            });
            $('#gender').select2();
            $('#status_nikah').select2();
        </script>
    @endpush
@endsection