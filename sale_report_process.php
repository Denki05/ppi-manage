<?php
$page_title = 'Sales Report';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('start-date','end-date', 'invoice-type1');
    validate_fields($req_dates);

    if(empty($errors)):
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      $invoice_type1     = remove_junk($db->escape($_POST['invoice-type1']));
      $results      = find_sale_by_dates($start_date,$end_date,$invoice_type1);
    else:
      $session->msg("d", $errors);
      redirect('sales_report.php', false);
    endif;
    // echo $results;
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
                <th>Diskon Tambahan</th>
                <th>Netto</th>
                <th>Jumlah (Before Cashback)</th>
                <th>Cashback</th>
                <th>Jumlah (After Cashback)</th>
                <th>PPN 11%</th>
                <th>Jumlah (After PPN)</th>
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
                <td><?php echo decimal_format($result['quantity']);?></td>
                <td><?php echo number_format($result['packingValue']);?></td>
                <td><?php echo remove_junk(ucfirst($result['packingName']));?> </td>
                <td><?php echo formatDollars($result['hargaAcuan']);?></td>
                <td><?php echo number_format($result['kurs']);?></td>
                <td><?php echo number_format($result['hargaNett']);?></td>
                <td style="color:red;"><?php echo number_format($result['diskonQty']);?></td>
                <td><?php echo number_format(($result['hargaNett'] - $result['diskonQty']) * $result['diskonP']);?></td>
                <td><?php echo number_format($result['diskonTambahan']);?></td>
                <td><?php echo number_format($result['hargaNett'] - $result['diskonQty'] - ($result['hargaNett'] - $result['diskonQty']) * $result['diskonP']);?></td>
                <td><?php echo number_format(($result['hargaNett'] - $result['diskonQty'] - ($result['hargaNett'] - $result['diskonQty']) * $result['diskonP']) * $result['quantity']);?></td>
                <td style="text-align:center;">-</td>
                <td><?php echo number_format(($result['hargaNett'] - $result['diskonQty'] - ($result['hargaNett'] - $result['diskonQty']) * $result['diskonP']) * $result['quantity']);?></td>
                <td style="text-align:center;">-</td>
                <td><?php echo number_format((($result['hargaNett'] - $result['diskonQty'] - ($result['hargaNett'] - $result['diskonQty']) * $result['diskonP']) * $result['quantity']) - $result['diskonTambahan']);?></td>
                <td><?php echo remove_junk(ucfirst($result['salesman']));?> </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Total :</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include("layouts/footer.php"); ?>

  <script type="text/javascript">
	$(document).ready( function () {
	    $('#sales_report').DataTable( {
        dom: 'Bfrtip',
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        buttons: [
          {
              extend: 'pdfHtml5',
              orientation: 'landscape',
              pageSize: 'A3',
              footer: true
          },
          {
            extend: 'excelHtml5',
            orientation: 'landscape',
            pageSize: 'A4',
            footer: true
          }
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
 
            // Total over all pages
            total = api
                .column(20)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(20, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            $(api.column(20).footer()).html('Rp.' + pageTotal + ' ( Rp.' + total + ' total)');
        },
		  });
	});
</script>
