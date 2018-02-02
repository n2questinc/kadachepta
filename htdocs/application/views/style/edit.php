     <ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('style');?>">Style List</a> <span class="divider"></span></li>
				<li>Update style</li>
			</ul>
			
			<?php echo form_open_multipart('style/edit/'.$style->id); ?>
				<div class="row">
					<div class="col-sm-6">
						<legend>Style Information</legend>
						
						<div class="form-group">
							<label>Style Name</label>
							<input class="form-control" type="text" placeholder="Style Name" name='name' id='name' value='<?php echo $style->name;?>'>
						</div>
						<div class="form-group">
							<label>Image style</label>
							<img src="<?php echo s3_site_url( 'image/'.$style->image)?>" class="img-rounded" width="100" height="100"/>
							<?php $this->session->set_userdata('image', $style->image); ?>
							
						</div>
						<div class="form-group">
							<label>Upload Style Image</label>
							<input id="sfile" type="file" name="file">

							</div>
					</div>
				</div>
							
				
				<hr/>
				
				<button type="submit" class="btn btn-primary">Submit</button>
				<a href="<?php echo site_url('style');?>" class="btn">Cancel</a>
				<?php echo form_close(); ?>
			

			<script>
				$(document).ready(function(){
					$('#category-form').validate({
						rules:{
							name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url('style/exists/'.$style->id);?>'
							}
						},
						messages:{
							name:{
								required: "Please fill category name.",
								minlength: "The length of category name must be greater than 4",
								remote: "Category name is already existed in the system"
							}
						}
					});
				});
			</script>

