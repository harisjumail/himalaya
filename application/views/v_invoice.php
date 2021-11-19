<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>List Inovice</title>

   
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery.dataTables.css'?>">

    <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.js'?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>

</head>
<body>
<div class="container">
	<!-- Page Heading -->
        <div class="row">
            <h1 class="page-header">Himalaya
                <small>Restaurant</small>
                <a href="#" class="btn btn-sm btn-info" data-toggle="modal" > Login sebagai : <?php  echo $this->session->userdata('username'); ?> </a>
              	<div class="pull-right">
              
                    <button class="btn btn-outline btn-danger"  id="tambah" data-keyboard="false">Transaksi</button>
                    <a href="<?php echo base_url('index.php/auth/logout')?>" class="btn btn-sm btn-success" data-toggle="modal" > Log Out</a>
                        <script>

                        $("#tambah").click(function() {

                            $("#detail-data").load("<?php echo base_url()?>index.php/invoice/modalinvoice");
                            
                            $("#modal_remote").modal({backdrop: "static"});
                                    
                            $("#modal_remote").modal("show");

                        });

                        </script>
                
                </div>
            </h1>
        </div>
	<div class="row">
		<div id="reload">
		<table class="table table-striped" id="mydata">
			<thead>
				<tr>
					<th>INVOICE ID</th>
					<th>DATE</th>
                    <th>TABLE</th>
                    <th>AMOUNT</th>
					<th style="text-align: right;">ACTION</th>
				</tr>
			</thead>
			<tbody id="show_data_main">				
			</tbody>
		</table>

     
                API :
               api login 
               http://localhost/himalaya/index.php/auth/loginApi <br>
               API akses menu makanan
               http://localhost/himalaya/index.php/auth/getapi
          


		</div>
	</div>
</div>
<!-- MODAL TAMBAH -->
<div id="modal_remote" class="modal" tabindex="-1" style="width: 100%x;">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">TAMBAH INVOICE</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body" id="detail-data">  

                            </div>   
            </div>
        </div>
    </div>

<!-- MODAL EDIT -->
        <div id="modal_edit" class="modal" tabindex="-1" style="width: 100%x;">
                        <div class="modal-dialog modal-full">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">EDIT INVOICE</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body" id="detail-data-edit"></div>
                </div>
            </div>
        </div>

       
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus invoice</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin mau menghapus invoice ini?</p></div>
                                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODAL HAPUS-->


                <!--MODAL CETAK-->
        
        <div class="modal fade" id="ModalCetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cetak invoice</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin mau mencetak invoice ini?</p></div>
                                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button class="btn_hapus btn btn-Primary" id="btn_cetak">Cetak</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--END MODAL CETAK-->


<script type="text/javascript">
	$(document).ready(function(){
		tampil_data_invoice();	//pemanggilan fungsi data invoice
		
		$('#mydata').dataTable();
		 
		//fungsi tampil invoice utama
		function tampil_data_invoice(){
		    $.ajax({
		        type  : 'GET',
		        url   : '<?php echo base_url()?>index.php/invoice/data_invoice',
		        async : true,
		        dataType : 'json',
		        success : function(data){
		            var html = '';
		            var i;
		            for(i=0; i<data.length; i++){
		                html += '<tr>'+
		                  		'<td>'+data[i].idheader+'</td>'+
		                        '<td>'+data[i].issuedate+'</td>'+
                                '<td>'+data[i].nama+'</td>'+
                                '<td>'+data[i].amount+'</td>'+
		                        '<td style="text-align:right;">'+
                                '<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].idheader+'">Edit</a>'+' '+
                                '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].idheader+'">Hapus</a>'+
                                '<a href="javascript:;" class="btn btn-primary btn-xs item_cetak" data="'+data[i].idheader+'">Proses & Tutup</a>'+
                                '</td>'+
		                        '</tr>';
		            }
		            $('#show_data_main').html(html);
		        }

		    });
		}

	
    
          //GET EDITED
           $('#show_data_main').on('click','.item_edit',function(){

                 var id=$(this).attr('data'); 

                $("#detail-data-edit").load("<?php echo base_url()?>index.php/invoice/modaleditinvoice/"+id+"");
                
                $("#modal_edit").modal({backdrop: "static"});
                        
                $("#modal_edit").modal("show");

            });


    		//GET cetak
		$('#show_data_main').on('click','.item_cetak',function(){                    
                    var id=$(this).attr('data');   
                    window.open("<?php echo base_url('') ?>index.php/invoice/cetak_invoice/"+id+"");
                 
                });

		//GET HAPUS
		$('#show_data_main').on('click','.item_hapus',function(){                    
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
        });

	

        //Cetak Invoice
        $('#btn_cetak').on('click',function(){
        var id=$('#textkode').val();
       // alert(id);
        $.ajax({
        type : "POST",
        url  : "<?php echo base_url('index.php/invoice/cetak_invoice')?>",
        dataType : "json",
                data : {id: id},
                success: function(data){
                        alert('berhasil');
                        $('#ModalCetak').modal('hide');
                     //   tampil_data_invoice();
                },
                error: function(data){
                        alert('error');
                        $('#ModalCetak').modal('hide');
                       // tampil_data_invoice();
                },
            });
            return false;
        });



        //Hapus Invoice
        $('#btn_hapus').on('click',function(){

           // alert('xx');return false;
            var id=$('#textkode').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('index.php/invoice/hapus_invoice')?>",
            dataType : "json",
                    data : {id: id},
                    success: function(data){
                            $('#ModalHapus').modal('hide');
                            tampil_data_invoice();
                    }
                });
                return false;
            });

    	});

	


</script>
</body>
</html>