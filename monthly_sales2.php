<?php
$page_title = 'Sales Report Monthly : Omset';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
  if(isset($_POST['submit2'])){
    $req_dates = array('month','year');
    $req_type = array('invoice-type3');
    validate_fields($req_dates, $req_type);

    if(empty($errors)):
      $month              = remove_junk($db->escape($_POST['month']));
      $year               = remove_junk($db->escape($_POST['year']));
      $invoice_type3      = remove_junk($db->escape($_POST['invoice-type3']));
      $results            = monthlySales2($month,$year);
      $results2           = monthlySales3($month, $year);
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
          <!-- <div class="input-group">
            <label class="form-label">Invoice type: </label>
            <select name="invoice-type2" class="form-control">
              <option value="all">All</option>
              <option value="ppn">PPN</option>
              <option value="nonppn">NON PPN</option>
            </select>
          </div> -->
        </div>
        <div class="panel-body">
          <?php if($_POST['invoice-type3'] === 'umum'): ?>
            <table class="datatable table table-striped table-vcenter table-responsive table-sm display nowrap" style="width:100%">
            <thead>
              <tr>
                <th>Date</th>
                <th>Invoice</th>
                <th>Qty</th>
                <th>Customer</th>
                <th>Kurs</th>
                <th>Shipping Cost</th>
                <th>Purchase Total</th>
                <th>Grand Total</th>
                <th>Salesman</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result):?>
              <tr>
                <td><?php echo format_date($result['invDate']);?> </td>
                <td><?php echo remove_junk(ucfirst($result['invCode']));?> </td>
                <td><?php echo decimal_format($result['invQty']);?></td>
                <td><?php echo remove_junk(ucfirst($result['custName']));?> </td>
                <td><?php echo number_format($result['invoiceKurs']);?> </td>
                <td><?php echo number_format($result['invShipCost']);?></td>
                <td><?php echo number_format($result['invSubTotal']);?></td>
                <td><?php echo number_format($result['invGrandTotal']);?></td>
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
              </tr>
            </tfoot>
          </tabel>

          <?php elseif($_POST['invoice-type3'] === 'bybrand'): ?>
            <table class="bybrand table table-striped table-vcenter table-responsive table-sm display nowrap" style="width:100%">
            <thead>
              <tr>
                <th>Invoice Brand</th>
                <th>Invoice</th>
                <th>Date</th>
                <th>Qty</th>
                <th>Customer</th>
                <th>Kurs</th>
                <th>Shipping Cost</th>
                <th>Purchase Total</th>
                <th>Grand Total</th>
                <th>Salesman</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result):?>
              <tr>
                <td><?php echo remove_junk(ucfirst($result['productBrand'])); ?> </td>
                <td><?php echo remove_junk(ucfirst($result['invCode']));?> </td>
                <td><?php echo format_date($result['invDate']);?> </td>
                <td><?php echo decimal_format($result['invQty']);?></td>
                <td><?php echo remove_junk(ucfirst($result['custName']));?> </td>
                <td><?php echo number_format($result['invoiceKurs']);?> </td>
                <td><?php echo number_format($result['invShipCost']);?></td>
                <td><?php echo number_format($result['invSubTotal']);?></td>
                <td><?php echo number_format($result['invGrandTotal']);?></td>
                <td><?php echo remove_junk(ucfirst($result['salesman']));?> </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
            <tfoot>
            </tfoot>
          </tabel>

          <?php elseif($_POST['invoice-type3'] === 'bycustomer'): ?>
            <table>
              <thead>
                <tr>
                  <th>BY Customer</th>
                </tr>
              </thead>
            </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php include("layouts/footer.php"); ?>

  <script type="text/javascript">
	$(document).ready( function () {
    $('.datatable').DataTable( {


    dom: 'Bfrtip',
    scrollY:        "300px",
    scrollX:        true,
    scrollCollapse: true,
    buttons: [
      {
          extend: 'pdfHtml5',
          title: 'Sales Report Omset',
          orientation: 'potrait',
          pageSize: 'A4',
          footer: true
      },
      {
        extend: 'excelHtml5',
        title: 'Sales Report Omset',
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
            .column(6)
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Total over this page
        pageTotal = api
            .column(6, { page: 'current' })
            .data()
            .reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

        // Update footer
        var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;
        $(api.column( 6 ).footer()).html(numFormat(total));

        total = api
        .column( 7 )
        .data()
        .reduce( function (a, b) {
            return intVal(a) + intVal(b);
        }, 0 );

        // Total over this page
        pageTotal = api
            .column( 7, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Rp.' ).display;
        $( api.column( 7 ).footer() ).html(numFormat(total));
    },
      });
});
</script>

<script type="text/javascript">
	$(document).ready( function () {
    $('.bybrand').DataTable( {


    dom: 'Bfrtip',
    scrollY:        "300px",
    scrollX:        true,
    scrollCollapse: true,
    buttons: [
      {
          extend: 'pdfHtml5',
          title: 'Sales Report Omset',
          orientation: 'potrait',
          pageSize: 'A4',
          footer: true
      },
      {
        extend: 'excelHtml5',
        title: 'Sales Report Omset',
        orientation: 'landscape',
        pageSize: 'A4',
        footer: true
      }
    ],
    
      });
});
</script>
