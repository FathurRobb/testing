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
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $data->tanggal }}" required>
            </div>
            <div class="form-group has-info">
                <label for="chart_of_account" style="color: #00bcd4">Chart Of Account</label>
                <select class="form-control" id="chart_of_account_id" name="chart_of_account_id" required>
                    @foreach ($kategoris as $kategori)
                        <optgroup label="{{$kategori->nama}}">
                            @foreach ($kategori->chart_of_account as $coa)
                                <option value="{{ $coa->id }}" {{ $coa->id == $data->chart_of_account_id ? 'selected' : '' }}>{{ $coa->kode .' - '. $coa->nama }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="form-group has-info">
                <label for="debit">Debit</label>
                <input type="text" class="form-control" id="debit" name="debit" value="{{ $data->debit }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" required>
            </div>
            <div class="form-group has-info">
                <label for="credit">Credit</label>
                <input type="text" class="form-control" id="credit" name="credit" value="{{ $data->credit }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
            </div>
            <div class="form-group has-info">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ $data->deskripsi }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-info" id="editBtn">Perbaharui Data</button>
        </div>
    </div>
</form>

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
        toastr.options.timeout = 10000;
        $('#editBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Updating...');
            let transaksiId = $("#id-update").html();

            $.ajax({
                data: $('#editForm').serialize(),
                url: 'transaksi/'+transaksiId,
                type: "PUT",
                dataType: 'json',
                success: function (data) {
                    $('#editModal').modal("hide");
                    $('#example').load(document.URL +  ' #example');
                    toastr.success(data.success);
                },
                error: function (data) {
                    toastr.error(data.responseJSON.message);
                    $('#editBtn').html('Save Changes');
                }
            });
        });
    </script>