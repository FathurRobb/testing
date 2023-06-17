@push('js')
    <script>
        $('#debit').keyup(function(event) {

        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
        
        $('#credit').keyup(function(event) {

        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
    </script>
@endpush
@extends('layout.template')

@section('title')
    Transaksi
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Edit Transaksi</h4>
                </div>
                <div class="card-body">
                     <form method="POST" action="{{ route('transaksi.update', $data->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-info">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $data->tanggal }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-info">
                                    <select class="form-control" id="chart_of_account_id" name="chart_of_account_id" required>
                                        @foreach ($coas as $coa)
                                            <option value="{{ $coa->id }}" {{ $coa->id == $data->chart_of_account_id ? 'selected' : '' }}>{{ $coa->kode .' - '. $coa->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-info">
                                    <label for="debit">Debit</label>
                                    <input type="text" class="form-control" id="debit" name="debit" value="{{ $data->debit }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-info">
                                    <label for="credit">Credit</label>
                                    <input type="text" class="form-control" id="credit" name="credit" value="{{ $data->credit }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-info">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ $data->deskripsi }}</textarea>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('transaksi.index') }}"  class="btn btn-default float-left">Kembali</a>
                        <button type="submit" class="btn btn-info float-right">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
