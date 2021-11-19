<?php
class Invoice extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_invoice');
		$this->load->library('session');
		
        if (!$this->session->userdata('username')) {
            redirect(base_url() . 'index.php/auth/login');  
        }

	}
	function index(){

	

		$this->load->view('v_invoice');
	}

	function data_invoice(){

	    $data=$this->m_invoice->invoice_list();
		echo json_encode($data);
	}

	function data_invoice_modal(){
		$id=$this->input->post('id');

	    $data=$this->m_invoice->invoice_list_modal($id);


		echo json_encode($data);
	}

	function data_invoice_modal_edit(){
		$id=$this->input->post('id');
	    $data=$this->m_invoice->invoice_list_modal_edit($id);
		echo json_encode($data);
	}

	public function modalinvoice(){

		$this->data['datarow'] = $this->m_invoice->list_customer();
		$this->data['lastid'] = $this->m_invoice->get_number_invoice();
		$this->data['listitem'] = $this->m_invoice->list_item();
		$this->load->view('v_modaladd',$this->data);

	}

	public function modaleditinvoice($id){

		$this->data['header'] = $this->m_invoice->editinvoiceheader($id)->row();
		$this->data['detail'] = $this->m_invoice->editinvoicedetail($id);
		$this->data['datarow'] = $this->m_invoice->list_customer();
		$this->data['lastid'] = $id;
		$this->data['listitem'] = $this->m_invoice->list_item();
		$this->load->view('v_modaledit',$this->data);

	}




	function simpan_invoice(){

		$id=$this->input->post('id');
		$to=$this->input->post('to');
		$issue=$this->input->post('issue');
		$subject=$this->input->post('subject');
		$item=$this->input->post('item');
		$qty=$this->input->post('qty');
		$pelaku = $this->session->userdata('username');
		
		$data = $this->m_invoice->simpan_invoice_header($id,$to,$issue,$subject,$pelaku);
		$data2 = $this->m_invoice->simpan_invoice_detail($id,$item,$qty);

		//die($this->db->last_query());

		echo json_encode($data);
	}

	function cetak_invoice($id=null){

		$pelaku = $this->session->userdata('type');

		if($pelaku == 'kasir'){
		$data['header'] = $this->m_invoice->cetak_invoice_header($id)->row();
		$data['detail'] = $this->m_invoice->cetak_invoice_detail($id);
		$this->load->view('v_invoicecetak',$data); 
		}
		else{

			echo "Upps pelayan tidak boleh proses pembayaran dan menutup transaksi";

		}
	}

		function tutup($idheader){

			$data = $this->db->query("UPDATE headerinvoice SET status = 'n' WHERE idheader = '".$idheader."'");
			echo json_encode($data);
		}



	function hapus_invoice(){
		
		$id=$this->input->post('id');
		$data=$this->m_invoice->hapus_invoice($id);
		echo json_encode($data);
	}

	function hapus_invoice_modal(){
		$id=$this->input->post('id');		
		$data=$this->m_invoice->hapus_invoice_modal($id);
		echo json_encode($data);
	}



	function getapidetail($id=null){

		$data=$this->m_invoice->getallapidetail($id);
		echo json_encode($data);	

	}

}