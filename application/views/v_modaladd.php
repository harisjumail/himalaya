       
           <form class="form-horizontal">
                <div class="modal-body">

                <div class = 'row'>
                    <div class = "col-md-6">
                        <div class="form-group">
                            <label class="control-label col-xs-3" >ID</label>
                            <div class="col-xs-9">
                                <input name="id" id="id" readonly value ="<?php echo $lastid ?>" class="form-control" type="text" placeholder="Invoice ID" required>
                            </div>
                        </div>
                    </div>
                    <div class = "col-md-6">
                    <div class="form-group">
                        <label class="control-label col-xs-3" >To</label>
                        <div class="col-xs-9">
                        
                        <select class ="form-control" name = "to" id="to">
                        <option value = "">-</option>
                        <?php foreach($datarow as $datarow){ ?>
                          <option value = "<?php echo $datarow->idtable ?>"><?php echo $datarow->nama ?></option>
                         <?php } ?> 
                        </select>
                        

                        </div>
                    </div>
                    </div>
                </div>


                <div class = 'row'>
                    <div class = "col-md-6">
                    <div class="form-group">
                        <label class="control-label col-xs-3" > Date</label>
                        <div class="col-xs-9">
                        <input type="date" name="issue" id="issue" class="form-control" type="text" required>
                        </div>
                    </div>
                     </div>
                     <div class = "col-md-6">
                    <div class="form-group">
                        <label class="control-label col-xs-3"> Subject </label>
                        <div class="col-xs-9">
                        <input name="subject" id="subject" class="form-control" type="text" placeholder="Subject"  >
                        </div>
                    </div>
                    </div>
                </div>    


                <div class="modal-footer">        

                <div class = 'row'>
                    <div class = "col-md-6">
                    <div class="form-group">
                        <label class="control-label col-xs-3" > Item</label>
                        <div class="col-xs-9">
                        <select class ="form-control" name = "item" id="item">
                        <option value = "">-</option>
                        <?php foreach($listitem as $listitem){ ?>
                          <option value = "<?php echo $listitem->iditem ?>"><?php echo $listitem->description ?></option>
                         <?php } ?> 
                        </select>
                        </div>
                    </div>
                     </div>
                     <div class = "col-md-6">
                    <div class="form-group">
                        <label class="control-label col-xs-3" >QTY</label>
                        <div class="col-xs-9">
                            <input name="qty" id="qty" class="form-control" type="number" placeholder="Qty"  required>
                        </div>


                    </div>
                    </div>
                </div>  


                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <button class="btn btn-info" id="simpan_temp">Simpan</button>
                </div>
               
            </form>

            <div class="row">
            <div id="reload">
            <table class="table table-striped" id="modaladd">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="show_data_modal">
                    
                </tbody>
            </table>
            </div>
            </div>
            </div>
            <script type="text/javascript">
	        $(document).ready(function(){
            tampil_data_invoice_modal();	//pemanggilan fungsi data invoice
		
		$('#modaladd').dataTable();
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
                                '<a href="javascript:;" class="btn btn-primary btn-xs item_cetak" data="'+data[i].idheader+'">Cetak</a>'+
                                '</td>'+
		                        '</tr>';
                     }
                     $('#show_data_main').html(html);
                 }
 
             });
         }
 

		 
		//fungsi tampil invoice modal
		function tampil_data_invoice_modal(){

            var id=$('#id').val();
           // alert(id); return false;

		    $.ajax({
		        type  : 'POST',
		        url   : '<?php echo base_url()?>index.php/invoice/data_invoice_modal',
		        async : true,
		        dataType : 'json',
                data : {id:id},
		        success : function(data){
		            var html = '';
		            var i;
		            for(i=0; i<data.length; i++){
		                html += '<tr>'+
		                        '<td>'+data[i].description+'</td>'+
		                        '<td>'+data[i].qty+'</td>'+
                                '<td>'+data[i].unitprice+'</td>'+
                                '<td>'+data[i].amount+'</td>'+
		                        '</tr>';
		            }
		            $('#show_data_modal').html(html);
		        }

		    });
		}

		//GET UPDATE
		$('#show_data').on('click','.item_edit',function(){
            var id=$(this).attr('data');
            $.ajax({
                type : "GET",
                url  : "<?php echo base_url('index.php/barang/get_barang')?>",
                dataType : "JSON",
                data : {id:id},
                success: function(data){
                	$.each(data,function(barang_kode, barang_nama, barang_harga){
                    	$('#ModalaEdit').modal('show');
            			$('[name="kobar_edit"]').val(data.barang_kode);
            			$('[name="nabar_edit"]').val(data.barang_nama);
            			$('[name="harga_edit"]').val(data.barang_harga);
            		});
                }
            });
            return false;
        });


		//GET HAPUS
		$('#show_data').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="kode"]').val(id);
        });

		//Simpan invoice
		$('#simpan_temp').on('click',function(){       

         //   alert('test'); return false;

            var id=$('#id').val();
            var to=$('#to').val();
            var issue=$('#issue').val();
            var subject=$('#subject').val();
            var item=$('#item').val();
            var qty=$('#qty').val();

            if(id && to && issue && item && qty){

            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('index.php/invoice/simpan_invoice')?>",
                dataType : "json",
                data : {id:id,to:to,issue:issue,subject:subject,item:item,qty:qty},
                success: function(data){
                    $('[name="item"]').val("");
                    $('[name="qty"]').val("");
                    $('#to').attr('readonly', true);
                    $('#issue').prop('readonly', true);
                    $('#due').prop('readonly', true);
                    tampil_data_invoice_modal();
                    tampil_data_invoice();
                },          

            error : function(textStatus){
                alert('eror');
            }
            });
            return false;
            }
            else{
                alert('Field tidak boleh kosong');
            }
        });

        //Update Barang
		$('#btn_update').on('click',function(){
            var kobar=$('#kode_barang2').val();
            var nabar=$('#nama_barang2').val();
            var harga=$('#harga2').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('index.php/barang/update_barang')?>",
                dataType : "JSON",
                data : {kobar:kobar , nabar:nabar, harga:harga},
                success: function(data){
                    $('[name="kobar_edit"]').val("");
                    $('[name="nabar_edit"]').val("");
                    $('[name="harga_edit"]').val("");
                    $('#ModalaEdit').modal('hide');
                    tampil_data_invoice();
                }
            });
            return false;
        });

        //Hapus Barang
        $('#btn_hapus').on('click',function(){
            var kode=$('#textkode').val();
            $.ajax({
            type : "POST",
            url  : "<?php echo base_url('index.php/barang/hapus_barang')?>",
            dataType : "JSON",
                    data : {kode: kode},
                    success: function(data){
                            $('#ModalHapus').modal('hide');
                            tampil_data_barang();
                    }
                });
                return false;
            });

	});

</script>