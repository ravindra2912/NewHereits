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
										<select class="form-control" name="coupon_discount_type" id="product_parent_category" style="width: 100%;">
											<option value="">Select Coupon Discount Type</option>
											<option value="1">Amount</option>
											<option value="2">percentage(%)</option>
											
										</select>
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Coupon Amount <span class="error">*</span></label>
										<input type="number" name="coupon_amount" class="form-control" placeholder="Coupon Amount">
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
										<label>Coupon Limit Per User </label>
										<input type="number" name="coupon_per_user" class="form-control" placeholder="Coupon Limit Per User">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Coupon Limit</label>
										<input type="number" name="coupon_limit" class="form-control" placeholder="Coupon Limit">
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="form-group clearfix">
										<div class="icheck-primary d-inline">
											<input type="checkbox" name="coupon_free_shipping" id="checkboxPrimary1" value="1">
											<label for="checkboxPrimary1">
											Free Shippimg
											</label>
										</div>
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
										<label>Coupon Description</label>
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
			coupon_amount:{
				required:true,
			},
			cart_min_amount:{
				required:true,
			},
			cart_max_amount:{
				required:true,
				greaterThan: "#cart_min_amount",
			},
		},
		messages:{
			coupon_name: {
				required: 'Please Enter Coupon Name.',
			},
			coupon_code: {
				required: 'Please Enter Coupon Code.',
				remote: 'Coupon Code Exist In Your Store.',
			},
			coupon_start_date: {
				required: 'Please Select Coupon Start Date.',
			},
			coupon_end_date: {
				required: 'Please Select Coupon End Date.',
				dategreaterThan: 'End Date must be greater than Start Date.',
			},
			coupon_discount_type: {
				required: 'Please Select Coupon Type.',
			},
			coupon_amount: {
				required: 'Please Enter Coupon Amount.',
			},
			coupon_amount: {
				required: 'Please Enter Coupon Amount.',
			},
			cart_min_amount: {
				required: 'Please Enter Cart Minimum Amount.',
			},
			cart_max_amount: {
				required: 'Please Enter Cart Maximum Amount.',
				greaterThan: 'Cart Maximum Amount must be greater than Cart Minimum Amount.',
			},
			
		},
	}); 
	jQuery.validator.addMethod(
	"greaterThan",
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
	

	