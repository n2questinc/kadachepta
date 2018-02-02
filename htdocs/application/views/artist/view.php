            <ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li>Artist List</li>
			</ul>
			
			<div class='row'>
				<div class='col-sm-9'>
					<?php
					$attributes = array('class' => 'form-inline');
					echo form_open(site_url('artist/search'), $attributes);
					?>
						<div class="form-group">
					   	<input type="text" name="searchterm" class="form-control" placeholder="Search">
					  	</div>
					  	<button type="submit" class="btn btn-default">Search</button>
					</form>
				</div>	
				<div class='col-sm-3'>
					<a href='<?php echo site_url('artist/add');?>' class='btn btn-default pull-right'><span class='glyphicon glyphicon-plus'></span> Add artist</a>
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
					<th>Image artist</th>
					<th>Artist name</th>
					
					<?php if(in_array('edit',$allowed_accesses)):?>
					<th>Edit</th>
					<?php endif;?>
					
					<?php if(in_array('delete',$allowed_accesses)):?>
					<th>Delete</th>
					<?php endif;?>
					
					
				</tr>
				<?php
					if(!$count=$this->uri->segment(3))
						$count = 0;
					if(isset($artists) && count($artists->result())>0):
						foreach($artists->result() as $artist):					
				?>
						<tr>

							<td><?php echo ++$count;?></td>
							<td><img src="<?php echo s3_site_url( 'artist/'.$artist->image)?>" class="img-rounded" width="100" height="100"/></td>
							<td><?php echo $artist->name;?></td>
							
							<?php if(in_array('edit',$allowed_accesses)):?>
							<td><a href='<?php echo site_url("artist/edit/".$artist->id);?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php endif;?>
							
							<?php if(in_array('delete',$allowed_accesses)):?>
							<td><a class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $artist->id;?>"><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php endif;?>
							
							
						</tr>
						<?php
						endforeach;
					else:
				?>
						<tr>
							<td colspan='7'>There is no data for artist.</td>
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
			
				
				$('.btn-delete').click(function(){
					var id = $(this).attr('id');
					var btnYes = $('.btn-yes').attr('href');
					var btnNo = $('.btn-no').attr('href');
					$('.btn-yes').attr('href',btnYes+"/"+ id);
					$('.btn-no').attr('href',btnNo+"/"+ id);
				});
			
			</script>
			
			<div class="modal fade"  id="myModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title">Deleting Artist</h4>
						</div>
						<div class="modal-body">
							<p>Do you want to delete artist?</p>
						</div>
						<div class="modal-footer">
							<!--<a type="button" class="btn btn-default btn-yes" href='<?php echo site_url("artist/delete_items/");?>'>Yes</a>-->
							<a type="button" class="btn btn-default btn-yes" href='<?php echo site_url("artist/delete/");?>'>Yes</a>
							<a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->