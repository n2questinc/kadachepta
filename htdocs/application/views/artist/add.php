            <ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('artist');?>">Artist List</a> <span class="divider"></span></li>
				<li>Add new artist</li>
			</ul>
			<?php echo form_open_multipart('artist/add'); ?>
				<legend>Artist Information</legend>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label>Artist Name</label>
								<input class="form-control" type="text" placeholder="Category Name" name='name' id='name'>
							</div>
							
							<div class="form-group">
							<label>Upload Artist Cover</label>
							
							<input id="sfile" type="file" name="file">

							</div>
					</div>
				</div>
				
				<hr/>
				
				<button type="submit" class="btn btn-primary" value="upload" name="upload">Submit</button>
				
				<a href="<?php echo site_url('artist');?>" class="btn">Cancel</a>
			<?php echo form_close(); ?>

			<script>
				$(document).ready(function(){
					$('#category-form').validate({
						rules:{
							name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url("artist/exists");?>'
							}
						},
						messages:{
							name:{
								required: "Please fill Artist Name.",
								minlength: "The length of Artist Name must be greater than 4",
								remote: "Artist Name is already existed in the system"
							}
						}
					});
				});
			</script>