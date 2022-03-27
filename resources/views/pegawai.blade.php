<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <title>Pegawai</title>
  </head>
  <body>
    <style>
        .dataTables_filter, .dataTables_info { 
            display: none; 
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('jabatan.index') }}">List Jabatan <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('pegawai.index') }}">List Pegawai <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('kontrak.index') }}">List Kontrak <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <form action="{{ url('/pegawai/import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-3">
                <input type="file" name="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
            </div>
        </form>
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreate">Create</button>
                <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form id="formCreate" method="POST">
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Nama</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="nama" class="form-control form-control-sm" id="nama" placeholder="masukkan nama..." >
                                            <span class="text-danger small" id="namaerror"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Email</label>
                                        <div class="col-sm-8">
                                            <input type="email" name="email" class="form-control form-control-sm" id="email" placeholder="masukkan email..." >
                                            <span class="text-danger small" id="emailerror"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Alamat</label>
                                        <div class="col-sm-8">
                                            <textarea name="alamat" class="form-control form-control-sm" id="alamat" placeholder="masukkan alamat..." rows="5"></textarea>
                                            <span class="text-danger small" id="alamaterror"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Jabatan</label>
                                        <div class="col-sm-8">
                                            <select name="jabatan_id" id="jabatan_id" class="form-control form-control-sm" style='width: 300px;' >
                                                <option value="" hidden>-- pilih jabatan --</option>
                                            </select>
                                            <span class="text-danger small" id="jabatan_iderror"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row ml-1">
                    <select id="searchJabatan" class="form-control" style="width: 200px">
                        <option value="" hidden>-- pilih jabatan --</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="display" id="pegawaiTable" width="100%;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Pegawai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form id="formUpdate" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id">
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Nama</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nama" class="form-control form-control-sm" id="nama_edit" required>
                                        <span class="text-danger small" id="namaerrorEdit"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" class="form-control form-control-sm" id="email_edit" required>
                                        <span class="text-danger small" id="emailerrorEdit"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea name="alamat" class="form-control form-control-sm" id="alamat_edit" rows="5" required></textarea>
                                        <span class="text-danger small" id="alamaterrorEdit"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Jabatan</label>
                                    <div class="col-sm-8">
                                        <select id="jabatan_id_edit" name="jabatan_selected" class="form-control form-control-sm jabatan_id" required>
                                            <option value="" hidden></option>
                                        </select>
                                        <input type="hidden" name="jabatan_id" id="jabatan_id_box"/>
                                        <span class="text-danger small" id="jabatan_iderrorEdit"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" id="buttonUpdate" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#jabatan_id , #searchJabatan").select2({
                ajax: { 
                url: "{{ url('/pegawai/jabatan') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                    _token: "{{csrf_token()}}",
                    search: params.term
                    };
                },
                processResults: function (response , params) {
                    return {
                    results: response,
                    };
                },
                cache: true
                }
            });

            $('select[name="jabatan_selected"]').on('change', function() {
                var pegawaiId = $(this).val();
                $('#jabatan_id_box').val(pegawaiId);  
            });
    
            var table = $('#pegawaiTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength : 6,
                lengthMenu: [[6, 10, 20, -1], [6, 10, 20, 'Todos']],
                ajax: {
                    url: "{{ route('pegawai.index') }}",
                    type: 'GET',
                    data: function (d) {
                        d.jabatan_id = $('#searchJabatan').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    { data: 'nama', name: 'nama' },
                    { data: 'email', name: 'email' },
                    { data: 'jabatan', name: 'jabatan_pegawai.jabatan' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'action', name: 'action', orderable: false },
                ],
                order: [[0, 'desc']]
            });

            $("#searchJabatan").change(function(){
                table.draw();
            });

            $(document).on('submit', '#formCreate', function(event){  
                event.preventDefault();  
                var nama = $('#nama').val();    
                var email = $('#email').val(); 
                var alamat = $('#alamat').text(); 
                var jabatan_id =$('#jabatan_id').val();
                $.ajax({
                    url: "{{ url('/pegawai/create') }}",
                    cache: false,  
                    method:'POST',  
                    data:  $(this).serialize(),
                    success: function(data){
                        Swal.fire({
                            title: 'data berhasil ditambahkan',
                            text: "sukses",
                            icon: 'success',
                            confirmButtonColor: '#004028',
                            confirmButtonText: 'Yes',
                            allowOutsideClick: false
                        });
                        $('#formCreate')[0].reset(); 
                        $('#modalCreate').modal('hide');  
                        $('#jabatan_id').val(null).trigger('change');
                        $('#pegawaiTable').DataTable().ajax.reload( null, false ); 
                    },
                    error:function (response) {
                        $("#namaerror").hide().text(response.responseJSON.errors.nama).fadeIn('slow').delay(2000).hide(1);
                        $('#emailerror').hide().text(response.responseJSON.errors.email).fadeIn('slow').delay(2000).hide(1);
                        $('#alamaterror').hide().text(response.responseJSON.errors.alamat).fadeIn('slow').delay(2000).hide(1);
                        $('#jabatan_iderror').hide().text(response.responseJSON.errors.jabatan_id).fadeIn('slow').delay(2000).hide(1);
                    }
                })
            }); 

            $(document).on("click", ".editPegawai", function () {
                var id = $(this).data('id');
                $.ajax({
                    type:"POST",
                    url: "{{ url('/pegawai/edit') }}"+'/'+id,
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#modalEdit').modal('show');
                        $('#id').val(res.id);
                        $('#nama_edit').val(res.nama);
                        $('#email_edit').val(res.email);
                        $('#alamat_edit').text(res.alamat);
                        $('#jabatan_id_edit').val(res.jabatan_id);
                        $('#jabatan_id_box').val(res.jabatan_id);
                        $('.jabatan_id').select2({
                            placeholder: res.jabatan,
                            ajax: { 
                                url: "{{ url('/pegawai/jabatan') }}",
                                type: "post",
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        _token: "{{csrf_token()}}",
                                        search: params.term
                                    };
                                },
                                processResults: function (response , params) {
                                    return {
                                        results: response,
                                    };
                                },
                                cache: true
                            }
                        });
                        
                    }
                });
            });

            $(document).on('click', '#buttonUpdate', function(event){  
                event.preventDefault(); 
                var nama = $('#nama_edit').val();    
                var email = $('#email_edit').val(); 
                var alamat = $('#alamat_edit').text(); 
                var jabatan_id =$('#jabatan_id_edit').val();
                var id = $('#id').val();  
                $.ajax({
                    url: "{{ url('/pegawai/update') }}"+'/'+id,
                    cache: false,
                    method:"POST",
                    data: $('#formUpdate').serialize(),
                    success: function(data){
                        Swal.fire({
                            title: 'data berhasil diupdate',
                            text: "sukses",
                            icon: 'success',
                            confirmButtonColor: '#004028',
                            confirmButtonText: 'Oke',
                            allowOutsideClick: false
                        });
                        $('#formUpdate')[0].reset(); 
                        $('#modalEdit').modal('hide');
                        $('#pegawaiTable').DataTable().ajax.reload( null, false );      
                    },
                    error:function (response) {
                        $("#namaerrorEdit").hide().text(response.responseJSON.errors.nama).fadeIn('slow').delay(2000).hide(1);
                        $('#emailerrorEdit').hide().text(response.responseJSON.errors.email).fadeIn('slow').delay(2000).hide(1);
                        $('#alamaterrorEdit').hide().text(response.responseJSON.errors.alamat).fadeIn('slow').delay(2000).hide(1);
                        $('#jabatan_iderrorEdit').hide().text(response.responseJSON.errors.jabatan_id).fadeIn('slow').delay(2000).hide(1);
                    }
                })
            });  

            $(document).on('click', '.delete', function(){  
                var id = $(this).attr("data-id");  
                Swal.fire({
                    title: 'Apakah anda yakin untuk menghapus data ini ?',
                    text: "data akan dihapus secara permanen !",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#004028',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ url('/pegawai/delete') }}"+'/'+id,
                            cache: false,
                            method:"DELETE",  
                            data: { id: id },
                            success: function(data){
                                $('#pegawaiTable').DataTable().ajax.reload( null, false );       
                            },
                            error: function(){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Maaf...',
                                    text: 'Ada Kesalahan !',
                                })
                            }
                        }),
                        Swal.fire({
                            title: 'Terhapus',
                            text: "Data berhasil dihapus",
                            icon: 'success',
                            confirmButtonColor: '#004028',
                            allowOutsideClick: false
                        })
                    }
                });
            });  

            $(document).on('click', '.noDelete', function(){  
                Swal.fire({
                    title: 'Tidak dapat menghapus data',
                    text: "data tidak dapat dihapus dikarenakan data telah digunakan !",
                    icon: 'error',
                    confirmButtonColor: '#004028',
                    allowOutsideClick: false
                })
            });  
        });
        </script>
    </body>
</html>