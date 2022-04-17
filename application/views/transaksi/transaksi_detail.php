<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
	}
	.table > tbody > tr > td{
		vertical-align : middle;
	}
	
	.direct-chat-msg:before, .direct-chat-msg:after {
		content: " ";
		display: table;
	}
	:after, :before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	.direct-chat-msg:before, .direct-chat-msg:after {
		content: " ";
		display: table;
	}
	:after, :before {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	
	.direct-chat-messages, .direct-chat-contacts {
		-webkit-transition: -webkit-transform .5s ease-in-out;
		-moz-transition: -moz-transform .5s ease-in-out;
		-o-transition: -o-transform .5s ease-in-out;
		transition: transform .5s ease-in-out;
	}
	.direct-chat-messages {
		-webkit-transform: translate(0, 0);
		-ms-transform: translate(0, 0);
		-o-transform: translate(0, 0);
		transform: translate(0, 0);
		padding: 10px;
		height: 300px;
		overflow: auto;
	}
	
	.direct-chat-msg, .direct-chat-text {
		display: block;
	}	
	.direct-chat-info {
		display: block;
		margin-bottom: 2px;
		font-size: 12px;
	}
	
	.direct-chat-text:before {
		border-width: 8px !important;
		margin-top: 3px;
	}
	.direct-chat-text:before {
		position: absolute;
		right: 100%;		
		
		border-right-color: #d2d6de;
		content: ' ';
		height: 0;
		width: 0;
		pointer-events: none;
	}
	
	.direct-chat-text {
		display: block;
	}
	.direct-chat-text {
		border-radius: 5px;
		position: relative;
		padding: 5px 10px;
		background: #d2d6de;
		border: 1px solid #d2d6de;
		margin: 5px 0 0 5px;
		color: #444;
	}
	.direct-chat-warning .right>.direct-chat-text{
		background: #ddd;
		border-color: #ddd;
		color: #000;
	}
	.table-bordered {
		border: none;
	}
	
</style>

<?php 
$ds_val = !empty($transaksi->ds_val) ? $transaksi->ds_val.'%' : '0';
$promo_code = !empty($transaksi->promo_code) ? $transaksi->promo_code : '-';
$no_invoice = !empty($transaksi->no_invoice) ? $transaksi->no_invoice : 'INV/'.date('Y/m/d', strtotime($transaksi->created_at)).'/'.$transaksi->id_transaksi;
$nama_status = '';
$url = '';
if($transaksi->status == 1){
	$nama_status = 'Waiting';
	$url = site_url('transaksi');
}
if($transaksi->status == 2){
	$nama_status = 'Approved by '.$transaksi->fullname.' on '.date('d-m-Y H:i', strtotime($transaksi->status_date));
	$url = site_url('transaksi/appr');
}
if($transaksi->status == 3){
	$nama_status = 'Rejected by '.$transaksi->fullname.' on '.date('d-m-Y H:i', strtotime($transaksi->status_date));
	$url = site_url('transaksi/reject');
}
if($transaksi->status == 4){
	$nama_status = 'Send by '.$transaksi->fullname.' on '.date('d-m-Y H:i', strtotime($transaksi->status_date));
	$url = site_url('transaksi/reject');
}

$service_name = '';
if($transaksi->courir_service  == 1){
	$service_name = 'JNE Reg';					
}
if($transaksi->courir_service == 2){
	$service_name = 'JNE Express';					
}
if($transaksi->courir_service == 3){
	$service_name = 'Pick Up Store';					
}
$alamat = $transaksi->alamat.', '.$transaksi->nama_kota.','.$transaksi->nama_provinsi.' - '.$transaksi->kode_pos;
if($transaksi->type_transaksi == 2 && $transaksi->status == 1){
	$url = site_url('transaksi/bc');				
}
if($transaksi->type_transaksi == 2 && $transaksi->status == 2){
	$url = site_url('transaksi/bc_appr');				
}
if($transaksi->type_transaksi == 2 && $transaksi->status == 3){
	$url = site_url('transaksi/bc_reject');				
}
?>
<div class="modal fade" role="dialog" id="confirm_appr">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation Approve</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" class="id_trans" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-success yes_appr">Approve</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog" id="confirm_rej">
          <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><strong>Confirmation Reject</strong></h4>
              </div>
			 
              <div class="modal-body">
				<h4 class="text-center">Apakah anda yakin ? </h4>
				<input type="hidden" class="id_trans"" value="">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>               
                <button type="button" class="btn btn-warning yes_rej">Reject</button>               
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
</div>
<div class="box box-success">

<div class="box-body">	


	<table class="table table-bordered table-reponsive">
		<tbody>
		<tr>
        	
			<td class="h_tengah" style="vertical-align:middle;">
			<table class="table table-responsive">
				<tbody>
					<tr style="vertical-align:middle; text-align:left">
						<td style="width:15%;"><b>No. Transaksi</b></td>						
						<td style="width:1%;">:</td>						
						<td style="width:35%;"><?php echo $no_invoice;?></td>
                        <td><b>Status</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $nama_status;?>
						</td>
						
					</tr>
                    	
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Tanggal</b></td>		
						<td style="width:1%;">:</td>							
						<td><?php echo date('d-m-Y', strtotime($transaksi->created_at)).' '.date('H:i', strtotime($transaksi->created_at));?></td>
						<td style="width:10%;"><b>Reward</b></td>		
						<td style="width:1%;">:</td>							
						<td><?php echo !empty($transaksi->get_point) ? (int)$transaksi->get_point : '0';?> Point</td>	
					</tr>
					
					
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Nama Member</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $transaksi->nama;?>
							
						</td>	
						<td><b>Services</b></td>
						<td style="width:1%;">:</td>
						<td><?php echo $service_name;?>
						</td>
					</tr>
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Alamat Pengiriman </b></td>
						<td style="width:1%;">:</td>
						<td colspan=4><?php echo $alamat;?></td>											
					</tr>
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Notes</b></td>
						<td style="width:1%;">:</td>
						<td colspan=4><?php echo !empty($transaksi->notes) ? $transaksi->notes : '-';?></td>											
					</tr>
					
				</tbody>
			</table>
			</td>									
		</tr>
		
	</tbody></table>
    
	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center; width:50%;" >Daftar Item</th>
			
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			<table class="table table-bordered table-reponsive">
				<thead>
					<tr>
						<td style="text-align:center; width:4%"><b>No.</b></td>
						<td style="text-align:center; width:15%"><b>Item</b></td>
									
						<td style="text-align:center; width:13%"><b>Kategori - <br/>Sub Kategori</b></td>	
						<td style="text-align:center; width:10%"><b>Variant</b></td>		
						<td style="text-align:center; width:10%"><b>Type</b></td>		
						<td style="text-align:center; width:10%"><b>Harga</b></td>		
						<td style="text-align:center; width:8%"><b>Qty</b></td>		
						<td style="text-align:center; width:13%"><b>Total</b></td>
				   
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;						
						$type = '';						
						if(!empty($transaksi_detail)){
							foreach($transaksi_detail as $_td){
								$type = !empty($_td['type']) ? 'Crazy Sale' : '';
								echo '<tr>';
								echo '<td align="center">'.$i.'.</td>';
								echo '<td>'.$_td['nama_product'].'</td>';
								echo '<td>'.$_td['nama_kategori'].' - '.$_td['nama_subkategori'].'</td>';
								echo '<td>'.$_td['nama_variant'].'</td>';
								echo '<td>'.$type.'</td>';
								echo '<td align="right">'.number_format($_td['harga'],2,',','.').'</td>';
															
								echo '<td align="center">'.$_td['quantity'].'</td>';
								echo '<td align="right">'.number_format($_td['ttl_item'],2,',','.').'</td>';
														
								
								echo '</tr>';
								
								$i++;
							}
							
							
							echo '<tr style="border:none;">';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							
							echo '<td colspan=2><b>Biaya Kirim</b></td>';							
							echo '<td align="right"><b>'.number_format($transaksi->ongkir,2,',','.').'</b></td>';
							echo '</tr>';
							
							echo '<tr style="border:none;">';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							echo '<td style="border:none;"></td>';
							
							echo '<td colspan=2><b>Total</b></td>';							
							echo '<td align="right"><b>'.number_format($transaksi->total,2,',','.').'</b></td>';
							echo '</tr>';
							
						}
					?>
				</tbody>
			</table>
		
	
			
		
		</tr>
	</tbody>
	</table>
	
    

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger btn_back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>	
		<?php if($transaksi->status == 1){ ?>
			<button type="button" class="btn btn-success btn_appr"><i class="glyphicon glyphicon-ok"></i> Approve</button>	
			<button type="button" class="btn btn-warning btn_reject"><i class="glyphicon glyphicon-remove"></i> Reject</button>
		<?php } ?>		
	</div>
</div>
</div>

<link href="<?php echo base_url(); ?>assets/magnific/magnific-popup.css" rel="stylesheet" type="text/css" />	

	<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url(); ?>assets/magnific/jquery.magnific-popup.js"></script>		
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script>
$('.btn_back').click(function(){
	window.location = '<?php echo $url;?>';
});
var id_trans = '<?php echo $transaksi->id_transaksi;?>';
$('.btn_appr').click(function(){
	$('.id_trans').val(id_trans);
	$('#confirm_appr').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_appr").modal('show');
});

$('.btn_reject').click(function(){
	$('.id_trans').val(id_trans);
	$('#confirm_rej').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_rej").modal('show');
});

$('.yes_appr').click(function(){
	var id = $('.id_trans').val();
	var url = '<?php echo site_url('transaksi/upd_trans');?>';
	$.ajax({
		data : {id_transaksi : id, status : 2},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_appr').modal('hide');
			// $("#id_text").html('<b>Success,</b> Status transaksi telah diupdate');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				// location.reload();
			// });	
			alert('Success, Status transaksi telah diupdate');
			location.reload();
		}
	});	
});

$('.yes_rej').click(function(){
	var id = $('.id_trans').val();
	var url = '<?php echo site_url('transaksi/upd_trans');?>';
	$.ajax({
		data : {id_transaksi : id, status : 3},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_rej').modal('hide');
			// $("#id_text").html('<b>Success,</b> Status transaksi telah diupdate');
			// $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				// $("#success-alert").alert('close');
				// location.reload();
			// });
			alert('Success, Status transaksi telah diupdate');
			location.reload();			
		}
	});	
});
</script>