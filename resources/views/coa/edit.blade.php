{{-- Modal Edit --}}
<form action="{{ route('coa.update', $data->id) }}" method="post">
    @csrf
    @method('PUT')
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
                <input type="text" class="form-control" id="kode" name="kode" value="{{ $data->kode }}" disabled>
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
</form>