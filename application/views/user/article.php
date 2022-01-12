<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $judul_page;?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Artikel</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Filter/Pencarian</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form name="form1" action="" method="get">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Judul</label>
                                <input class="form-control" type="text" value="<?php echo isset($_GET['judul']) && $_GET['judul'] != "" ? $_GET['judul'] : ""?>" name="judul" placeholder="Judul Artikel">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <input type="submit" name="cari" id="cari" class="btn btn-primary float-right" value="Submit" />
                </div>
                </form>
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <h6 class="card-title mt-1">Tabel Record Data</h6>
                    <div class="card-tools">
                        <a href="javascript:;" id="tambah_faq" class="btn btn-block btn-outline-primary btn-sm">
                            <i class="fa fa-plus"></i> Tambah Data Artikel
                        </a>
					</div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="rekap_presensi_tabel" class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th width="5%" style="text-align:center">No.</th>
                                <th width="70%">Judul</th>
                                <th width="15%" style="text-align:center">Image</th>
                                <th width="5%" style="text-align:center">#</th>
                                <th width="5%" style="text-align:center">#</th>
                            </tr>
                        </thead>
                        <tbody id="rekap_presensi_body">
                            <?php 
                                $per_page = 10;

                                if($this->uri->segment(4) != ""){
                                    $page = ($this->uri->segment(4));
                                    $poss = (($page-1) * $per_page);
                                } else {
                                    $page = 1;
                                    $poss = 0;
                                }
    
                                $no = $poss; foreach($download as $data) { $no++;
                            ?>
                            <tr>
                                <td style="text-align:center"><?= $no;?></td>
                                <td><?= $data->title;?></td>
                                <td style="text-align:center"><a href="<?= base_url('assets/image/'.$data->id.'.'.$data->image)?>"><i class="far fa-image"></i></a></td>
                                <td style="text-align:center">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" onclick="sunting_faq('<?= $data->id;?>')"><i class="fas fa-edit mr-2"></i></a>
                                    </div>
                                </td>
                                <td style="text-align:center">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" onclick="hapus_faq('<?= $data->id;?>')"><i class="fas fa-trash mr-2"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
               		<div class="m-0 float-left">
                	</div>
                	<?php echo $links; ?>
                	<div class="m-0 float-right" style="padding-top: 2px; padding-right: 10px;">
                		<?php echo $pagination_info; ?>
					</div>
              	</div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_data_faq" data-backdrop='static'>
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Large Modal</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_add_data_faq" autocomplete="off">
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label>Judul Artikel</label>
                                <input class='form-control' type="text" id='title' value='' placeholder='Judul' />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label>Content Artikel</label>
                                <textarea class='form-control' id='content' rows="7"value='' placeholder='Content'></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label>File Image</label>
                                <input class='form-control' type="file" id="file" accept="image/jpg,image/jpeg,image/png">
                                <label class='form-control d-none mt-2' id='file_prev'></label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="faq_id">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class='fas fa-ban mr-2'></i>Batal</button>
                    <button type="button" onclick='simpan_faq()' class="btn btn-primary"><i class='fas fa-save mr-2'></i>Simpan</button>
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function(){
        let base_url = "<?= base_url();?>";
        let height = $(window).height()-100;
        if (localStorage.getItem('create_success')) {
            const data = localStorage.getItem('create_success');
            Command: toastr['success']('Penambahan Artikel Berhasil', "SUKSES");
            localStorage.clear('create_success');
        }
        if (localStorage.getItem('edit_success')) {
            const data = localStorage.getItem('edit_success');
            Command: toastr['success']('Perubahan Artikel Berhasil', "SUKSES");
            localStorage.clear('edit_success');
        }
        if (localStorage.getItem('delete_success')) {
            const data = localStorage.getItem('delete_success');
            Command: toastr['error']('Penghapusan Artikel Berhasil', "SUKSES");
            localStorage.clear('delete_success');
        }
        if (localStorage.getItem('last_visited_url')) {
            localStorage.clear('last_visited_url');
        }
        if (localStorage.getItem('edit_id')) {
            localStorage.clear('edit_id');
        }
    })

    $('#tambah_faq').on('click',function(){
        $('#add_data_faq').modal('show');
        $('#add_data_faq .modal-title').html('Tambah Data Artikel');
        $('#form_add_data_faq input:visible').each(function() {
            $(this).removeClass('is-invalid');
        });
        $('#form_add_data_faq textarea:visible').each(function() {
            $(this).removeClass('is-invalid')
        });
    })

    $('#add_data_faq').on('hidden.bs.modal',function(){
        reset_form();
    });

    function reset_form() {
        $('#title').val('');
        $('#content').val('');
        $('#file').val('');
    }
    
    function sunting_faq(id) {
        Swal.fire({
            title: 'Sedang Memuat Data',
            text: 'Mohon tunggu...',
            didOpen: function () {
                Swal.showLoading();
                $.ajax({
                    type  : 'POST',
                    dataType : "json",
                    url   : '<?php echo base_url('user/get_article_by_id'); ?>',
                    data  : {
                        'id': id
                    },
                    success: function(data) {
                        console.log(data)
                        if (data) {
                            $('#add_data_faq').modal('show');
                            $('#add_data_faq .modal-title').html('Edit Data Artikel');
                            $('#faq_id').val(data.id);
                            $('#title').val(data.title);
                            $('#content').val(data.content);
                            $('#file_prev').removeClass('d-none');
                            $('#file_prev').html('<a href="<?= base_url()?>assets/image/'+data.id+'.'+data.image+'">Image</a>');
                            Swal.close();
                        }
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }

    $(document).on('change','#file',function(){
        const valid_ext = $(this).attr('accept');
        if (valid_ext.includes($(this).prop('files')[0]['type'])) {
            if (($(this).prop('files')[0]['size'] / 1024) > 2000) {
                $(this).val('');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: 'Maksimum size yang diperbolehkan hanya 2Mb.',
                })
            }
        } else {
            $(this).val('');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: 'File extension yang diperbolehkan hanya file image.',
            })
        }
        
    })

    function simpan_faq() {
        let empty_field = 0;
        let faq_id = $('#faq_id').val();
        $('#form_add_data_faq input:visible').each(function() {
            console.log($(this).attr('type'))
            if (!$(this).val()) {
                if ($(this).attr('type') == 'file') {
                    if (!$('#file_prev').is(':visible')) {
                        empty_field++;
                        $(this).addClass('is-invalid');
                    }
                } else {
                    empty_field++;
                    $(this).addClass('is-invalid');
                }
            } else {
                $(this).removeClass('is-invalid') 
            }
        });
        $('#form_add_data_faq textarea:visible').each(function() {
            if (!$(this).val()) {
                empty_field++;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid') 
            }
        });
        if (empty_field > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops',
                html: 'Anda belum mengisi semua field.',
            })
        } else {
            let url = '<?= base_url()?>/user/article/simpan';
            let form_data = new FormData();
            if (faq_id) {
                url = '<?= base_url()?>/user/article/update';
                form_data.append('id', faq_id);
            }
            form_data.append('title', $('#title').val());
            form_data.append('content', $('#content').val());
            form_data.append('file', $('#file').prop('files')[0]);
            Swal.fire({
                title: 'Sedang Menyimpan Data',
                text: 'Mohon tunggu...',
                didOpen: function () {
                    Swal.showLoading();
                    $.ajax({
                        type  : 'POST',
                        dataType : "json",
                        url   : url,
                        cache : false,
						contentType : false,
						processData : false,
						data  : form_data,
                        success: function(data) {
                            if (data) {
                                if (data.status_code == 200) {
                                    if (faq_id) {
                                        localStorage.setItem('edit_success','1');
                                    } else {
                                        localStorage.setItem('create_success','1');
                                    }
                                    location.reload();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        html: 'Error koneksi database!',
                                    })
                                }
                            }
                        }
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }
    }

    function hapus_faq(id) {
        Swal.fire({
            title: 'Sedang Menghapus Data',
            text: 'Mohon tunggu...',
            didOpen: function () {
                Swal.showLoading();
                $.ajax({
                    type  : 'POST',
                    dataType : "json",
                    url   : '<?php echo base_url('user/hapus_artikel'); ?>',
                    data  : {
                        'id': id
                    },
                    success: function(data) {
                        if (data.status_code == 200) {
                            localStorage.setItem('delete_success','1');
                            location.reload();
                        }
                    }
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }
</script>