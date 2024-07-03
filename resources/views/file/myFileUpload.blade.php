@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-4">
                    <form method="post" action="{{ url('/my-file/upload-proses') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <?php $jenis_file = array(
                                [
                                    "jenis_file" => "Absensi"
                                ],
                                [
                                    "jenis_file" => "Database Karyawan"
                                ],
                                [
                                    "jenis_file" => "Penilaian Kinerja"
                                ],
                                [
                                    "jenis_file" => "Perhitungan Cuti"
                                ],
                                [
                                    "jenis_file" => "KPI Departemen Satu Dashboard"
                                ],
                                [
                                    "jenis_file" => "Data Audit"
                                ],
                                [
                                    "jenis_file" => "Form Peralatan, Cuti, Pinjam Uang, Perbaikannya Mesin, Lemburan, Berita Acara, Kaizen"
                                ],
                                [
                                    "jenis_file" => "Perhitungan Payrol Kit"
                                ],
                                [
                                    "jenis_file" => "Kontrak Kerja"
                                ],
                                [
                                    "jenis_file" => "Jadwal Produksi"
                                ],
                                [
                                    "jenis_file" => "Recruitment"
                                ],
                                [
                                    "jenis_file" => "Penilain Karyawan"
                                ],
                                [
                                    "jenis_file" => "Resume Meeting"
                                ],
                                [
                                    "jenis_file" => "Data Laporan Harian Bulanan Karyawan"
                                ],
                                [
                                    "jenis_file" => "SOP Karyawan"
                                ]);
                                ?>
                                <label for="jenis_file" class="float-left">Jenis File</label>
                                <select name="jenis_file" id="jenis_file" class="form-control selectpicker" data-live-search="true">
                                    <option value="">Pilih Jenis File</option>
                                    @foreach ($jenis_file as $jf)
                                        @if(old('jenis_file') == $jf["jenis_file"])
                                        <option value="{{ $jf["jenis_file"] }}" selected>{{ $jf["jenis_file"] }}</option>
                                        @else
                                        <option value="{{ $jf["jenis_file"] }}">{{ $jf["jenis_file"] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('jenis_file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fileUpload" class="float-left">File</label>
                                <input class="form-control @error('fileUpload') is-invalid @enderror" type="file" id="fileUpload" name="fileUpload">
                                <span class="float-left font-italic form-control-sm">File yang di perbolehkan doc,docx,pdf,xls,xlsx,ppt,pptx dan Max Size 10 MB</span>
                                @error('fileUpload')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                      </form>
                </div>
            </div>
        </center>
    </div>
    <br>
@endsection
