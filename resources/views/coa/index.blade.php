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
                        <table class="table data-table">
                            <thead class="text-info">
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Chart Of Account</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group has-info">
                                <label for="kode">Kode</label>
                                <input type="number" class="form-control" name="kode" required>
                                <span class="text-danger d-none" id="kode-message"></span>
                            </div>
                            <div class="form-group has-info">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                            <div class="form-group has-info">
                                <label for="kategori" style="color: #00bcd4">Kategori</label>
                                <select class="form-control" name="kategori_id" required>
                                    <option value="" selected disabled>--Pilih Kategori--</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
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
                    <form id="editForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Form Edit Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <span hidden id="id-update"></span>
                                <div class="form-group has-info">
                                    <label for="kode">Kode</label>
                                    <input type="text" class="form-control" id="kode" name="kode" value="">
                                    <span class="text-danger d-none" id="kode-message-update"></span>
                                </div>
                                <div class="form-group has-info">
                                    <label for="nama" style="color: #00bcd4">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="">
                                </div>
                                <div class="form-group has-info">
                                    <label for="kategori">Kategori</label>
                                    <select class="form-control" id="kategori_id" name="kategori_id">
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
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
                                Apakah anda yakin untuk menghapus data <span hidden id="coa-id"></span><b><span id="coa-nama"></span></b> ?
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
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('coa.index') }}",
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'kode' },
                    {data: 'nama' },
                    {data: 'kategori.nama'},
                    {data: 'action', render: function(data,type,row,meta) {
                        let btn ='<a type="button" class="btn btn-outline-success btn-sm" id="editButton" data-toggle="modal" data-target="#editModal" data-id="'+row.id+'"><i class="material-icons" style="color:#4caf50;">edit</i></a>'
                        btn = btn+'<button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="'+row.id+'" data-coanama="'+row.nama+'"><i class="material-icons">delete</i></button>'
                        return btn
                    },  orderable: false, searchable: false},
                ]
            });

            toastr.options.timeout = 10000;

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending...');

                $.ajax({
                    data: $('#createForm').serialize(),
                    url: "{{ route('coa.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#createForm').trigger("reset");
                        $('#kode-message').addClass("d-none");
                        $('#addModal').modal("hide");
                        table.draw();
                        toastr.success(data.success);
                    },
                    error: function (data) {
                        if (data.responseJSON.errors.kode) {
                            document.getElementById("kode-message").classList.remove("d-none")
                            document.getElementById("kode-message").innerHTML = data.responseJSON.errors.kode;  
                        }
                        toastr.error(data.responseJSON.message);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('#deleteBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Deleting...');
                let coaId = $("#coa-id").html();

                $.ajax({
                    url: 'coa/'+coaId,
                    type: "DELETE",
                    dataType: 'json',
                    success: function (data) {
                        $('#deleteModal').modal("hide");
                        table.draw();
                        toastr.success(data.success);
                    },
                    error: function (data) {
                        toastr.error(data.responseJSON.message);
                        $('#deleteBtn').html('Save Changes');
                    }
                });
            });

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
                        table.draw();
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
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            let id = $(event.relatedTarget).data('id')  
            let coaNama = $(event.relatedTarget).data('coanama') 
            document.getElementById("coa-nama").innerHTML = coaNama;  
            document.getElementById("coa-id").innerHTML = id;
        });

        $('#editModal').on('show.bs.modal', function (event) {
            let id = $(event.relatedTarget).data('id') 
            document.getElementById("id-update").innerHTML = id;
            $.ajax({
                url: 'coa/'+id,
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#kode-message-update').addClass("d-none");
                    $('#kode').val(data.success.kode);
                    $('#nama').val(data.success.nama);
                    $('#kategori_id').val(data.success.kategori_id);
                },
                error: function (data) {
                    toastr.error(data.message);
                }
             });
        });

        // $(document).on('click', '#editButton', function(event) {
        //     event.preventDefault();
        //     let href = $(this).attr('data-attr');
        //     $.ajax({
        //         url: href
        //         , beforeSend: function() {
        //             $('#loader').show();
        //         },
        //         // return the result
        //         success: function(result) {
        //             $('#editModal').modal("show");
        //             $('#editContent').html(result).show();
        //         }
        //         , complete: function() {
        //             $('#loader').hide();
        //         }
        //         , error: function(jqXHR, testStatus, error) {
        //             alert("Page " + href + " cannot open. Error:" + error);
        //             $('#loader').hide();
        //         }
        //         , timeout: 8000
        //     })
        // });
    </script>
@endpush