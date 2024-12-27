<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">FAQ list</li>
              <li class="breadcrumb-item active"><?php echo $left_sidebar; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
	
	<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">ADD FAQ</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" name="add" action="<?php echo base_url(); ?>Faq_management/insert_faq" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="question">Enter Question</label>
                    <input type="question" class="form-control" name="question" id="question" placeholder="Enter Question">
                  </div>
				  
                  <div class="form-group">
                        <label>Enter Answer</label>
                        <textarea class="form-control" name="answer" id="answer" rows="3" placeholder="Enter Answer..."></textarea>
                  </div>
				  
				  <div class="form-group">
						<label>Select category</label>
                        <select name="type" id="type" class="form-control">
                          <option value="">Select Category</option>
                          <option value="1">Product</option>
                          <option value="2">Services</option>
						  <option value="3">General</option>
                          <option value="4">Order</option>
                          <option value="5">Delivery</option>
                          </select>
                  </div>
                  
                  <div class="form-group">
                        <label>Select Status</label>
                        <select name="status" id="status" class="form-control">
                          <option value="">Select Status</option>
                          <option value="1">Active</option>
                          <option value="0">Deactive</option>
                          </select>
				  </div>		  
				  
				  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

            

          </div>
         
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
	
	<script>
				// Wait for the DOM to be ready
		$(function() {
			$("form[name='add']").validate(
			{
				rules: {
					question: {
					required: true,
					},
					
					answer: {
					  required: true,
					  minlength: 15
					},
					
					type: {
					  required: true,
					},
						
					status: {
					  required: true,
					},	
					
				},
		   
			messages: 
			{
				question: '<p> *Please enter Question</p>',
								
				answer: '<p> *Please enter your answer</p>',
								
				type: {
				  required:'<p> *Please select Category</p>'
				},
				
				status: {
				  required:'<p> *Please select Status</p>'
				},
				
			},
			  
			submitHandler: function(form) {
				form.submit();
			}
		});
	});
	</script>