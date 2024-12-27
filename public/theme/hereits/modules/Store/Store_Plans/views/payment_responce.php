
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hereits</title>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
<style type="text/css">

    body
    {
        background:#f2f2f2;
    }

    .payment
	{
		border:1px solid #f2f2f2;
		height:280px;
        border-radius:20px;
        background:#fff;
	}
   .payment_header
   {
	   background:#007bff ;
	   padding:20px;
       border-radius:20px 20px 0px 0px;
	   
   }
   
   .check
   {
	   margin:0px auto;
	   width:50px;
	   height:50px;
	   border-radius:100%;
	   background:#fff;
	   text-align:center;
   }
   
   .check i
   {
	   vertical-align:middle;
	   line-height:50px;
	   font-size:30px;
   }

    .content 
    {
        text-align:center;
    }

    .content  h1
    {
        font-size:25px;
        padding-top:25px;
    }

    .content a
    {
        width:200px;
        height:35px;
        color:#fff;
        border-radius:30px;
        padding:5px 10px;
        background:#007bff ;
        transition:all ease-in-out 0.3s;
    }

    .content a:hover
    {
        text-decoration:none;
        background:#000;
    }
   
</style>


</head>

<body>

<div class="container">
   <div class="row">
      <div class=" col-12 mx-auto mt-5">
         <div class="payment">
		<?php if($status == 1){ ?>
			<div class="payment_header">
               <div class="check"><i class="fa fa-check" aria-hidden="true"></i></div>
            </div>
            <div class="content">
               <h1>Payment Success !</h1>
               <p>congratulations, your order successfully done. </p>
               <a href="<?= base_url() ?>Store_dashboard">Dashboard</a>
               <a href="<?= base_url() ?>Store_Plans/get_plan_details/<?= $detais->store_subscription_id ?>">Order Details</a>
            </div>
		<?php }if($status == 0){ ?>
            <div class="payment_header" style="background: red;">
               <div class="check"><i class="fa fa-times" aria-hidden="true"></i></div>
            </div>
            <div class="content">
               <h1>Payment failed !</h1>
               <p>please try again. </p>
               <a style="background: red;" href="<?= base_url() ?>Store_dashboard">Dashboard</a>
               <a style="background: red;" href="<?= base_url() ?>Store_Plans/get_plan_details/<?= $detais->store_subscription_id ?>">Order Details</a>
            </div>
		<?php } ?>
            
         </div>
      </div>
   </div>
</div>

</body>
</html>
