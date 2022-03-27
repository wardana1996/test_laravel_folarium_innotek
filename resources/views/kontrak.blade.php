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
    <title>Kontrak Pegawai</title>
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
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreate">Create</button>
                <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Kontrak</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form id="formCreate" method="POST">
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Nama Pegawai</label>
                                        <div class="col-sm-8">
                                            <select name="pegawai_id" id="pegawai_id" class="form-control form-control-sm pegawai_id" style='width: 300px;' >
                                                <option value="" hidden>-- pilih nama pegawai --</option>
                                            </select>
                                            <span class="text-danger small" id="pegawai_iderror"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Jabatan</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="jabatan" class="form-control form-control-sm" id="jabatan" readonly required>
                                            <input type="hidden" name="jabatan_id" class="form-control form-control-sm" id="jabatan_id" readonly required>
                                            <span class="text-danger small" id="jabatan_iderror"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Kontrak</label>
                                        <div class="col-sm-8">
                                            <select name="kontrak" id="kontrak" class="form-control form-control-sm" style='width: 300px;' >
                                                <option value="" hidden>-- pilih kontrak --</option>
                                                <option value="Temporer">Temporer</option>
                                                <option value="Tetap">Tetap</option>
                                            </select>
                                            <span class="text-danger small" id="kontrakerror"></span>
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
                    <select id="searchKontrak" class="form-control mr-2" style="width: 200px">
                        <option value="" hidden>-- jenis kontrak --</option>
                        <option value="">Semua Kontrak</option>
                        <option value="Temporer">Temporer</option>
                        <option value="Tetap">Tetap</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="display" id="kontrakTable" width="100%;">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Kontrak</th>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Kontrak Pegawai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form id="formUpdate" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id">
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Nama Pegawai</label>
                                    <div class="col-sm-8">
                                        <select name="pegawai_selected" id="pegawai_id_edit" class="form-control form-control-sm pegawai_id_edit" style='width: 300px;' >
                                        </select>
                                        <span class="text-danger small" id="pegawai_iderrorEdit"></span>
                                    </div>
                                    <input type="hidden" name="pegawai_id" id="pegawai_id_box"/>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Jabatan</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="jabatan" class="form-control form-control-sm" id="jabatan_edit" readonly required>
                                        <input type="hidden" name="jabatan_id" class="form-control form-control-sm" id="jabatan_id_edit" readonly required>
                                        <span class="text-danger small" id="jabatan_iderroredit"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Kontrak</label>
                                    <div class="col-sm-8">
                                        <select name="kontrak" id="kontrak_edit" class="form-control form-control-sm">
                                            <option value="" hidden></option>
                                            <option value="Temporer">Temporer</option>
                                            <option value="Tetap">Tetap</option>
                                        </select>
                                        <span class="text-danger small" id="kontrakerrorEdit"></span>
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

            $("#pegawai_id").select2({
                ajax: { 
                    url: "{{ url('/pegawai/nama') }}",
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

            $('.pegawai_id').on('change', function() {
                var pegawaiId = $(this).val();
                $.ajax({
                    url: '/kontrak/jabatan/'+pegawaiId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#jabatan').val(data.jabatan);
                        $('#jabatan_id').val(data.jabatan_id);  
                    }
                });     
            });

            $('.pegawai_id_edit').on('change', function() {
                var pegawaiId = $(this).val();
                $.ajax({
                    url: '/kontrak/jabatan/'+pegawaiId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#jabatan_edit').val(data.jabatan);
                        $('#jabatan_id_edit').val(data.jabatan_id);  
                        $('#pegawai_id_box').val(pegawaiId);  
                    }
                });     
            });
    
            var table = $('#kontrakTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength : 6,
                lengthMenu: [[6, 10, 20, -1], [6, 10, 20, 'Todos']],
                ajax: {
                    url: "{{ route('kontrak.index') }}",
                    type: 'GET',
                    data: function (d) {
                        d.kontrak = $('#searchKontrak').val(),
                        d.jabatan_id = $('#searchJabatan').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [
                    { data: 'nama', name: 'pegawai.nama' },
                    { data: 'jabatan', name: 'jabatan_pegawai.jabatan' },
                    { data: 'kontrak', name: 'kontrak' },
                    { data: 'action', name: 'action', orderable: false },
                ],
                order: [[0, 'desc']]
            });

            $("#searchKontrak").change(function(){
                table.draw();
            });

            $(document).on('submit', '#formCreate', function(event){  
                event.preventDefault();  
                var pegawai_id = $('#pegawai_id :selected').val();    
                var jabatan_id = $('#jabatan_id').val(); 
                var kontrak = $('#kontrak').val(); 
                $.ajax({
                    url: "{{ url('/kontrak/create') }}",
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
                        $('#pegawai_id , #kontrak').val(null).trigger('change');
                        $('#kontrakTable').DataTable().ajax.reload( null, false ); 
                    },
                    error:function (response) {
                        $("#pegawai_iderror").hide().text(response.responseJSON.errors.pegawai_id).fadeIn('slow').delay(2000).hide(1);
                        $('#jabatan_iderror').hide().text(response.responseJSON.errors.jabatan_id).fadeIn('slow').delay(2000).hide(1);
                        $('#kontrakerror').hide().text(response.responseJSON.errors.kontrak).fadeIn('slow').delay(2000).hide(1);
                    }
                })
            }); 

            $(document).on("click", ".editPegawai", function () {
                var id = $(this).data('id');
                $.ajax({
                    type:"POST",
                    url: "{{ url('/kontrak/edit') }}"+'/'+id,
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        $('#modalEdit').modal('show');
                        $('#id').val(res.id);
                        $('#pegawai_id_edit').val(res.pegawai_id);
                        $('#pegawai_id_box').val(res.pegawai_id);
                        $('.pegawai_id_edit').select2({
                            placeholder: res.nama,
                            ajax: { 
                                url: "{{ url('/pegawai/nama') }}",
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
                        $('#jabatan_edit').val(res.jabatan);
                        $('#jabatan_id_edit').val(res.jabatan_id);
                        $('#kontrak_edit :selected').val(res.kontrak).text(res.kontrak);
                    }
                });
            });

            $(document).on('click', '#buttonUpdate', function(event){  
                event.preventDefault(); 
                var pegawai_id =$('#pegawai_id_edit').val(); 
                var jabatan_id =$('#jabatan_id_edit').val(); 
                var kontrak =$('#kontrak_edit').val(); 
                var id = $('#id').val();  
                $.ajax({
                    url: "{{ url('/kontrak/update') }}"+'/'+id,
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
                        $('#kontrakTable').DataTable().ajax.reload( null, false );      
                    },
                    error:function (response) {
                        $("#pegawai_iderrorEdit").hide().text(response.responseJSON.errors.pegawai_id).fadeIn('slow').delay(2000).hide(1);
                        $('#jabatan_iderrorEdit').hide().text(response.responseJSON.errors.jabatan_id).fadeIn('slow').delay(2000).hide(1);
                        $('#kontrakerrorEdit').hide().text(response.responseJSON.errors.kontrak).fadeIn('slow').delay(2000).hide(1);
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
                            url: "{{ url('/kontrak/delete') }}"+'/'+id,
                            cache: false,
                            method:"DELETE",  
                            data: { id: id },
                            success: function(data){
                                $('#kontrakTable').DataTable().ajax.reload( null, false );       
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
        });
        </script>
    </body>
</html>