
        <!-- ============================================================== -->
         
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery.dataTables.css'?>">
        <?php //if(Auth::user()->is_tpo ==1 ){  ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->   
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="page-wrapper">
   
                    <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body printableArea">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>                                        
                                            <h2> INVOICE</h2>
                                              
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
                                            <h3>We Are !!!</h3>
                                            <h4 class="font-bold">Himalaya Restaurant</h4>
                                            <p class="text-muted m-l-20">JL.XXXX no 10</p>

                                            <p class="m-t-30"> <i class="fa fa-phone" aria-hidden="true"></i> 
                                            
                                            </p>
                                      
                                        </address>
                                    </div>
                                </div>
                             </div>                       
                          
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>                                        
                                            <p class="text-muted m-l-5">
                                                
                                                 Inovice ID : <?php echo $header->idheader ?> <br>
                                                 Issue Date : <?php echo $header->issuedate ?>  <br>                                           
                                                 Subject : <?php echo $header->subject ?>
                                             
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                      <address>
                                            <h3>To,</h3>
                                            <h4 class="font-bold"><?php echo $header->nama ?></h4>
                                           
                                            </p>
                                      
                                        </address>
                                    </div>
                                </div>
                             </div>   

                            <?php //} ?>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-40" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-right">Description</th>
                                                    <th class="text-right">Quantity</th>
                                                    <th class="text-right">Unit Price</th>
                                                    <th class="text-right">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                        <?php $totalfinal=0;$finalharga=""; $taxt ="10";
                                                       // $i=0;$totaltmp=0;
                                                       foreach($detail as $detail){?>
                                                       
                                                       <tr>
                                                    <td class="text-right"><small><?php echo $detail->description; ?></small></td>
                                                    <td class="text-right"><small><?php echo $detail->qty; ?></small></td>
                                                    <td class="text-right"><small><?php echo $detail->unitprice; ?></small></td>
                                                    <td class="text-right"><small> <?php echo $detail->amount; ?> </small></td>   
                                                                                             
                                                </tr>
                                            <?php $totalfinal=$totalfinal+$detail->amount; }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php //foreach($header2 as $tableheader2){ ?>
                                <div class="col-md-12">    
                                    <div class="pull-right m-t-30 text-right">


                                    <address>                                        
                                            <p class="text-muted m-l-5">
                                                
                                                 Subtotal : <?php echo $totalfinal ?> <br>
                                                 Tax : <?php $tax = $totalfinal * ($taxt/100); echo $tax; ?> <br>
                                                 Payment :<br>
                                             
                                        </address>

                                        <hr>
                                        <h3><b>Amount Due :</b>Rp.<?php echo number_format($totalfinal+$tax,0) ?></h3>
                                        <hr>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <?php //} ?>
                               
                       <small>       
                             
                     <br>
                          
                               <div class="col-md-12">
                                 </div>
                                 </small>    

                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                                <a class="btn btn-primary" href="<?php echo base_url('index.php/invoice/tutup/'.$header->idheader.'')?>" role="button">Tutup</a>
                                 <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                </div>
            </div>

       
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
    
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
                                </div>
                                </div>

    <script src="{{ asset('adminpro/js/jquery.PrintArea.js') }} " type="text/JavaScript"></script>
    <script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->


