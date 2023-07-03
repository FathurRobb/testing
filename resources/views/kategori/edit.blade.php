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
                <label for="nama" style="color: #00bcd4">Kategori</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{$data->nama}}">
            </div>
            <div class="form-group has-info">
                <label for="nama">Type</label>
                <select class="form-control" name="type" required>
                    <option value="0" {{$data->type === 0 ? 'selected': ''}}>Outcome</option>
                    <option value="1" {{$data->type === 1 ? 'selected': ''}}>Income</option>
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
        let kategoriId = $("#id-update").html();

        $.ajax({
            data: $('#editForm').serialize(),
            url: 'kategori/'+kategoriId,
            type: "PUT",
            dataType: 'json',
            success: function (data) {
                $('#editModal').modal("hide");
                // $('.data-table').DataTable({
                //     destroy: true,
                //     processing: true,
                //     serverSide: true,
                //     ajax: "{{ route('kategori.index') }}",
                //     columns: [
                //         {data: 'DT_RowIndex'},
                //         {data: 'nama' },
                //         {data: 'type', render: function(data,type,row){
                //             return (data === 1) ? "Income" : "Outcome"
                //         } },
                //         {data: 'action', orderable: false, searchable: false},
                //     ]
                // }).draw();
                window.location = "{{ route('kategori.index') }}";
                toastr.success(data.success);
            },
            error: function (data) {
                toastr.error(data.responseJSON.message);
                $('#editBtn').html('Save Changes');
            }
        });
    });
</script>