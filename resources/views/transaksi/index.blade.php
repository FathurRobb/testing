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
                    <button type="button" class="card-title float-md-right btn btn-info btn-sm border border-white"  data-toggle="modal" data-target="#addModal">
                        Tambah Data<i class="material-icons">add</i>
                    </button>
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
                                        <td>{{ (strlen($data->deskripsi) > 30) ? substr($data->deskripsi,0,30).'...' : $data->deskripsi }}</td>
                                        <td>@currency($data->debit)</td>
                                        <td>@currency($data->credit)</td>
                                        <td>
                                            <a type="button" class="btn btn-outline-success btn-sm" id="editButton" data-toggle="modal" data-target="#editModal" data-attr="{{ route('transaksi.edit', $data->id) }}">
                                                <i class="material-icons"  style="color:#4caf50;">edit</i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="{{ $data->id }}">
                                                <i class="material-icons">delete</i>
                                            </button>                                 
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @empty
                                    <tr>
                                        <td colspan="8">Data Transaksi Belum Tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Modal Add --}}
            <form id="createForm">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group has-info">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required>
                            </div>
                            <div class="form-group has-info">
                                <label for="chart_of_account" style="color: #00bcd4">Chart Of Account</label>
                                <select class="form-control" id="chart_of_account_id" name="chart_of_account_id" required>
                                    <option value="" selected disabled>--Pilih Chart Account--</option>
                                    @foreach ($kategoris as $kategori)
                                        <optgroup label="{{$kategori->nama}}">
                                            @foreach ($kategori->chart_of_account as $coa)
                                                <option value="{{ $coa->id }}">{{ $coa->kode .' - '. $coa->nama }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group has-info">
                                <label for="debit">Debit</label>
                                <input type="text" class="form-control" id="debit" name="debit" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" required>
                            </div>
                            <div class="form-group has-info">
                                <label for="credit">Credit</label>
                                <input type="text" class="form-control" id="credit" name="credit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                            </div>
                            <div class="form-group has-info">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info" id="saveBtn">Simpan</button>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
            {{-- Modal Edit --}}
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" id="editContent">
                    <div class="modal-content">

                    </div>
                </div>
            </div>
            {{-- Modal Delete --}}
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
                                Apakah anda yakin menghapus data transaksi ini?<span hidden id="transaksi-id"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-info" id="deleteBtn">Ya</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });

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

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            toastr.options.timeout = 10000;

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending...');

                $.ajax({
                    data: $('#createForm').serialize(),
                    url: "{{ route('transaksi.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#createForm').trigger("reset");
                        $('#addModal').modal("hide");
                        $('#example').load(document.URL +  ' #example');
                        toastr.success(data.success);
                    },
                    error: function (data) {
                        toastr.error(data.responseJSON.message);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('#deleteBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Deleting...');
                let transaksiId = $("#transaksi-id").html();

                $.ajax({
                    url: 'transaksi/'+transaksiId,
                    type: "DELETE",
                    dataType: 'json',
                    success: function (data) {
                        $('#deleteModal').modal("hide");
                        $('#example').load(document.URL +  ' #example');
                        toastr.success(data.success);
                    },
                    error: function (data) {
                        toastr.error(data.responseJSON.message);
                        $('#deleteBtn').html('Save Changes');
                    }
                });
            });
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            let id = $(event.relatedTarget).data('id')  
            document.getElementById("transaksi-id").innerHTML = id;
        });

        $(document).on('click', '#editButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href
                , beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#editModal').modal("show");
                    $('#editContent').html(result).show();
                }
                , complete: function() {
                    $('#loader').hide();
                }
                , error: function(jqXHR, testStatus, error) {
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                }
                , timeout: 8000
            })
        });
    </script>
@endpush