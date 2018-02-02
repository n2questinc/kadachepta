<?php $this->load->view('panel/header');?>
<?php $this->load->view('panel/nav');?>

<div class="container-fluid">
	<div class="row">
		<?php $this->load->view('panel/sidebar');?>
		<div class="content-wrapper" style="min-height: 797px; padding-left:32px; padding-right:32px">
		<?php echo $content;?>
		</div>
	</div>
</div>

<?php $this->load->view('panel/footer');?>