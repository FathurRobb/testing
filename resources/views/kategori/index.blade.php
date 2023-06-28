@extends('layout.template')

@section('title')
    Master Kategori COA
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title float-left mb-2">Kategori Chart Of Account</h4>
                    <button type="button" class="card-title float-md-right btn btn-info btn-sm border border-white" data-toggle="modal" data-target="#addModal" style="">
                        Tambah Data<i class="material-icons">add</i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table">
                            <thead class="text-info">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis Kategori</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @forelse ($datas as $data)
                                    <tr>                                        
                                        <td>{{ $i }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->type === 0 ? 'Outcome' : 'Income' }}</td>
                                        <td>
                                            <a type="button" class="btn btn-outline-success btn-sm" id="editButton" data-toggle="modal" data-target="#editModal" data-attr="{{ route('kategori.edit', $data->id) }}">
                                                <i class="material-icons" style="color:#4caf50;">edit</i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="{{ $data->id }}" data-kategorinama="{{ $data->nama }}">
                                                <i class="material-icons">delete</i>
                                            </button>                                 
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @empty
                                    <tr>
                                        <td colspan="3">Data Kategori Belum Tersedia</td>
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
            <form id="createForm">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kategori</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group has-info">
                                <label for="nama">Kategori</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group has-info">
                                <label for="nama">Type</label>
                                <select class="form-control" name="type" required>
                                    <option value="" selected disabled>--Pilih Jenis Kategori--</option>
                                    <option value="0">Outcome</option>
                                    <option value="1">Income</option>
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
                                Apakah anda yakin untuk menghapus kategori <span hidden id="kategori-id"></span> <b><span id="kategori-nama"></span></b> ?
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
            
            toastr.options.timeout = 10000;

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending...');

                $.ajax({
                    data: $('#createForm').serialize(),
                    url: "{{ route('kategori.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#createForm').trigger("reset");
                        $('#addModal').modal("hide");
                        $('#table').load(document.URL +  ' #table');
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
                let kategoriId = $("#kategori-id").html();

                $.ajax({
                    url: 'kategori/'+kategoriId,
                    type: "DELETE",
                    dataType: 'json',
                    success: function (data) {
                        $('#deleteModal').modal("hide");
                        $('#table').load(document.URL +  ' #table');
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
            let kategoriNama = $(event.relatedTarget).data('kategorinama') 
            document.getElementById("kategori-nama").innerHTML = kategoriNama;  
            document.getElementById("kategori-id").innerHTML = id;
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