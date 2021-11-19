<?php
class M_invoice extends CI_Model{

	function invoice_list(){
		$hasil=$this->db->query("SELECT a.idheader,issuedate,nama, sum(unitprice*qty) AS amount
												FROM  headerinvoice a
													LEFT JOIN  detailinvoice b
															ON a.idheader = b.idheader
													LEFT JOIN t_table c
															ON a.idtable = c.idtable
													LEFT JOIN t_item d
															ON b.iditem = d.iditem 
													WHERE `status` = 'y'		
															GROUP BY a.idheader");
		return $hasil->result();
	}

	function invoice_list_modal($id){

		$hasil=$this->db->query("SELECT a.iddetail,description,qty,unitprice,unitprice*qty AS amount
								FROM   detailinvoice a
									LEFT JOIN headerinvoice b
											ON a.idheader = b.idheader
									LEFT JOIN t_table c
											ON b.idtable = c.idtable
									LEFT JOIN t_item d
											ON a.iditem = d.iditem
								WHERE  a.idheader = '".$id."'");

		return $hasil->result();

	}

	function invoice_list_modal_edit($id){

		$SQL = "SELECT a.iddetail,description,qty,unitprice,unitprice*qty AS amount
				FROM   detailinvoice a
					LEFT JOIN headerinvoice b
							ON a.idheader = b.idheader
					LEFT JOIN t_table c
							ON b.idtable = c.idtable
					LEFT JOIN t_item d
							ON a.iditem = d.iditem
				WHERE  a.idheader = '".$id."'";
		
		//die($SQL);

		$hasil=$this->db->query($SQL);

		return $hasil->result();

	}


	function list_customer(){
		$hasil = $this->db->query("SELECT * FROM t_table");
		return $hasil->result();
	}

	function list_item(){
		$hasil = $this->db->query("SELECT * FROM t_item");
		return $hasil->result();
	}

	function get_number_invoice(){

		$hasilx =  $this->db->query("SELECT idheader FROM headerinvoice ORDER BY idheader DESC LIMIT 1");
		if($hasilx->num_rows()>0){
		$hasil = $this->db->query("SELECT idheader FROM headerinvoice ORDER BY idheader DESC LIMIT 1");
		$tmp = $hasil->row()->idheader;
		$tampung_kalimat = $tmp;
		$ouput_kalimat = substr($tampung_kalimat ,11);
		//echo $ouput_kalimat;
		$tmp = $ouput_kalimat + 1;
		$cc= $tmp;		
		}
		else{
			$cc= 1;
		}

		$pra = date("Ymd");
		return "PSN".$pra.$cc;
	}



	function simpan_invoice_header($id,$to,$issue,$subject,$pelaku){
		//{id:id,to:to,issue:issue,due:due,subject:subject,item:item,qty:qty}

		$hsl=$this->db->query("SELECT idheader FROM headerinvoice WHERE idheader='".$id."'");
		
		if($hsl->num_rows()==0){
			$hasil = $this->db->query("INSERT INTO headerinvoice(idtable,issuedate,`subject`,idheader,pelaku)
			VALUES('".$to."','".$issue."','".$subject."','".$id."','".$pelaku."')");
			return $hasil;
		}
	

		//die($this->db->last_query());
	

	}

	function simpan_invoice_detail($id,$item,$qty){
	
			$hasil = $this->db->query("INSERT INTO detailinvoice(idheader,iditem,qty)
			VALUES('".$id."','".$item."','".$qty."')");
			return $hasil;

	}



	function get_barang_by_kode($kobar){
		$hsl=$this->db->query("SELECT * FROM tbl_barang WHERE barang_kode='$kobar'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'barang_kode' => $data->barang_kode,
					'barang_nama' => $data->barang_nama,
					'barang_harga' => $data->barang_harga,
					);
			}
		}
		return $hasil;
	}

	function update_barang($kobar,$nabar,$harga){
		$hasil=$this->db->query("UPDATE tbl_barang SET barang_nama='$nabar',barang_harga='$harga' WHERE barang_kode='$kobar'");
		return $hasil;
	}

	function hapus_invoice($id){


	
		$this->db->query("SET FOREIGN_KEY_CHECKS=0");
		$hasil=$this->db->query("DELETE FROM `headerinvoice` WHERE idheader='".$id."'");
		$hasil2=$this->db->query("DELETE FROM `detailinvoice` WHERE idheader='".$id."'");
		$this->db->query("SET FOREIGN_KEY_CHECKS=1");
		// setelah ini menjalankan trigger untuk menghapus store procedure detailinvoice
		// cek trigger dan store procedure di mysql
		return $hasil;
	}


	function hapus_invoice_modal($id){

		$query = "DELETE FROM `detailinvoice` WHERE iddetail='".$id."'";
		$hasil=$this->db->query($query);
		return $hasil;
	}


	function cetak_invoice_header($id){

		$query1 = "SELECT a.idheader,issuedate,duedate,nama,a.`subject`, unitprice*qty AS amount,c.nama
					FROM  headerinvoice a
						LEFT JOIN  detailinvoice b
								ON a.idheader = b.idheader
						LEFT JOIN t_table c
								ON a.idtable = c.idtable
						LEFT JOIN t_item d
								ON b.iditem = d.iditem WHERE a.idheader = '".$id."' GROUP BY a.idheader"; 

	

		$hasil=$this->db->query($query1);

		return $hasil;					

	}

	function cetak_invoice_detail($id){

		$query2 = "SELECT `description`,qty,unitprice,unitprice*qty AS amount
					FROM   detailinvoice a
						LEFT JOIN headerinvoice b
								ON a.idheader = b.idheader
						LEFT JOIN t_table c
								ON b.idtable = c.idtable
						LEFT JOIN t_item d
								ON a.iditem = d.iditem
					WHERE  a.idheader = '".$id."'";

		$hasil=$this->db->query($query2);	

		return $hasil->result();

	}

	
	function editinvoiceheader($id){


		$query = "SELECT a.idheader,issuedate,duedate,a.idtable,nama,a.`subject`, unitprice*qty AS amount,c.nama 
		FROM  headerinvoice a
			LEFT JOIN  detailinvoice b
					ON a.idheader = b.idheader
			LEFT JOIN t_table c
					ON a.idtable = c.idtable
			LEFT JOIN t_item d
					ON b.iditem = d.iditem WHERE a.idheader = '".$id."' GROUP BY a.idheader";

		//die($query);


		$hasil=$this->db->query($query);	

		return $hasil;

	}


	function editinvoicedetail($id){


		$query = "SELECT `description`,qty,unitprice,unitprice*qty AS amount
					FROM   detailinvoice a
						LEFT JOIN headerinvoice b
								ON a.idheader = b.idheader
						LEFT JOIN t_table c
								ON b.idtable = c.idtable
						LEFT JOIN t_item d
								ON a.iditem = d.iditem
					WHERE  a.idheader = '".$id."'";

		$hasil=$this->db->query($query);	

		return $hasil->result();

	}



	function getallapi(){

		$query = "SELECT * FROM t_item";

		$hasil=$this->db->query($query);	

		return $hasil->result();


	}

	



}