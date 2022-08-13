<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      $results      = find_sale_by_dates($start_date,$end_date);
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;

  } else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
  }
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default"> 
        <div class="panel-heading clearfix">
         <!-- <div>
           <a id="exportProduct" href="report/sales_report.php" class="btn btn-primary">CR Export Type</a>
         </div> -->
        </div>
        <div class="panel-body">
          <table id="sales_report" class="display" style="width:100%">
            <thead>
              <tr>
                <th>Date</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Kota</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Packing Value</th>
                <th>Packing Name</th>
                <th>Harga Acuan</th>
                <th>Kurs</th>
                <th>Harga @</th>
                <th style="color:red;">Diskon Qty</th>
                <th>Diskon Agen</th>
                <th>Netto</th>
                <th>Salesman</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result):?>
              <tr>
                <td><?php echo format_date($result['invoiceDate']);?> </td>
                <td><?php echo remove_junk(ucfirst($result['invoice']));?> </td>
                <td><?php echo remove_junk(ucfirst($result['customer']));?> </td>
                <td><?php echo remove_junk(ucfirst($result['customerCity']));?> </td>
                <td><?php echo remove_junk(ucfirst($result['productCode']));?> </td>
                <td><?php echo remove_junk(ucfirst($result['productName']));?> </td>
                <td><?php echo remove_junk($result['quantity']);?></td>
                <td><?php echo number_format($result['packingValue']);?></td>
                <td><?php echo remove_junk(ucfirst($result['packingName']));?> </td>
                <td><?php echo number_format($result['hargaAcuan']);?></td>
                <td><?php echo number_format($result['kurs']);?></td>
                <td><?php echo number_format($result['hargaNett']);?></td>
                <td style="color:red;"><?php echo number_format($result['diskonQty']);?></td>
                <td><?php echo number_format(($result['hargaNett'] - $result['diskonQty']) * $result['diskonP']);?></td>
                <td><?php echo number_format($result['hargaNett'] - $result['diskonQty'] - ($result['hargaNett'] - $result['diskonQty']) * $result['diskonP']);?></td>
                <td><?php echo remove_junk(ucfirst($result['salesman']));?> </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include("layouts/footer.php"); ?>

  <script>
    $(document).ready(function() {
      $('#sales_report').DataTable( {
          dom: 'Bfrtip',
          scrollY:        "300px",
          scrollX:        true,
          scrollCollapse: true,
          buttons: [
              'excelHtml5',
              'pdfHtml5'
          ]
      } );
    });
  </script>
