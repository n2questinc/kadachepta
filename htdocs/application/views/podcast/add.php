

			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('podcast');?>">Podcast list</a> <span class="divider"></span></li>
				<li>Add Podcast</li>
			</ul>
			
			<?php echo form_open_multipart('podcast/add'); ?>
			
				<legend>Radio podcast</legend>
					
				<div class="row">
					<div class="col-sm-6">
							

							<div class="form-group">
								<label>Track's style</label><br/>
								<select class="selectpicker" name="style_id" data-live-search="true">
								<?php
									foreach($this->style_model->get_all()->result() as $style)
										echo "<option value='".$style->id."'>".$style->name."</option>";
								?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Album</label><br/>
								<select class="selectpicker" name="album_id" data-live-search="true">
								<?php
									foreach($this->album_model->get_all()->result() as $album)
										echo "<option value='".$album->id."'>".$album->name."</option>";
								?>
								</select>
							</div>
							
							<div class="form-group">
							<label>Upload mp3 track. File Upload and File processing can take some time. Do not close the browser tab. <span>Warning! Track must be format "Artist - Track name.mp3" </span></label>
							
							<div class="dropzone">
									<div class="dz-message">
										<h4> Drag and Drop track file</h4>
									</div>
								</div>

    						

							</div>
					</div>
					
					
				</div>
				
				<input type="submit" name="save" value="Save" class="btn btn-primary"/>
				<a href="<?php echo site_url('podcast');?>" class="btn">Cancel</a>

			<?php echo form_close(); ?>

			<script>
			$(document).ready(function(){
				$('#item-form').validate({
					rules:{
						name:{
							required: true,
							minlength: 4,
							remote: '<?php echo site_url("podcast/exists");?>'
						}
					},
					messages:{
						name:{
							required: "Please fill item Name.",
							minlength: "The length of item Name must be greater than 4",
							remote: "item Name is already existed in the system"
						}
					}
				});
			});
			</script>
			<script type="text/javascript">
		Dropzone.autoDiscover = false;
		var file= new Dropzone(".dropzone",{
			url: "<?php echo base_url('podcast/upload_files') ?>",
			 maxFilesize: 500,  // maximum size to uplaod 
			method:"post",
			uploadMultiple: true,
			// acceptedFiles:"image/*", // allow only images
			paramName:"userfile",
			// dictInvalidFileType:"Image files only allowed", // error message for other files on image only restriction 
			addRemoveLinks:true,
			parallelUploads: 1,
            maxFiles: 200,

			//data: {"<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>"}
		});
			//Upload file onchange 
			file.on("sending",function(a,b,c){
				a.token=Math.random();
				countAll = this.files.length;

				c.append("token",a.token); //Random Token generated for every files 
				c.append("count",countAll); //Random Token generated for every files
				
			});
			// delete on upload 
			file.on("removedfile",function(file){

				var name = file.name;

				$.ajax({
					type: "post",
					url: "<?php echo base_url('podcast/deletez') ?>",
					data: { file: name },
					dataType: 'json',
					success: function(res){
						// alert('Selected file removed !');			
					}
				});
				/*var token=a.token;
				
				$.ajax({
					type:"post",
					data:{token:token},
					url:"<?php echo base_url('category/deletez') ?>",
					cache:false,
					dataType: 'json',
					success: function(res){
						// alert('Selected file removed !');			
					}
				});*/
			});
			</script>

			
			
			

