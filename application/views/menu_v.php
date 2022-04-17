<!-- search form -->
<a href="<?php echo site_url();?>" class="logo">
			<!-- Add the class icon to your logo image or logo icon to add the margining -->
			 <div style="text-align:center; color:#01DF3A; font-weight:600;">Selamat Datang Dihalaman Administrator CHARISMAKU</div>
		</a>
<!-- /.search form -->

<ul class="sidebar-menu">
<li style="display:none;" class="<?php 
	 $menu_home_arr= array('home', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>home">
			<img height="20" src="<?php echo base_url().'assets/theme_admin/img/home.png'; ?>"> <span>Beranda</span>
		</a>
</li>



<li class="<?php 
	 $menu_home_arr= array('members', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>members">
			<i class="glyphicon glyphicon-stats"></i> <span>Members</span>
		</a>
</li>

<li  class="treeview <?php 
	 $menu_trans_arr= array('outlet','banner');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/data.png'; ?>">
		<span>Master Data</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
    
    	<li class="<?php if ($this->uri->segment(1) == 'banner' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>banner"><i class="fa fa-folder-open-o"></i> Banner</a></li>
    	<li class="<?php if ($this->uri->segment(1) == 'banner' && $this->uri->segment(2) == 'web'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>banner/web"><i class="fa fa-folder-open-o"></i> Banner Web</a></li>
	
		
		
		<li class="<?php if ($this->uri->segment(1) == 'outlet' && ($this->uri->segment(2) == '')){ echo 'active'; } ?>"><a href="<?php echo base_url();?>outlet"><i class="fa fa-folder-open-o"></i> Outlet </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'outlet' && ($this->uri->segment(2) == 'pabrik')){ echo 'active'; } ?>"><a href="<?php echo base_url();?>outlet/pabrik"><i class="fa fa-folder-open-o"></i> Pabrik </a></li>
		
	
	</ul>
</li>
<li  class="treeview <?php 
	 $menu_trans_arr= array('category');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Data Product</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
 
		<li class="<?php if ($this->uri->segment(1) == 'category' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>category"><i class="fa fa-folder-open-o"></i> Wholesale(B2B) </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'category' && $this->uri->segment(2) == 'retail'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>category/retail"><i class="fa fa-folder-open-o"></i> Retail(B2C) </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'category' && ($this->uri->segment(2) == 'product' || $this->uri->segment(2) == 'add_prod' || $this->uri->segment(2) == 'banner_product')){ echo 'active'; } ?>"><a href="<?php echo base_url();?>category/product"><i class="fa fa-folder-open-o"></i> Product </a></li>
		
	
	</ul>
</li>
<li  class="treeview <?php 
	 $menu_trans_arr= array('catalogue');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Data Catalogue</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'catalogue' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>catalogue"><i class="fa fa-folder-open-o"></i> e-Catalogue </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'catalogue' && $this->uri->segment(2) == 'category'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>catalogue/category"><i class="fa fa-folder-open-o"></i> Category-Catalogue </a></li>
	
	</ul>
</li>


<li class="<?php 
	 $menu_home_arr= array('chat', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>chat">
			<i class="glyphicon glyphicon-stats"></i> <span>Chat</span>
		</a>
</li>

<li  class="treeview <?php 
	 $menu_trans_arr= array('transaksi','appr','reject','dikirim');
	 if(in_array($this->uri->segment(1), $menu_trans_arr) && (in_array($this->uri->segment(2), $menu_trans_arr) || $this->uri->segment(2) == '')) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Transaksi B to B</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi"><i class="fa fa-folder-open-o"></i> Waiting </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'appr'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/appr"><i class="fa fa-folder-open-o"></i> Approve </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'reject'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/reject"><i class="fa fa-folder-open-o"></i> Reject </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'dikirim'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/dikirim"><i class="fa fa-folder-open-o"></i> Di kirimkan </a></li>
	
	</ul>
</li>

<li  class="treeview <?php 
	 $menu_trans_arr= array('bc','bc_appr','bc_reject','bc_dikirim');
	 if(in_array($this->uri->segment(2), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Transaksi B to c</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'bc'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/bc"><i class="fa fa-folder-open-o"></i> Waiting </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'bc_appr'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/bc_appr"><i class="fa fa-folder-open-o"></i> Approve </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'bc_reject'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/bc_reject"><i class="fa fa-folder-open-o"></i> Reject </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'transaksi' && $this->uri->segment(2) == 'bc_dikirim'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>transaksi/bc_dikirim"><i class="fa fa-folder-open-o"></i> Di kirimkan </a></li>
	
	</ul>
</li>


<li class="<?php 
	 $menu_home_arr= array('inquiry', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr) && $this->uri->segment(2) == '') {echo "active";}?>">
		<a href="<?php echo base_url(); ?>inquiry">
			<i class="glyphicon glyphicon-stats"></i> <span>Inquiry </span>
		</a>
</li>

<li class="<?php 
	 $menu_home_arr= array('sample');
	 if(in_array($this->uri->segment(2), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>inquiry/sample">
			<i class="glyphicon glyphicon-stats"></i> <span>Sample Request </span>
		</a>
</li>
<li class="<?php 
	 $menu_home_arr= array('news', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>news">
			<i class="glyphicon glyphicon-stats"></i> <span>News</span>
		</a>
</li>
<li class="hide treeview <?php 
	 $menu_trans_arr= array('redeem','');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<i class="glyphicon glyphicon-stats"></i>
		<span>Redeem</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	
	<li class="<?php if ($this->uri->segment(1) == 'redeem' && $this->uri->segment(2) == 'product'){ echo 'active'; } ?>"><a href="<?php echo base_url();?>redeem/product"><i class="fa fa-folder-open-o"></i> Product Redeem </a></li>
	
	<li class="<?php if ($this->uri->segment(1) == 'redeem' && $this->uri->segment(2) == ''){ echo 'active'; } ?>"><a href="<?php echo base_url();?>redeem"><i class="fa fa-folder-open-o"></i> Daftar Redeem</a></li>
    
   
	</ul>
</li>

<li class="<?php 
	 $menu_home_arr= array('user', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>user">
			<i class="glyphicon glyphicon-stats"></i> <span>Users</span>
		</a>
</li>
<li class="<?php 
	 $menu_home_arr= array('setting', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>setting">
			<i class="glyphicon glyphicon-stats"></i> <span>Setting</span>
		</a>
</li>



</ul>