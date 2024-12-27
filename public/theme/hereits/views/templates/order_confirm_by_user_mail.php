<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title>Hereits</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">
    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 9 - 26 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
    <!--[if mso]>
		<style>
			* {
				font-family: sans-serif !important;
			}
		</style>
	<![endif]-->

    <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
    <!--[if !mso]><!-->
    <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,675' rel='stylesheet' type='text/css'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

   

</head>

<body bgcolor="#f5f5f5" width="100%" style="margin: 0;">
    <center style="width: 100%;">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto; margin-top: 10px;margin-bottom: 10px;" class="email-container">

            <!-- Header start -->
            <tr>
                <td align="center" valign="top" style="padding:22px 0;background: #000000;border-top-left-radius: 10px;border-top-right-radius: 10px;" class="header-padding">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td align="center" valign="middle" class="logo-top-bottom"><a href="#"><img mc:edit="logo-main" src="<?= base_url() ?>assets/Logo/white-text-logo.png" width="100" alt="Hereits"></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Header End -->

            <!-- Content start -->
             <tr>
                <td>
                    <table class="content-main-table" style="background: #ffffff;" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="td-top-botom" align="left" style="border-bottom: 1px solid #e5e5e5; margin: 0 55px; padding:22px 0;">
                                <h5 style="margin: 0; font: bold 16px -apple-system,Helvetica,Arial,sans-serif;  color: #33373d; text-transform:uppercase;"> <strong style="text-transform: capitalize;">Hello,</strong> <?= $username ?></h5>
                                <p style="font-size:14px;font-family: -apple-system,Helvetica,Arial,sans-serif;color: #33373d; line-height: 22px;margin-top: 20px;">Your order from <b><?= $Store_name ?></b> is confirmed by store. You'll receive an email when your items are ready to delivery. If you have any questions, please contact store.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-left: auto; margin-right: auto;">
									<tr style="text-align: center;background-color: #EEE;">
										<td width="20%">Image</td>
										<td width="50%">Product</td>
										<td width="30%">QTY</td>
									</tr>
									 <?php foreach($order_item as $val){ ?>
									<tr style="text-align: center;">
										<td style="padding: 10px 0px 10px 0px;"><img src="<?= base_url().$val->image_url ?>" height="60" width="60 />"</td> 
										<td style="padding: 10px 0px 10px 0px;"><?= $val->product_name ?></td>
										<td style="padding: 10px 0px 10px 0px;"><?= $val->order_qty ?> * <?= $val->item_amount ?></td>
									</tr>
									<?php $total += $val->order_qty * $val->item_amount;
									  } ?>
									<tr style="text-align: center;">
										<td style="background-color: #fff;"></td>
										<td style="background-color: #EEE; padding: 5px 0px 5px 0px;">Subtotal </td> 
										<td style="background-color: #EEE; padding: 5px 0px 5px 0px;">Rs. <?= $total ?></td>
									</tr>
									<tr style="text-align: center;">
										<td style="background-color: #fff;"></td>
										<td style="background-color: #EEE; padding: 5px 0px 5px 0px; ">Shipping </td>
										<td style="background-color: #EEE; padding: 5px 0px 5px 0px; ">Rs. <?= $shipping_charge ?></td>
									</tr>
									<tr style="text-align: center;">
										<td style="background-color: #fff;"></td>
										<td style="background-color: #EEE; padding: 5px 0px 5px 0px;">Discount <?php if($coupon_id != NULL){ echo '('.$coupon_code.')';} ?> </td>
										<td style="background-color: #EEE; padding: 5px 0px 5px 0px;">Rs. <?php if($coupon_id != NULL){ echo $coupon_amount;}else{ echo '0.00'; } ?></td>
									</tr>
									<tr style="text-align: center;">
										<td style="background-color: #fff;"></td>
										<td style="background-color: #EEE; padding: 5px 0px 5px 0px;">Total </td>
										<td style="background-color: #EEE; padding: 5px 0px 5px 0px;">Rs. <?= $total - $coupon_amount + $shipping_charge ?></td>
									</tr>
								</table>
                            </td>
                        </tr>
						<!-- tr>
                            <td style="padding:0 15px; display:block; margin-top:20px;margin-bottom:20px;text-align:center;">
                                <a class="btn" href="<?= base_url() ?>Store_Order/Order_details/<?= $order_id ?>">
                                    View Order
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:14px; font-family: -apple-system,Helvetica,Arial,sans-serif;color: #33373d;display: inline-block;line-height: 22px;">
                                kindly check it and confirm or reject order by clicking below link
                            </td>
                        </tr>
                        <tr>
                            <td class="link-div">
                                <a class="fpw" href="<?= base_url() ?>Store_Order/Order_details/<?= $order_id ?>">
                                    <?= base_url() ?>Store_Order/Order_details/<?= $order_id ?>
                                </a>
                            </td>
                        </tr -->
                    </table>
                </td>
            </tr>
            <!-- Content End -->

            <!-- Footer start -->
            <tr>
                <td width="100%">
                    <table width="100%" bgcolor="#f5f5f5" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; text-align:center;background: #EDF1F4;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                        
                        
                        <tr>
                            <td align="center" class="td-top">
                                <table class="tbl-with" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; text-align:center;">
                                    <tr>
                                        <td><a href="#"><img style="height: 50px;" src="<?= base_url() ?>assets/front-end/images/emailer-images/androidapp.png" alt="google play"></a></td>
                                        <!-- td><a href="#"><img class="app-dwl-img" src="<?= base_url() ?>assets/front-end/images/emailer-images/appleapps.png" alt="app store"></a></td -->
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-top td-bottom padd-lr15" style="font-size:13px; font-family: -apple-system,Helvetica,Arial,sans-serif; color:#787878;">©<?= date("Y") ?> Hereits All Rights Reserved. <a class="f-links" href="<?= base_url() ?>Terms">terms & condition</a> <a class="f-links" href="<?= base_url() ?>Privacy">privacy policy.</a></td>
                        </tr>

                    </table>
                </td>
            </tr>
            <!-- Footer End -->
        </table>
    </center>
</body>

</html>