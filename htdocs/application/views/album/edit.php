            <ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('album');?>">Album List</a> <span class="divider"></span></li>
				<li>Update album</li>
			</ul>
			<?php echo form_open_multipart('album/edit/'.$albums->id); ?>
				<div class="row">
					<div class="col-sm-6">
						<legend>Album Information</legend>
						<div class="form-group">
							<label>Album Name</label>
							<input class="form-control" type="text" placeholder="Album Name" name='name' id='name' value='<?php echo $albums->name;?>'>
						</div>
						<div class="form-group">
							<label>Image album</label><br/>
							<img src="<?php echo s3_site_url( 'album/'.$albums->image)?>" class="img-rounded" width="100" height="100"/>
							<?php $this->session->set_userdata('image', $albums->image); ?>
						</div>
						<div class="form-group">
							<label>Upload Album Image</label>
							<input id="sfile" type="file" name="file">
						</div>
					</div>
				</div>
				<hr/>
				<button type="submit" class="btn btn-primary">Submit</button>
				<a href="<?php echo site_url('album');?>" class="btn">Cancel</a>
				<?php echo form_close(); ?>
				<script>
					$(document).ready(function(){
						$('#category-form').validate({
							rules:{
								name:{
									required: true,
									minlength: 4,
									remote: '<?php echo site_url('album/exists/'.$albums->id);?>'
								}
							},
							messages:{
								name:{
									required: "Please fill album name.",
									minlength: "The length of category name must be greater than 4",
									remote: "Category name is already existed in the system"
								}
							}
						});
					});
				</script>

