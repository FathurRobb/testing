@extends('layout.template')

@section('title')
    Master Chart of Account
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title float-left mb-2">Chart Of Account</h4>
                    <button type="button" class="card-title float-md-right btn btn-info btn-sm border border-white" data-toggle="modal" data-target="#addModal" style="">
                        Tambah Data<i class="material-icons">add</i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table">
                            <thead class="text-info">
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Chart Of Account</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @forelse ($datas as $data)
                                    <tr>                                        
                                        <td>{{ $i }}</td>
                                        <td>{{ $data->kode }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->kategori->nama }}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editModal{{ $data->id }}">
                                                <i class="material-icons">edit</i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $data->id }}">
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
                <div class="mx-auto d-block">
                    {{ $datas->links() }}
                </div>
            </div>
            {{-- Modal Add --}}
            <form method="POST" action="{{ route('coa.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Chart Of Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group has-info">
                                <label for="kode">Kode</label>
                                <input type="number" class="form-control" id="kode" name="kode" required>
                                @if ($errors->has('kode'))
                                    <span class="text-danger">{{ $errors->first('kode') }}</span>
                                @endif
                            </div>
                            <div class="form-group has-info">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group has-info">
                                <label for="kategori">Kategori</label>
                                <select class="form-control" id="kategori_id" name="kategori_id" required>
                                    <option value="" selected disabled>--Pilih Kategori--</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info">Simpan</button>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
            {{-- Modal Edit --}}
            @foreach ($datas as $data)
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
            @endforeach
            {{-- Modal Delete --}}
            @foreach ($datas as $data)
                <form action="{{ route('coa.destroy', $data->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah anda yakin menghapus kategori <b>{{ $data->nama }}</b> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-info">Ya</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
@endsection