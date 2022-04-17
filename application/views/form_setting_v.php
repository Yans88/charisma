<style>
.form-control{
	height:20px;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Setting</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php if($tersimpan == 'Y') { ?>
					<div class="box-body">
						<div class="alert alert-success alert-dismissable">
		                    <i class="fa fa-check"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data berhasil disimpan.
		                </div>
					</div>
				<?php } ?>

				<?php if($tersimpan == 'N') { ?>
					<div class="box-body">
						<div class="alert alert-danger alert-dismissable">
		                    <i class="fa fa-warning"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data tidak berhasil disimpan, silahkan ulangi beberapa saat lagi.
		                </div>
					</div>
				<?php } 
				
				?>

				<div class="form-group">
					<?php 
					echo form_open('');
					//nama sekolah
					$data = array(
		              'name'        => 'email',
		              'id'			=> 'email',
		              'class'		=> 'form-control',
		              'value'       => $email,		   
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Email', 'email');
					echo form_input($data);
					echo '<br>';
					
					//nama ketua
					$data = array(
		              'name'        => 'pass',
		              'id'			=> 'pass',
		              'class'		=> 'form-control',
		              'value'       => $pass,		           
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Mail Password', 'pass');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'point',
		              'id'			=> 'point',
		              'class'		=> 'form-control',
		              'value'       => $point,		           
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Reward 1 point(Rp.)', 'point');
					echo form_input($data);
					echo '<br>';
					
					
					$data = array(
		              'name'        => 'subj_email_register',
		              'id'			=> 'subj_email_register',
		              'class'		=> 'form-control',
		              'value'       => $subj_email_register,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Subject Email for Registration', 'subj_email_register');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'subj_email_forgot',
		              'id'			=> 'subj_email_forgot',
		              'class'		=> 'form-control',
		              'value'       => $subj_email_forgot,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Subject Email for Forgot Password', 'subj_email_forgot');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'info_rek',
		              'id'			=> 'info_rek',
		              'class'		=> 'form-control',
		              'value'       => $info_rek,		              
		              'style'       => 'width: 98%'
	            	);
					echo form_label('Info Rekening', 'info_rek');
					echo form_textarea($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'content_forgotPass',
		              'id'			=> 'content_forgotPass',
		              'class'		=> 'form-control',
		              'value'       => $content_forgotPass,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Content Email forgot password', 'content_forgotPass');
					echo form_textarea($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'content_verifyReg',
		              'id'			=> 'content_verifyReg',
		              'class'		=> 'form-control',
		              'value'       => $content_verifyReg,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Content Email for Verify Registration', 'content_verifyReg');
					echo form_textarea($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'content_order_member',
		              'id'			=> 'content_order_member',
		              'class'		=> 'form-control',
		              'value'       => $content_order_member,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Content Email Order for Member', 'content_order_member');
					echo form_textarea($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'content_request_sample',
		              'id'			=> 'content_request_sample',
		              'class'		=> 'form-control',
		              'value'       => $content_request_sample,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Content Email Order for Request Sample & Inquiry', 'content_request_sample');
					echo form_textarea($data);
					
					// submit
					$data = array(
				    'name' 		=> 'submit',
				    'id' 		=> 'submit',
				    'class' 	=> 'btn btn-primary',
				    'value'		=> 'true',
				    'type'	 	=> 'submit',
				    'content' 	=> 'Update'
					);
					echo '<br>';
					echo form_button($data);


					echo form_close();

					?>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script>
$("input").attr("autocomplete", "off"); 
 $(function (config) {
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace('info_rek');
	CKEDITOR.replace('content_verifyReg');
	CKEDITOR.replace('content_forgotPass');
	CKEDITOR.replace('content_order_member');
	CKEDITOR.replace('content_request_sample');
	
});
$('#point').keyup(function(event) {
  
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  });
});
</script>