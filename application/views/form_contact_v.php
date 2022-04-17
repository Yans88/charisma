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
				<?php } ?>

				<div class="form-group">
					<?php 
					echo form_open('');
					
					$data = array(
		              'name'        => 'company_name',
		              'id'			=> 'company_name',
		              'class'		=> 'form-control',
		              'value'       => $company_name,		   
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Company Name', 'company_name');
					echo form_input($data);
					echo '<br>';
					
					//nama ketua
					$data = array(
		              'name'        => 'address',
		              'id'			=> 'address',
		              'class'		=> 'form-control',
		              'value'       => $address,		           
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Address', 'address');
					echo form_input($data);
					echo '<br>';
					
					//hp ketua
					$data = array(
		              'name'        => 'kota',
		              'id'			=> 'kota',
		              'class'		=> 'form-control',
		              'value'       => $kota,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Kota', 'kota');
					echo form_input($data);
					echo '<br>';

					// alamat
					$data = array(
		              'name'        => 'kode_pos',
		              'id'			=> 'kode_pos',
		              'class'		=> 'form-control',
		              'value'       => $kode_pos,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Kode Pos', 'kode_pos');
					echo form_input($data);
					echo '<br>';

					$data = array(
		              'name'        => 'phone',
		              'id'			=> 'phone',
		              'class'		=> 'form-control',
		              'value'       => $phone,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Telp.', 'phone');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'faks',
		              'id'			=> 'faks',
		              'class'		=> 'form-control',
		              'value'       => $faks,		              
		              'style'       => 'width: 97%'
	            	);
					echo form_label('Faks.', 'faks');
					echo form_input($data);
					echo '<br>';
					
					$data = array(
		              'name'        => 'email_company',
		              'id'			=> 'email_company',
		              'class'		=> 'form-control',
		              'value'       => $email_company,
		              'rows'        => '7',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('Email', 'email_company');
					echo form_input($data);
					

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

<script>
$("input").attr("autocomplete", "off"); 

</script>