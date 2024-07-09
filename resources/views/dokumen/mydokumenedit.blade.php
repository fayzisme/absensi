@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-4">
                    <form method="post" action="{{ url('/my-dokumen/edit-proses/'.$data_dokumen->id) }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                            <div class="form-group">
                                <label for="nama_dokumen" class="float-left">Nama Pegawai</label>
                                <input type="text" name="nama_dokumen" value="{{ old('nama_dokumen', $data_dokumen->nama_dokumen) }}" class="form-control @error('nama_dokumen') is-invalid @enderror" id="nama_dokumen">
                                @error('nama_dokumen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal_berakhir" class="float-left">Tanggal Upload</label>
                                <input type="datetime" class="form-control @error('tanggal_berakhir') is-invalid @enderror" id="tanggal_berakhir" name="tanggal_berakhir" disabled autofocus value="{{ old('tanggal_berakhir', $data_dokumen->tanggal_berakhir) }}">
                                @error('tanggal_berakhir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="file" class="float-left">Dokumen</label>
                                <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file">
                                <span class="float-left font-italic form-control-sm">File yang di perbolehkan doc,docx,pdf,xls,xlsx,ppt,pptx dan Max Size 10 MB</span>
                                @error('file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <input type="hidden" name="file_lama" value="{{ $data_dokumen->file }}">
                            </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </form>
                </div>
            </div>
        </center>
    </div>
    <br>
@endsection
