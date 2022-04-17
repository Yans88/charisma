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
	
	
</style>


<?php 
$nama = !empty($member->nama) ? $member->nama : '';
$dob = !empty($member->dob) ? date('d-m-Y', strtotime($member->dob)) : '';
$email = !empty($member->email) ? $member->email : '';
$phone = !empty($member->phone) ? $member->phone : '';
// $cnt_point = !empty($member->total_point) ? (int)$member->total_point : 0; 
$cnt_point = !empty($member->total_point) ? number_format((int)$member->total_point,0,',','.') : 0; 
$img = !empty($member->photo) ? $member->photo : base_url('uploads/no_photo.jpg');

$address = !empty($member->address) ? $member->address : '';
$bergerak_dibidang = !empty($member->bergerak_dibidang) ? $member->bergerak_dibidang : '-';
$produk_biasa_dipakai = !empty($member->produk_biasa_dipakai) ? $member->produk_biasa_dipakai : '-';

$type = '';
if($member->type == 1){
	$type = 'B to B';
}
if($member->type == 2){
	$type = 'B to C';
}
?>

<div class="box box-success">

<div class="box-body">	
<div class='alert alert-info alert-dismissable' id="success-alert">
   
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
    <div id="id_text"><b>Welcome</b></div>
</div>

	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center">Image</th>
			<th colspan=2 style="vertical-align: middle; text-align:center">Information</th>
			
		</tr>
		<tr>
			<td class="h_tengah" style="vertical-align:middle; width:15%">
				
			<img height="200" width="200" src="<?php echo $img;?>"/> 			
			
			</td>
			
			<td class="h_tengah" style="vertical-align:middle; width:85%">
			<table class="table table-responsive">
				<tbody>
					<tr style="vertical-align:middle; text-align:left">
						<td style="width:15%;"><b>Name</b></td>						
						<td style="width:1%;">:</td>						
						<td>
							<?php echo ucwords($nama);?>
							
						</td>	
						<td style="width:20%;"><b>Point</b></td>		
						<td style="width:1%;">:</td>							
						<td>
							<?php echo $cnt_point;?>
						</td>
					</tr>	
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Email</b></td>
						<td style="width:1%;">:</td>	
						<td style="width:30%;">
							<?php echo $email;?>
						</td>	
						<td style="width:7%;"><b>Type</b></td>		
						<td style="width:1%;">:</td>							
						<td>
							<?php echo $type;?>
						</td>	
					</tr>
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Phone Number</b></td>
						<td style="width:1%;">:</td>
						<td style="width:20%;">
							<?php echo $phone;?>
						</td>
						<td style="width:20%;"><b>Bergerak dibidang</b></td>		
						<td style="width:1%;">:</td>							
						<td>
							<?php echo $bergerak_dibidang;?>
						</td>							
					</tr>
					
					
					
					
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Date of Birth</b></td>
						<td style="width:1%;">:</td>
						<td>
							<?php echo $dob;?>
						</td>	
						<td style="width:20%;"><b>Produk yang dipakai</b></td>		
						<td style="width:1%;">:</td>							
						<td>
							<?php echo $produk_biasa_dipakai;?>
						</td>
					</tr>
					
					<tr style="vertical-align:middle; text-align:left">
						<td><b>Address</b></td>
						<td style="width:1%;">:</td>
						<td colspan=4>
							<?php echo $address;?>
						</td>											
					</tr>
					
				</tbody>
			</table>
			</td>
			
			
			
		</tr>
		
	</tbody></table>
	
	<table class="table table-bordered table-reponsive">
		<tbody><tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center; width:50%;" >Point History</th>
			<th style="vertical-align: middle; text-align:center; width:50%;" >- History</th>
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			
			<?php
				if(count($point_history) > 0){
			?>
			
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					
					<?php 
					$date_point = '';
					foreach($point_history as $ph){
						$date_point = '';
						$date_point = date("d-M-y", strtotime($ph['tgl']));
						echo '<div class="direct-chat-info clearfix">';
						echo '<span class="direct-chat-text"><b>'.ucwords($ph['description']).' '.(int)$ph['nilai'].'</b><br/>'.$date_point.'</span>';
						echo '</div>';
					}
					?>
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>
			
			<?php } else {
					echo '<td align="center"><h3><b>Not Found ... !</b></h3></td>';
				}
			?>

			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					<?php 
					$date_point = '';
					foreach($transaksi as $t){
						$date_point = '';
						$date_point = date("d-M-y", strtotime($t['created_at']));
						echo '<div class="direct-chat-info clearfix">';
						echo '<span class="direct-chat-text"><b>ID Transaksi : #'.$t['id_transaksi'].'<br/> Rp.'.number_format($t['total'],2,',','.').'</b><br/>'.$date_point.'</span>';
						echo '</div>';
					}
					?>
					
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>	
				
		</tr>
	</tbody>
	</table>
	
	<table class="table table-bordered table-reponsive" style="display:none;">
		<tbody>
        <tr class="header_kolom">
			<th style="vertical-align: middle; text-align:center; width:33%;" >1st Downliner</th>
			<th style="vertical-align: middle; text-align:center; width:34%;" >2nd Downliner</th>
            <th style="vertical-align: middle; text-align:center; width:33%;" >3rd Downliner</th>
		</tr>
		
		<tr style="vertical-align:middle; text-align:left">
			
			<?php
				if(count($point_history) > 0){
			?>
			
			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					
					<?php 
					$i = 1;
					$photo = '';
					foreach($point_history as $ph){
						$photo = '';
						$date_point = '';
						$date_point = date("d-M-y", strtotime($ph['tgl']));
						echo '<div class="direct-chat-info clearfix">';
						echo '<span class="direct-chat-text"><b>'.ucwords($ph['description']).'</b><br/>'.$date_point.'</span>';
						echo '</div>';
					}
					?>
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>
			
			<?php } else {
					echo '<td align="center"><h3><b>Not Found ... !</b></h3></td>';
				}
			?>

			<td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					
					
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>	
            
            <td style="border:none;">
				
				<div class="box direct-chat direct-chat-warning">
                
               
                <div class="box-body">
                 
                  <div class="direct-chat-messages">
					
					
					

                  </div>
                 
                </div>
              
               
              </div>
			</td>	
				
		</tr>
	</tbody>
	</table>
		

</div>
<div class="box-footer" style="height:35px;">
	<div class="clearfix"></div>
	<div class="pull-right">
		<button type="button" class="btn btn-danger back"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>	
			
	</div>
</div>
</div>

<link href="<?php echo base_url(); ?>assets/magnific/magnific-popup.css" rel="stylesheet" type="text/css" />	

	<!-- jQuery 2.0.2 -->
<script src="<?php echo base_url(); ?>assets/magnific/jquery.magnific-popup.js"></script>		
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme_admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<script>
$("#success-alert").hide();
$('.back').click(function(){
	history.back();
});
$('.del_events').click(function(){
	var val = $(this).get(0).id;
	$('#del_id').val(val);
	$('#confirm_del').modal({
		backdrop: 'static',
		keyboard: false
	});
	$("#confirm_del").modal('show');
});
$('.yes_del').click(function(){
	var id = $('#del_id').val();
	var url = '<?php echo site_url('events/del_komentar');?>';
	$.ajax({
		data : {id : id},
		url : url,
		type : "POST",
		success:function(response){
			$('#confirm_del').modal('hide');
			$("#id_text").html('<b>Success,</b> Data telah dihapus');
			$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
				$("#success-alert").alert('close');
				location.reload();
			});			
		}
	});
	
});
</script>