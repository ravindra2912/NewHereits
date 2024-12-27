
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">EDIT TAGS</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-warning">
						<div class="card-header">
							<h3 class="card-title">Tags Update</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							 <form role="form" name="update_form" action="<?php echo base_url(); ?>Category_management/update_tags/<?= $id ?>" method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-sm-4">
										<!-- text input -->
										<div class="form-group">
											<label>Category Tags:</label> <span class="error">*</span>
											<input type="text" value="<?=$tags ?>"  name="category_tag" id="category_tag" class="tags_input" placeholder="Category Tags">
										</div>
									</div>
								</div>	
								<div class="card-footer">
									<button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>		
			
<script>

$(function(){
	
	$.ajax({
		url: '<? echo base_url(); ?>Category_management/get_tag',
		type: "POST",
		data:  {tag:'' },
		dataType: "json",
		success: function(res)
		{
			var category_tag = [];
			 //alert(res);
			for (var i = 0; i < res.length; i++) {
			  category_tag.push(res[i].tag);
			}
			
			$(".tags_input").tagComplete({
			
				keylimit: 1,
				hide: false,
				autocomplete: {
					data: category_tag
				}
		});
		},
		error: function(e){ 
			alert('Somthing Wron');
			console.log(e);
		}           
	});

	
});
</script>
