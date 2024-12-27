<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends MX_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdl_Templates');
		$this->load->model('Mdl_emails');
	}
	
	function product_pdf_invoice($id = NULL){
		if($id == NULL){
			$id = $_POST['order_id'];
		}
		
		$order_detail = $this->Mdl_Templates->Get_order_details($id);
		
		$order_detail->store = $this->Mdl_Templates->Get_Store_detail($order_detail->store_id);
		
		if($order_detail->delivery_type == 2){
			$order_detail->user_address = $this->Mdl_Templates->get_address($order_detail->addres_id);
		}
		
		$order_detail->Order_items = $this->Mdl_Templates->Get_order_items($id);
		
		
		$data ['order_detail'] = $order_detail;
		//$this->load->view('product_pdf_invoice',$data);
		$html = $this->load->view('templates/product_pdf_invoice',$data, TRUE);
		
		$filename = "Order-invoce_ord_" . $id . "_user_" . $order_detail->user_id .".pdf"; 
		
                $msg = '<p>Order Id <span style="background-color:#36c6d3;padding:3px;">#' . $id . '</span>.Is On ' . $data['order'][0]['om_date'] . '</p> From ';
          
            $html = str_replace('{{message}}', $msg, $html);
            $this->load->library('pdf');
            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $output = $this->pdf->output();
            file_put_contents('uploads/PDF_invoice/' . $filename, $output);
			
			echo base_url()."uploads/PDF_invoice/" . $filename;
			die;
	}
	
	function service_pdf_invoice($id = NULL){
		if($id == NULL){
			$id = $_POST['booking_id'];
		}
		
		$booking_detail = $this->Mdl_Templates->Get_booking_details($id);
		
		$booking_detail->store = $this->Mdl_Templates->Get_Store_detail($booking_detail->store_id);
		
		if($booking_detail->service_type == 2){
			$booking_detail->user_address = $this->Mdl_Templates->get_address($booking_detail->addres_id);
		}
		
		$booking_detail->Booking_items = $this->Mdl_Templates->Get_booking_items($id);
		
		
		$data ['booking_detail'] = $booking_detail;
		//$this->load->view('templates/Booking_pdf_invoice',$data);
		$html = $this->load->view('templates/Booking_pdf_invoice',$data, TRUE);
		
		$filename = "Booking-invoce_ord_" . $id . "_user_" . $booking_detail->user_id .".pdf"; 
		
                $msg = '<p>Booking Id <span style="background-color:#36c6d3;padding:3px;">#' . $id . '</span>.Is On </p> From ';
          
            $html = str_replace('{{message}}', $msg, $html);
            $this->load->library('pdf');
            $this->pdf->loadHtml($html);
            $this->pdf->setPaper('A4', 'portrait');
            $this->pdf->render();
            $output = $this->pdf->output();
            file_put_contents('uploads/PDF_invoice/' . $filename, $output);
			
			echo base_url()."uploads/PDF_invoice/" . $filename;
			die;
	}
	
	function store_verified_email(){
		$this->Mdl_emails->store_verified_email();
		
	}
	
	function store_panding_varification_email(){
		$this->Mdl_emails->store_panding_varification_email();
		
	}
	
	function order_received_by_store_mail(){
		$this->Mdl_emails->order_received_by_store_mail();
		
	}
	
	function order_confirm_by_user_mail(){
		$this->Mdl_emails->order_confirm_by_user_mail();
		
	}
	
	function order_cancel_by_user_mail(){
		$this->Mdl_emails->order_cancel_by_user_mail();
		
	}
	
	function order_cancel_by_store_mail(){
		$this->Mdl_emails->order_cancel_by_store_mail();
		
	}
	
	function order_completed_by_user_mail(){
		$this->Mdl_emails->order_completed_by_user_mail();
		
	}
	
	function booking_received_by_store_mail(){
		$this->Mdl_emails->booking_received_by_store_mail();
		
	}
	
	function booking_confirm_by_user_mail(){
		$this->Mdl_emails->booking_confirm_by_user_mail();
		
	}
	
	function booking_cancel_by_store_mail(){
		$this->Mdl_emails->booking_cancel_by_store_mail();
		
	}
	
	function booking_cancel_by_user_mail(){
		$this->Mdl_emails->booking_cancel_by_user_mail();
		
	}
	
	function booking_completed_by_user_mail(){
		$this->Mdl_emails->booking_completed_by_user_mail();
		
	}
	
	function store_subscription_buy_email(){
		$this->Mdl_emails->store_subscription_buy_email(16);
		
	}
	
	
	
}
?>
