
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('style');?>">Style List</a> <span class="divider"></span></li>
				<li>Add new music style</li>
			</ul>
			<?php echo form_open_multipart('style/add'); ?>
				<legend>Style Information</legend>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label>Style Name</label>
								<input class="form-control" type="text" placeholder="Category Name" name='name' id='name'>
							</div>
							
							<div class="form-group">
							<label>Upload Style Cover</label>
							
							<input id="sfile" type="file" name="file">

							</div>
					</div>
				</div>
				
				<hr/>
				
				<button type="submit" class="btn btn-primary" value="upload" name="upload">Submit</button>
				
				<a href="<?php echo site_url('style');?>" class="btn">Cancel</a>
			<?php echo form_close(); ?>

			<script>
				$(document).ready(function(){
					$('#category-form').validate({
						rules:{
							name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url("style/exists");?>'
							}
						},
						messages:{
							name:{
								required: "Please fill Category Name.",
								minlength: "The length of Category Name must be greater than 4",
								remote: "Category Name is already existed in the system"
							}
						}
					});
				});
			</script>
