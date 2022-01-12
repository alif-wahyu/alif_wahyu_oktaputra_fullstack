
    <div class="modal fade" id="signup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-4 mb-2"><label for="exampleFormControlInput1" class="form-label">Username</label></div>
                            <div class="col-md-8 mb-2"><input type="text" class="form-control" id="username" placeholder="Username" autocomplete="off" required></div>
                            <div class="invalid-feedback">
                                Username harus diisi.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-4 mb-2"><label for="exampleFormControlInput1" class="form-label">Password</label></div>
                            <div class="col-md-8 mb-2"><input type="password" class="form-control" id="password" placeholder="Password" autocomplete="off" required></div>
                            <div class="invalid-feedback">
                                Password harus diisi.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-4 mb-2"><label for="exampleFormControlInput1" class="form-label">Phone</label></div>
                            <div class="col-md-8 mb-2"><input type="text" class="form-control" id="phone" placeholder="Phone" autocomplete="off" required></div>
                            <div class="invalid-feedback">
                                Nomor Telpon harus diisi.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
					<button class="btn btn-jsc" id="signmeup">Sign up</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body px-5">
                    <form action="login/auth" method="post">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4 mb-2"><label for="exampleFormControlInput1" class="form-label">Username</label></div>
                                <div class="col-md-8 mb-2"><input type="text" class="form-control" name="lusername" placeholder="Username" autocomplete="off" required></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4 mb-2"><label for="exampleFormControlInput1" class="form-label">Password</label></div>
                                <div class="col-md-8 mb-2"><input type="password" class="form-control" name="lpassword" placeholder="Password" autocomplete="off" required></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script src="<?php echo base_url();?>assets/dist/js/font_awesome.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url();?>assets/dist/js/bootstrap.min.js"></script>
<script>
    $('#signmeup').on('click',function() {
        $ready = true
        $('#signup input').each(function(){
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                $ready = false;
                return false
            } else {
                $(this).removeClass('is-invalid');
            }
        })
        
		if ($ready === true) {
			Swal.fire({
				title: 'Sedang menyimpan data',
				text: 'Mohon tunggu...',
				didOpen: function () {
					Swal.showLoading();
					$.ajax({
						url   : '<?php echo base_url('user/simpan_user'); ?>',
						type  : 'POST',
						dataType : 'json',
						data  : {
							'username' : $('#username').val(),
							'password' : $('#password').val(),
							'phone' : $('#phone').val()
						}
					}).done(function(data){
						if(data) {
							if (data.status_code == 200) {
								Swal.fire({
									title: 'Berhasil',
									html: 'Anda telah terdaftar. Silakan login.',
									icon: 'success'
								})
                                $('#signup input').each(function(){
                                    $(this).val('')
                                })
                                $('#signup').modal('hide');
							} else {
								var dPesan = '\
									<table width="100%" id="t_form" border="1">\
										<tbody>\
											<tr>\
												<td width="6%" align="center">&nbsp;No</td>\
												<td width="94%">Pesan</td>\
											</tr>\
								';
								var no = 0;
								for (var i = 0; i<data.pesan.length; i++) {
									no++;
									dPesan += '\
										<tr>\
											<td>'+no+'.</td>\
											<td align="left">'+data.pesan[i].pesan+'</td>\
										</tr>';
								}
								dPesan += '\
										</tbody>\
									</table>\
								';
								Swal.fire({
									title: 'Opps',
									html: dPesan,
									icon: 'warning'
								}).then((result) => {
									if (result.value) {
										return false;
									}
								});
							}
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								html: 'Server tidak merespon',
							})
						}
					});
				}
			})
		}
    })
    
</script>
