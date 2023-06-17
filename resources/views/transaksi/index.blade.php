@extends('layout.template')

@section('title')
    Transaksi
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title float-left mb-2">Transaksi</h4>
                    <a href="{{ route('transaksi.create') }}" type="button" class="card-title float-md-right btn btn-info btn-sm border border-white">
                        Tambah Data<i class="material-icons">add</i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="example">
                            <thead class="text-info">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>COA Kode</th>
                                <th>COA Nama</th>
                                <th>Desc</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @forelse ($datas as $data)
                                    <tr>                                        
                                        <td>{{ $i }}</td>
                                        <td>{{ date('d F Y', strtotime($data->tanggal)) }}</td>
                                        <td>{{ $data->chart_of_account->kode }}</td>
                                        <td>{{ $data->chart_of_account->nama }}</td>
                                        <td>{{ $data->deskripsi }}</td>
                                        <td>@currency($data->debit)</td>
                                        <td>  
                                            @if ($data->credit)
                                                @currency($data->credit)
                                            @else
                                                
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('transaksi.edit', $data->id) }}" type="button" class="btn btn-outline-success btn-sm">
                                                <i class="material-icons">edit</i>
                                            </a>

                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-url="{{ route('transaksi.destroy', $data->id) }}" data-transaksitanggal="{{ $data->tanggal }}">
                                                <i class="material-icons">delete</i>
                                            </button>                                 
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @empty
                                    <tr>
                                        <td colspan="3">Data Chart Of Account Belum Tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Modal Edit --}}
            {{-- @foreach ($datas as $data)
            <form action="{{ route('coa.update', $data->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Form Edit Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group has-info">
                                    <label for="kode">Kode</label>
                                    <input type="number" class="form-control" id="kode" name="kode" value="{{ $data->kode }}">
                                </div>
                                <div class="form-group has-info">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}">
                                </div>
                                <div class="form-group has-info">
                                    <label for="kategori">Kategori</label>
                                    <select class="form-control" id="kategori_id" name="kategori_id">
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ $kategori->id == $data->kategori_id ? 'selected': ''}}>{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-info">Perbaharui Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endforeach --}}
            <form action="" method="post" id="delete-form">
                @csrf
                @method('DELETE')
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah anda yakin menghapus data transaksi ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-info">Ya</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
        $('#deleteModal').on('show.bs.modal', function (event) {
            let url = $(event.relatedTarget).data('url') 
            document.getElementById("delete-form").setAttribute('action', url);
        });
    </script>
@endpush