            <ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('album');?>">Album List</a> <span class="divider"></span></li>
				<li>Add new album</li>
			</ul>
			<?php echo form_open_multipart('album/add'); ?>
				<legend>Album Information</legend>
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label>Album Name</label>
								<input class="form-control" type="text" placeholder="Album Name" name='name' id='name'>
							</div>
							<div class="form-group">
							<label>Upload Album Cover</label>
							<input id="sfile" type="file" name="file">
							</div>
					</div>
				</div>
				<hr/>
				<button type="submit" class="btn btn-primary" value="upload" name="upload">Submit</button>
				<a href="<?php echo site_url('album');?>" class="btn">Cancel</a>
			<?php echo form_close(); ?>
			<script>
				$(document).ready(function(){
					$('#category-form').validate({
						rules:{
							name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url("album/exists");?>'
							}
						},
						messages:{
							name:{
								required: "Please fill Album Name.",
								minlength: "The length of Album Name must be greater than 4",
								remote: "Album Name is already existed in the system"
							}
						}
					});
				});
			</script>