<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <head>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <!--[if gte mso 12]>
            > <style type="text/css">
            > [a.btn {
                padding:15px 22px !important;
                display:inline-block !important;
            }]
            > </style>
        > <![endif]-->
        <title>HEREits</title>
        <style type="text/css">
            .pborder{
				border-radius: 0.25em; 
				border-style: solid;
			}
        </style>
    </head>

<body>
	<img src="<?= base_url() ?>assets/Logo/bg_white-logo.jpg" height="40" style="background:#fff; "/>
   <table width="100%">
		<tr style="text-align: center;background-color: #d9d3d3;">
			<td style="background: #000;color: #FFF;">Referance Invoice</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
   </table>

	<table width="100%">
		<tr style="text-align: end;">
			<td>
				<table>
					<tr>
						<td>order id : <?= $order_detail->order_id ?></td>
					</tr>
					<tr>
						<td>order Date : <?php echo date("y-m-d", strtotime($order_detail->created_at)); ?></td>
					</tr>
					<tr>
						<td>order Status : 
							<?php 
								if($order_detail->order_status == 0){
								   echo 'Pending For Approver';
								}else if($order_detail->order_status == 1){
									echo 'Accept By Store';
								}else if($order_detail->order_status == 2){
									echo 'Reject By Store';
								}else if($order_detail->order_status == 3){
									echo 'Reject By User';
								}else if($order_detail->order_status == 4){
									echo 'Shipped';
								}else if($order_detail->order_status == 5){
									echo 'Return';
								}else if($order_detail->order_status == 6){
									echo 'Order completed';
								}else if($order_detail->order_status == 7){
									echo 'Cancel by Customer';
								}else if($order_detail->order_status == 8){
									echo 'Cancel By Store';
								}
							?>
						</td>
					</tr>
					<tr>
						<td>Delivery Type : 
							<?php 
								if($order_detail->delivery_type == 1){
									echo 'Pickup At Store';
								}else if($order_detail->delivery_type == 2){
									echo 'Home Delivery';
								}
							?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td>
				
			</td>
		</tr>
		<tr style="background-color: #EEE;width:100%">
			<td>From</td>
			<td>To</td>
		</tr>
		<tr>
			<td style="width:50%">
				<table>
					<tr>
						<td><strong><?= $order_detail->store->Store_name ?></strong></td>
					</tr>
					<tr>
						<td><?= $order_detail->store->store_address_2 ?></td>
					</tr>
					<tr>
						<td><?= $order_detail->store->store_address ?></td>
					</tr>
					<tr>
						<td>Phone : <?= $order_detail->store->store_contact ?></td>
					</tr>
					<tr>
						<td>Email : <?= $order_detail->store->store_email ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td style="width:50%">
				<table width="100%">
					<?php if($order_detail->delivery_type == 1){ ?>
						<tr>
							<td><strong><?= $order_detail->pickup_name  ?></strong></td>
						</tr>
						<tr>
							<td>
								<?php if($order_detail->pickup_by == 1){
										echo 'Pickup by self';
									}else if($order_detail->pickup_by == 2){
										echo 'pickup by other';
									}
								?>
							</td>
						</tr>
						<tr>
							<td><?= $order_detail->pickup_contact  ?></td>
						</tr>
					<?php }else if($order_detail->delivery_type == 2){ ?>
						<tr>
							<td><strong><?= $order_detail->user_address->name  ?></strong></td>
						</tr>
						<tr>
							<td><?= $order_detail->user_address->address1  ?></td>
						</tr>
						<tr>
							<td><?= $order_detail->user_address->address2  ?></td>
						</tr>
						<tr>
							<td><?= $order_detail->user_address->city  ?>, <?= $order_detail->user_address->state  ?>, <?= $order_detail->user_address->country  ?>- <?= $order_detail->user_address->pincode  ?></td>
						</tr>
						<tr>
							<td>Phone : <?= $order_detail->user_address->contact ?></td>
						</tr>
					<?php } ?>
						<tr>
							<td>&nbsp;</td>
						</tr>
			   </table>
			</td>
		</tr>
	</table>
	<table width="100%">
		<tr style="text-align: center;background-color: #EEE;">
			<td width="60%">Product</td>
			<td width="20%">QTY</td>
			<td width="20%">Price</td>
		</tr>
		 <?php foreach($order_detail->Order_items as $val){ ?>
		<tr style="text-align: center;">
			<td><?= $val->product_name ?></td>
			<td><?= $val->order_qty ?></td>
			<td>Rs. <?= $val->item_amount ?></td>
		</tr>
		<?php $total += $val->order_qty * $val->item_amount;
		  } ?>
		<tr style="text-align: center;">
			<td></td>
			<td style="background-color: #EEE;">Subtotal :</td>
			<td style="background-color: #EEE;">Rs. <?= $total ?></td>
		</tr>
		<tr style="text-align: center;">
			<td></td>
			<td style="background-color: #EEE;">Shipping :</td>
			<td style="background-color: #EEE;">Rs. <?= $order_detail->shipping_charge ?></td>
		</tr>
		<tr style="text-align: center;">
			<td></td>
			<td style="background-color: #EEE;">Discount <?php if($order_detail->coupon_id != NULL){ echo '('.$order_detail->coupon_code.')';} ?> :</td>
			<td style="background-color: #EEE;">Rs. <?php if($order_detail->coupon_id != NULL){ echo $order_detail->coupon_amount;}else{ echo '0.00'; } ?></td>
		</tr>
		<tr style="text-align: center;">
			<td></td>
			<td style="background-color: #EEE;">Total :</td>
			<td style="background-color: #EEE;">Rs. <?= $total - $order_detail->coupon_amount + $order_detail->shipping_charge ?></td>
		</tr>
	</table>
		
	<p style="font-size: 10px;">
		 note: this invoice is only for referance perpose. hereits.com doese not liable for any mistack,claims,guarantee, waranty of product,pricing or anything mentioned in this invoice. ask store to give origional invoice of products you purchaser from the store.
	</p>
</body>

</html>













