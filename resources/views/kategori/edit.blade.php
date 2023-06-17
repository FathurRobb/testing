{{-- Modal Edit --}}
<form action="{{ route('kategori.update', $data->id) }}" method="post">
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
                <label for="nama">Kategori</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{$data->nama}}">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-info">Perbaharui Data</button>
        </div>
    </div>
</form>