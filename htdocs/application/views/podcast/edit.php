<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('podcast');?>">Track List</a> <span class="divider"></span></li>
				<li>Update Track</li>
			</ul>
		
			<?php
			$attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
			echo form_open(site_url("podcast/edit/".$item->id), $attributes);
			?>
			
				<legend>Track Information</legend>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label>Track Name</label>
								<input class="form-control" type="text" placeholder="Item Name" name='name' id='name'
								 value="<?php echo $item->name;?>">
							</div>
							
							<div class="form-group">
								<label>Artist</label><br/>
								<select class="selectpicker" name="artist_id" data-live-search="true">
								<?php
									foreach($this->artist_model->get_all()->result() as $cat){
										echo "<option value='".$cat->id."'";
										if($item->artist == $cat->id) 
											echo " selected ";
										echo ">".$cat->name."</option>";
									}
								?>
								</select>
							</div>
							<div class="form-group">
								<label>Album</label><br/>
								<select class="selectpicker" name="album_id" data-live-search="true">
								<?php
									foreach($this->album_model->get_all()->result() as $cat){
										echo "<option value='".$cat->id."'";
										if($item->album == $cat->id) 
											echo " selected ";
										echo ">".$cat->name."</option>";
									}
								?>
								</select>
							</div>
							<div class="form-group">
								<label>Style</label><br/>
								<select class="selectpicker" name="style_id" data-live-search="true">
								<?php
									foreach($this->style_model->get_all()->result() as $cat){
										echo "<option value='".$cat->id."'";
										if($item->style == $cat->id) 
											echo " selected ";
										echo ">".$cat->name."</option>";
									}
								?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Track url</label>
								<input class="form-control" type="text" placeholder="Item Name" name='url_track' id='url_track'
								 value="<?php echo $item->file;?>" readonly>
							</div>

							<li id="singleSongPlayer-1" class="song-unit singleSongPlayer clearfix nobit" data-before="1">

                                <div id="singleSong-jplayer-1" class="singleSong-jplayer" data-title="" data-mp3="<?php echo s3_site_url('music/'.$item->file) ?>">
                                </div>

                              
                                <div class="playerPause">
		                        <span class="playit controls jp-controls-holder">
		                            <i class="jp-play pc-play"></i> 
		                            <i class="jp-pause pc-pause"></i>
		                        </span>
		                        </div>
		                        <span class="song-time jp-duration2" data-before="Time"></span>
		                        
		                            <div class="audio-progress2">
		                                <div class="jp-seek-bar">
		                                    <div class="jp-play-bar" style="width:20%;"></div>
		                                </div><!--jp-seek-bar--> 
		                            </div><!--audio-progress--> 

		                        
		                        
		                       

		                           
                             </li><!--song-->

                             <div class="checkbox-inline"></div>

						</div>
						
				</div>
				
				<input type="submit" value="Update" class="btn btn-primary"/>
				
				<a href="<?php echo site_url('podcast');?>" >Cancel</a>
			</form>

			<!--<script>
				$(document).ready(function(){
					$('#item-form').validate({
						rules:{
							name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url('podcast/exists/'.$item->id);?>'
							}
						},
						messages:{
							name:{
								required: "Please fill item name.",
								minlength: "The length of item name must be greater than 4",
								remote: "item name is already existed in the system"
							}
						}
					});
				});
			</script>-->

