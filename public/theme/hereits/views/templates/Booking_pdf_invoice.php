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
						<td>Booking id : <?= $booking_detail->booking_id ?></td>
					</tr>
					<tr>
						<td>Booking Date : <?php echo date("y-m-d", strtotime($booking_detail->created_at_date)); ?></td>
					</tr>
					<tr>
						<td>Booking Status : 
							<?php 
								if($booking_detail->booking_status == 0){
								   echo 'Pending For Approver';
								}else if($booking_detail->booking_status == 1){
									echo 'Accept By Store';
								}else if($booking_detail->booking_status == 2){
									echo 'Reject By Store';
								}else if($booking_detail->booking_status == 3){
									echo 'Reject By Customer';
								}else if($booking_detail->booking_status == 4){
									echo 'OnGoing';
								}else if($booking_detail->booking_status == 5){
									echo 'Return';
								}else if($booking_detail->booking_status == 6){
									echo 'Service completed';
								}else if($booking_detail->booking_status == 7){
									echo 'Cancel by Customer';
								}else if($booking_detail->booking_status == 8){
									echo 'Cancel By Store';
								}
							?>
						</td>
					</tr>
					<tr>
						<td>Service Type : 
							<?php 
								if($booking_detail->service_type == 1){
									echo 'As Service Provider Address';
								}else if($booking_detail->service_type == 2){
									echo 'At Your Address';
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
						<td><strong><?= $booking_detail->store->Store_name ?></strong></td>
					</tr>
					<tr>
						<td><?= $booking_detail->store->store_address_2 ?></td>
					</tr>
					<tr>
						<td><?= $booking_detail->store->store_address ?></td>
					</tr>
					<tr>
						<td>Phone : <?= $booking_detail->store->store_contact ?></td>
					</tr>
					<tr>
						<td>Email : <?= $booking_detail->store->store_email ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td style="width:50%">
				<table width="100%">
					<?php if($booking_detail->service_type == 1){ ?>
						<tr>
							<td><strong><?= $booking_detail->customer_name  ?></strong></td>
						</tr>
						<tr>
							<td>
								<?php if($booking_detail->service_by == 1){
										echo 'Service by self';
									}else if($booking_detail->service_by == 2){
										echo 'Service by other';
									}
								?>
							</td>
						</tr>
						<tr>
							<td><?= $booking_detail->customer_contact  ?></td>
						</tr>
					<?php }else if($booking_detail->service_type == 2){ ?>
						<tr>
							<td><strong><?= $booking_detail->user_address->name  ?></strong></td>
						</tr>
						<tr>
							<td><?= $booking_detail->user_address->address1  ?></td>
						</tr>
						<tr>
							<td><?= $booking_detail->user_address->address2  ?></td>
						</tr>
						<tr>
							<td><?= $booking_detail->user_address->city  ?>, <?= $booking_detail->user_address->state  ?>, <?= $booking_detail->user_address->country  ?>- <?= $booking_detail->user_address->pincode  ?></td>
						</tr>
						<tr>
							<td>Phone : <?= $booking_detail->user_address->contact ?></td>
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
			<td width="60%">Services</td>
			<td width="20%">QTY</td>
			<td width="20%">Price</td>
		</tr>
		 <?php foreach($booking_detail->Booking_items as $val){ ?>
		<tr style="text-align: center;">
			<td><?= $val->Package_name ?></td>
			<td><?= $val->booking_qty ?></td>
			<td>Rs. <?= $val->item_amount ?></td>
		</tr>
		<?php $total += $val->booking_qty * $val->item_amount;
		  } ?>
		<tr style="text-align: center;">
			<td></td>
			<td style="background-color: #EEE;">Subtotal :</td>
			<td style="background-color: #EEE;">Rs. <?= $total ?></td>
		</tr>
		<tr style="text-align: center;">
			<td></td>
			<td style="background-color: #EEE;">Service Charge :</td>
			<td style="background-color: #EEE;">Rs. <?= $booking_detail->service_charge ?></td>
		</tr>
		<tr style="text-align: center;">
			<td></td>
			<td style="background-color: #EEE;">Discount <?php if($booking_detail->coupon_id != NULL){ echo '('.$booking_detail->coupon_code.')';} ?> :</td>
			<td style="background-color: #EEE;">Rs. <?php if($booking_detail->coupon_id != NULL){ echo $booking_detail->coupon_amount;}else{ echo '0.00'; } ?></td>
		</tr>
		<tr style="text-align: center;">
			<td></td>
			<td style="background-color: #EEE;">Total :</td>
			<td style="background-color: #EEE;">Rs. <?= $total - $booking_detail->coupon_amount +  $booking_detail->service_charge ?></td>
		</tr>
	</table>
		
	<p style="font-size: 10px;">
		 note: this invoice is only for referance perpose. hereits.com doese not liable for any mistack,claims,guarantee, waranty of service,pricing or anything mentioned in this invoice. ask store to give origional invoice of products you purchaser from the store.
	</p>
</body>

</html>













