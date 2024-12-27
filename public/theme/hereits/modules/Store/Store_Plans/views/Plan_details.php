<div class="content-header">
    <div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Plan Details</h1>
			</div><!-- /.col -->
			<div class="col-sm-6 m-hide">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_dashboard">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Store_Coupons">Plan_list</a></li>
					<li class="breadcrumb-item active"><?php echo $main_content; ?></li>
				</ol>
			</div>
        </div>
    </div>
</div>

<style>
	.real_price{
		font-weight: 700;
		color: #767676;
		font-size: 18px;
	}
	.discount_price{
		font-weight: 700;
		font-size: 20px;
	}
	.pName {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    word-break: break-word;
	padding-top: 4px;
}
table {
    border-spacing: 0;
    border-collapse: collapse;
}
.cartTotalWrp .itemText {
    text-align: right;
    width: 140px;
    text-align: left;
    width: 167px;
}
.cartTotalWrp tr td {
    padding-bottom: 10px;
    padding-left: 15px;
    padding-top: 15px;
}
td, th {
    padding: 0;
        padding-top: 0px;
        padding-bottom: 0px;
        padding-left: 0px;
}
.cartTotalWrp tr.ItemConvertedSubtotal td p, .cartTotalWrp tr.ItemNetSubtotal td p {
    margin-bottom: 0px;
}
.cartTotalWrp .itemAmount {
    font-weight: bold;
    padding-left: 30px;
}
.cartTotalWrp tr td.itemAmount p {
    font-size: 16px;
    color: #333;
}
.cartTotalWrp tr.ItemDiscountTotal td {
    padding-top: 0px;
}
.cartTotalWrp .ItemDiscountTotal .itemText p, #DiscountTotal {
    color: #f15922;
}
#DiscountTotal {
    color: #f15922;
}
tr.ItemNetSubtotal {
    border-top: 1px dashed #D7D7D7;
}
.cartTotalWrp tr.ItemConvertedSubtotal td p, .cartTotalWrp tr.ItemNetSubtotal td p {
    margin-bottom: 0px;
}
.cartTotalWrp tr.taxTotal td, .cartTotalWrp tr.ItemDiscountTotal td {
    padding-top: 0px;
}
.ItemTotalAfterDiscount {
    background: none;
    border-top: 1px dashed #D7D7D7;
}
.btn-primary {
    width: 100%;
	color: #fff !important;
	font-size: 20px;
	font-weight: bold;
	
}
</style>

<section class="content">
	<form action="<?= base_url() ?>Store_Plans/proceed_to_payment" method="post" class="row">	
	<input type="hidden" value="<?= $subscription->subscription_id ?>" name="subscription_id" >
		<div class="col-md-8">
            <div class="card ">
				<div class="card-header ">
					<div class="row">	
						<div class="col-md-4">
							<h3 class="card-title">Plan</h3>
						</div>
						<div class="col-md-4">
							<h3 class="card-title">Duration</h3>
						</div>
						<div class="col-md-4  text-center " >
							<h3 class="card-title" style="float: unset;">Price</h3>
						</div>
					</div>
				</div>
				<div class="card-body card-outline card-primary">
					<div class="row">	
						<div class="col-md-4">
							<p class=" pName"><?= $subscription->name ?></p>
						</div>
						<div class="col-md-4">
							<select class="form-control" name="month" onchange="total(<?= $subscription->subscription_id ?>,this.value)" required>
								<?php foreach($subscription->plans as $plans){ 
									$per_month = $plans->amount / $plans->month;
								?>
									<option  value="<?= $plans->month ?>" <?php if($select_month == $plans->month){echo 'selected';} ?>><?= $plans->month ?> Month</span> @  <span></span> <span class="rupee">&#8377;</span><span class="month-txt blc-clr"><?php echo round($per_month-($per_month * $plans->discount / 100)) ?></span></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-4 text-center">
							<del class="real_price" id="month_price">Rs. 0</del>
							<span class="discount_price" id="month_discount">Rs. 0</span>
						</div>
						<div class="col-md-12" style="border-top: 1px dashed #D7D7D7;margin-top: 15px;">
							<span class="discount_price" >Description</span>
							<p><?= $subscription->Description ?></p>
						</div>
					</div>
				</div>
            </div>
        </div>
		  
		<div class="col-md-4">
			<div class="card ">
				<div class="card-header ">
					<h3 class="card-title">Order Summary</h3>
				</div>
				<div class="card-body card-outline card-primary">
					<table class="cartTotalWrp" width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
							<tr class="ItemConvertedSubtotal">
								<td class="itemText" colspan="1">
									<p>Subtotal:</p>
								</td>
								<td class="itemAmount" colspan="1">
									<p id="CartTotal">Rs.0</p>
								</td>
							</tr>
							<tr class="ItemDiscountTotal" style="">
								<td class="itemText">
									<p>Discount:</p>
								</td>
								<td class="itemAmount">
									<p id="DiscountTotal">- Rs.0</p>
								</td>
							</tr>
							<tr class="ItemNetSubtotal" style="">
								<td class="itemText">
									<p>Net Amount:</p>
								</td>
								<td class="itemAmount">
									<p id="net_amount">Rs.0</p>
								</td>
							</tr>
							<tr class="taxTotal">
								<td class="itemText">
									<p>Tax<a href="#" onmouseover="return escape('Taxes applicable as per country')"><i class="glyphicon glyphicon-question-sign" style="margin-left:5px;"></i></a>:</p>
								</td>
								<td class="itemAmount">
									<p id="taxTotalCurrency">Rs.0</p>
								</td>
							</tr>
							<tr class="ItemTotalAfterDiscount">
								<td class="itemText">
									<p>Total Amount:</p>
								</td>
								<td class="itemAmount">
									<p id="TotalAmount">Rs.0</span></p>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" checked required>
                    <label class="form-check-label" for="exampleCheck1">Term And Condition</label>
                  </div>
					<div class="btnWrp">
						<button id="summary-btn" type="submit" class="btn-primary btn">proceed to payment</button>
					</div>
				</div>
            </div>
        </div>
	</form>
</section>

<script>

	total(<?= $subscription->subscription_id ?>,<?= $select_month ?>);
	function total(subscription_id, month){
		$.ajax({
				url:'<?= base_url() ?>Store_Plans/get_single_plan',
				method:"POST", 
				data:{ subscription_id:subscription_id, month:month },
				dataType: 'json',
				success:function(data)
				{  
					//alert(data.msg);
					$('#month_price').html('Rs. '+data.month_price);
					$('#month_discount').html('Rs. '+data.month_discount);
					$('#CartTotal').html('Rs. '+data.CartTotal);
					$('#DiscountTotal').html('Rs. '+data.DiscountTotal);
					$('#net_amount').html('Rs. '+data.net_amount);
					$('#taxTotalCurrency').html('Rs. '+data.taxTotalCurrency);
					$('#TotalAmount').html('Rs. '+data.TotalAmount);
					//window.location.href = data;
				},
				error: function(e){ 
					alertify.error("Somthing Wrong");
				} 
			});
	}
	
</script>	











	

	