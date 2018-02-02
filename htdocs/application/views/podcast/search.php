<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('radio');?>">Radio list</a> <span class="divider"></span></li>
				<li>Search Result</li>
			</ul>
			
			<div class='row'>
				<div class='col-sm-9'>
					<?php
					$attributes = array('class' => 'form-inline');
					echo form_open(site_url('podcast/search'), $attributes);
					?>
						<div class="form-group">
					   	<input type="text" name="searchterm" class="form-control" placeholder="Search">
					  	</div>
					  	<div class="form-group">
					  		<select class="selectpicker" name="style_id" data-live-search="true">
					  		<option selected disabled >Style</option>
					  		<?php 
					  		foreach($this->style_model->get_all()->result() as $category){
					  			echo "<option value='".$category->id."'>".$category->name."</option>";	
					  		}
					  		?>
					  		</select>
					  	</div>
					  	<div class="form-group">
					  		<select class="selectpicker" name="artist_id" data-live-search="true">
					  		<option selected disabled>Artist</option>
					  		<?php 
					  		foreach($this->artist_model->get_all()->result() as $category){
					  			echo "<option value='".$category->id."'>".$category->name."</option>";	
					  		}
					  		?>
					  		</select>
					  	</div>
					  	<div class="form-group">
					  		<select class="selectpicker" name="album_id" data-live-search="true">
					  		<option selected disabled>Album</option>
					  		<?php 
					  		foreach($this->album_model->get_all()->result() as $category){
					  			echo "<option value='".$category->id."'>".$category->name."</option>";	
					  		}
					  		?>
					  		</select>
					  	</div>
					  	<div class="form-group">
					  		<select class="selectpicker" name="is_publish" data-live-search="false">
					  		<option selected disabled>Publish</option>
					  		<option value='0'>Track unpublish</option>
					  		<option value='1'>Track publish</option>
					  		</select>
					  	</div>
					  	<button type="submit" class="btn btn-default">Search</button>
					</form>
				</div>	
				<div class='col-sm-3'>
					<a href='<?php echo site_url('podcast/add');?>' class='btn btn-primary pull-right'><span class='glyphicon glyphicon-plus'></span> Add New Item</a>
				</div>
			</div>
			
			<br/>
			
			<!-- Message -->
			<?php if($this->session->flashdata('success')): ?>
				<div class="alert alert-success fade in">
					<?php echo $this->session->flashdata('success');?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>
			<?php elseif($this->session->flashdata('error')):?>
				<div class="alert alert-danger fade in">
					<?php echo $this->session->flashdata('error');?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>
			<?php endif;?>
			
			<table class="table table-striped table-bordered">
				<tr>
					<th>No</th>
					
					<th>Track name</th>
					<th>Artist</th>
					<th>Album</th>
					<th>Style</th>
					<th>Track file</th>

					<?php if(in_array('edit',$allowed_accesses)):?>
					<th>Edit</th>
					<?php endif;?>
					
					<?php if(in_array('delete',$allowed_accesses)):?>
					<th>Delete</th>
					<?php endif;?>
					<th>Publish</th>
					
					
					
				</tr>
							<?php
								if(!$count=$this->uri->segment(3))
									$count = 0;
								if(isset($items) && count($items->result())>0):
									foreach($items->result() as $item):					
							?>
						<tr>
							<td width="5%"><?php echo ++$count;?></td>
							
							<td width="20%"><?php echo $item->name; ?></td>
							<td width="10%"><?php echo $this->artist_model->get_info($item->artist)->name;?></td>
							<td width="10%"><?php echo $this->album_model->get_info($item->album)->name;?></td>
							<td width="10%"> <?php echo $this->style_model->get_info($item->style)->name;?></td>
							<td width="300">

							<li id="singleSongPlayer-<?php echo $count;?>" class="song-unit singleSongPlayer clearfix nobit" data-before="">

                                <div id="singleSong-jplayer-<?php echo $count;?>" class="singleSong-jplayer" data-title="" data-mp3="<?php echo s3_site_url('music/'.$item->file) ?>">
                                </div>
                                   <div class="playerPause">
		                             <span class="playit controls jp-controls-holder">
		                                <i class="jp-play pc-play"></i> 
		                                <i class="jp-pause pc-pause"></i>
		                              </span>
		                            </div>
		                             <span class="song-time jp-current-time" data-before="Time"></span>
		                             <span class="song-time jp-duration" data-before="Times"></span>
		                        
		                            <div class="audio-progress2">
		                                <div class="jp-seek-bar">
		                                    <div class="jp-play-bar" style="width:20%;"></div>
		                                </div><!--jp-seek-bar--> 
		                            </div><!--audio-progress--> 

                             </li>

							</td>
							
							<?php if(in_array('edit',$allowed_accesses)):?>
							<td><a href='<?php echo site_url("podcast/edit/".$item->id);?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php endif;?>
							
							<?php if(in_array('delete',$allowed_accesses)):?>
							<td><a href='<?php echo site_url("podcast/delete/".$item->id);?>'><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php endif;?>

							<td width="10%">
							<?php if($item->isPublish == 1):?>
								
									<button class="btn btn-sm btn-default unpublish"   
										itemId='<?php echo $item->id;?>'>Yes
									</button>
									
								<?php else:?>
								
									<button class="btn btn-sm btn-danger publish"
									itemId='<?php echo $item->id;?>'>No</button>
								
								<?php endif;?>
							</td>
							
							
							
							
						</tr>
						<?php
						endforeach;
					else:
				?>
						<tr>
							<td colspan='7'>There is no data for item.</td>
						</tr>
				<?php
					endif;
				?>
			</table>
			
			<?php 
				$this->pagination->initialize($pag);
				echo $this->pagination->create_links();
				
			?>

			<script>
			$(document).ready(function(){
				$(document).delegate('.publish','click',function(){
					
					var btn = $(this);
					var id = $(this).attr('itemId');
					
					$.ajax({
						url: '<?php echo site_url('podcast/publish');?>/'+id,
						method:'GET',
						success:function(msg){
							if(msg == 'true')
								btn.addClass('unpublish').addClass('btn-default')
									.removeClass('publish').removeClass('btn-danger')
									.html('Yes');
							else
								alert('System error occured. Please contact your system administrator.');
						}
					});
				});
				
				$(document).delegate('.unpublish','click',function(){
					
					var btn = $(this);
					var id = $(this).attr('itemId');
					
					$.ajax({
						url: '<?php echo site_url('podcast/unpublish');?>/'+id,
						method:'GET',
						success:function(msg){
							if(msg == 'true')
								btn.addClass('publish').addClass('btn-danger')
									.removeClass('unpublish').removeClass('btn-default')
									.html('No');
							else
								alert('System error occured. Please contact your system administrator.');
						}
					});
				});
				
				
				
			});
			</script>
			
			

