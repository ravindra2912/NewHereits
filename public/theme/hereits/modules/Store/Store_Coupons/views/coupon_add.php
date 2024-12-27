<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Coupon Detail</h1>
			</div><!-- /.col -->
			<div class="col-sm-6 m-hide">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_Coupons">Coupons_list</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Coupon Information</h3>
					</div>
					<form id="coupons_detail" action="<?php echo base_url(); ?>Store_Coupons/insert_coupon" method="POST" enctype="multipart/form-data">		
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Coupon Name <span class="error">*</span></label>
										<input type="text" name="coupon_name" class="form-control" placeholder="Coupon Name">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Coupon Code <span class="error">*</span></label>
										<input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Coupon Code">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Start Date <span class="error">*</span></label>
										<input type="date" name="coupon_start_date" id="coupon_start_date" class="form-control" placeholder="Coupon Start Date">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>End Date <span class="error">*</span></label>
										<input type="date" name="coupon_end_date" id="coupon_end_date" class="form-control" placeholder="Coupon End Date">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Coupon Discount Type <span class="error">*</span></label>
										<select class="form-control" name="coupon_discount_type" id="coupon_discount_type" onChange="checktype()" style="width: 100%;">
											<option value="">Select Coupon Discount Type</option>
											<option value="1">Amount</option>
											<option value="2">percentage(%)</option>
											
										</select>
									</div>
								</div>
								
								<div id="amount" class="col-sm-6" style="display: none;">
									<div class="form-group">
										<label >Coupon Amount <span class="error">*</span></label>
										<input type="number"id="coupon_amount" name="coupon_amount" class="form-control" placeholder="Coupon Amount">
									</div>
								</div>
								
								<div id="percentage" class="col-sm-6" style="display: none;">
									<div class="form-group">
										<label >Coupon Percent% <span class="error">*</span></label>
										<input type="number"id="coupon_percentage" name="coupon_percentage" class="form-control" placeholder="Coupon %">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Cart Minimum Amount <span class="error">*</span></label>
										<input type="number" name="cart_min_amount" id="cart_min_amount" class="form-control" placeholder="Cart Minimum Amount">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Cart Maximum Amount <span class="error">*</span></label>
										<input type="number" name="cart_max_amount" id="cart_max_amount" class="form-control" placeholder="Cart Maximum Amount">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Coupon Limit Per User <span class="error">*</span></label>
										<input type="number" name="coupon_per_user" class="form-control" placeholder="Coupon Limit Per User">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Total Number Of Coupon Limit <span class="error">*</span></label>
										<input type="number" name="coupon_limit" class="form-control" placeholder="Coupon Limit">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="coupon_free_shipping" id="checkboxPrimary1" value="1">
											<label for="checkboxPrimary1">
											Free Shipping
											</label>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="coupon_hide" id="coupon_hide" value="1">
											<label for="coupon_hide">
											Hide Coupon
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
										<label>Coupon Description<span class="error">*</span></label>
										<textarea name="coupon_description" class="form-control" placeholder="Product Description"></textarea>
									</div>
								</div>
								
							</div>
							
						
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
        </div>
	</div>
</section>

<!-- validation -->

<script>
	function checktype(){
	if ( $("#coupon_discount_type").val() == 2)
	{
		
		$("#amount").hide();
		$("#percentage").show();

	}else if($("#coupon_discount_type").val() == 1)
	{	
		
		$("#percentage").hide();
		$("#amount").show();
	}else {
		$("#percentage").hide();
		$("#amount").hide();
		
	}
}
</script>
<script>




	
//validation
$('#coupons_detail').validate({
		rules:{
			coupon_name:{
				required:true,
			},
			coupon_code:{
				required:true,
				remote:{
                    url:'<?php echo base_url(); ?>Store_Coupons/coupon_code_exists',
                    type:'post',
                    data:{coupon_code:function(){ return $("#coupon_code").val(); }}
				}
			},
			coupon_start_date:{
				required:true,
			},
			coupon_end_date:{
				required:true,
				dategreaterThan:"#coupon_start_date",
			},
			coupon_discount_type:{
				required:true,
			},
			
			cart_min_amount:{
				required:true,
			},
			coupon_amount:{
				required:true,
				number:true,
			},
			coupon_percentage:{
				required:true,
				number:true,
				 range: [1, 100],
			},
			
			cart_max_amount:{
				required:true,
				greaterThan: "#cart_min_amount",
			},
			coupon_limit:{
				required:true,
			},
			coupon_per_user:{
				required:true,
			},
			coupon_description:{
				required:true,
			},
		},
		messages:{
			coupon_name: {
				required: '<p style="color: red;">Please Enter Coupon Name.</p>',
			},
			coupon_code: {
				required: '<p style="color: red;">Please Enter Coupon Code.</p>',
				remote: '<p style="color: red;">Coupon Code Exist In Your Store.</p>',
			},
			coupon_start_date: {
				required: '<p style="color: red;">Please Select Coupon Start Date.</p>',
			},
			coupon_end_date: {
				required: '<p style="color: red;">Please Select Coupon End Date.</p>',
				dategreaterThan: '<p style="color: red;">End Date must be greater than Start Date.</p>',
			},
			coupon_discount_type: {
				required: '<p style="color: red;">Please Select Coupon Type.</p>',
			},
			coupon_amount:{
				required:'<p style="color: red;">Please Select Coupon Amount.</p>',
				number:'<p style="color: red;">Please Enter Number values only</p>',
			},
			coupon_percentage:{
				required:'<p style="color: red;">Please Select Coupon Percent %.</p>',
				number:'<p style="color: red;">Please Enter Number values only</p>',
				range:'<p style="color: red;">Please Enter % between  1 to 100</p>',
				
			},
			cart_min_amount: {
				required: '<p style="color: red;">Please Enter Cart Minimum Amount.</p>',
			},
			cart_max_amount: {
				required: '<p style="color: red;">Please Enter Cart Maximum Amount.</p>',
				greaterThan: '<p style="color: red;">Cart Maximum Amount must be greater than Cart Minimum Amount.</p>',
			},
			coupon_limit: {
				required: '<p style="color: red;">Please Enter Coupon Limit.</p>',
			},
			coupon_per_user: {
				required: '<p style="color: red;">Please Enter Coupon Limit Per User.</p>',
			},
			coupon_description: {
				required: '<p style="color: red;">Please Enter Coupon Description.</p>',
			},
			
		},
	}); 
jQuery.validator.addMethod("greaterThan",
	function (value, element, param) {
		var $min = $(param);

		if (this.settings.onfocusout) {
			$min
				.off(".validate-greaterThan")
				.on("blur.validate-greaterThan", function () {
					$(element).valid();
				});
		}

		return parseInt(value) > parseInt($min.val());
	},
);
jQuery.validator.addMethod("dategreaterThan", 
function(value, element, params) {

    if (!/Invalid|NaN/.test(new Date(value))) {
        return new Date(value) > new Date($(params).val());
    }

    return isNaN(value) && isNaN($(params).val()) 
        || (Number(value) > Number($(params).val())); 
},'Must be greater than {0}.');
</script>

	

	