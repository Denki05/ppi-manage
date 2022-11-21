<?php
$page_title = 'Sales Report Monthly : Register';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  if(isset($_POST['submit'])){
    $req_dates = array('month','year');
    $req_type = array('invoice-type2');
    validate_fields($req_dates, $req_type);

    if(empty($errors)):
      $month              = remove_junk($db->escape($_POST['month']));
      $year               = remove_junk($db->escape($_POST['year']));
      $invoice_type2      = remove_junk($db->escape($_POST['invoice-type2']));
      $results            = monthlySales($month,$year,$invoice_type2);
      // $result_explode     =
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
          <!-- <div>
            <select id="categoryFilter" class="form-control">
              <option value="">Show All</option>
              <option value="Classical">Classical</option>
              <option value="Hip Hop">Hip Hop</option>
              <option value="Jazz">Jazz</option>
            </select>
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
                <th>Harga Per Item</th>
                <th>Diskon Qty</th>
                <th>Diskon Agen</th>
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
                <td><?php echo remove_junk(ucfirst($result['invoiceCode']));?> </td>
                <td><?php echo remove_junk(ucfirst($result['customerName']));?> </td>
                <td><?php echo remove_junk(ucfirst($result['customerCity']));?> </td>
                <td><?php echo remove_junk(ucfirst($result['productCode']));?> </td>
                <td><?php echo remove_junk(ucfirst($result['productName']));?> </td>
                <td><?php echo decimal_format($result['invoiceQty']);?></td>
                <td><?php echo number_format($result['packingValue']);?></td>
                <td><?php echo remove_junk(ucfirst($result['packingName']));?> </td>
                <td><?php echo formatDollars($result['productPrice']);?></td>
                <td><?php echo number_format($result['invoiceKurs']);?></td>
                <td><?php echo number_format($result['InvoiceItemPriceNett']);?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo remove_junk(ucfirst($result['salesman']));?></td>
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
              pageSize: 'A2',
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
            var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;
            $(api.column(20).footer()).html(numFormat(total));
        },
		  });
	});
</script>
