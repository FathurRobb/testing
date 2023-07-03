{{-- Modal Edit --}}
<form id="editForm">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <span hidden id="id-update">{{$data->id}}</span>
            <div class="form-group has-info">
                <label for="kode">Kode</label>
                <input type="text" class="form-control" id="kode" name="kode" value="{{ $data->kode }}">
                <span class="text-danger d-none" id="kode-message-update"></span>
            </div>
            <div class="form-group has-info">
                <label for="nama" style="color: #00bcd4">Nama</label>
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
            <button type="submit" class="btn btn-info" id="editBtn">Perbaharui Data</button>
        </div>
    </div>
</form>

<script>
    toastr.options.timeout = 10000;
    $('#editBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Updating...');
        let coaId = $("#id-update").html();

        $.ajax({
            data: $('#editForm').serialize(),
            url: 'coa/'+coaId,
            type: "PUT",
            dataType: 'json',
            success: function (data) {
                $('#kode-message-update').addClass("d-none");
                $('#editModal').modal("hide");
                // $('.data-table').DataTable({
                //     destroy: true,
                //     processing: true,
                //     serverSide: true,
                //     ajax: "{{ route('coa.index') }}",
                //     columns: [
                //         {data: 'DT_RowIndex'},
                //         {data: 'kode' },
                //         {data: 'nama' },
                //         {data: 'kategori.nama'},
                //         {data: 'action', orderable: false, searchable: false},
                //     ]
                // }).draw();
                window.location = "{{ route('coa.index') }}";
                toastr.success(data.success);
            },
            error: function (data) {
                if (data.responseJSON.errors.kode) {
                    document.getElementById("kode-message-update").classList.remove("d-none")
                    document.getElementById("kode-message-update").innerHTML = data.responseJSON.errors.kode;  
                }
                toastr.error(data.responseJSON.message);
                $('#editBtn').html('Save Changes');
            }
        });
    });
</script>