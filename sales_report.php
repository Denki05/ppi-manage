<?php
$page_title = 'Sale Report';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">
        <label class="form-label" style="font-size: 16pt;">Date Range</label>
      </div>
      <div class="panel-body">
          <form class="clearfix" method="POST" action="sale_report_process.php">
            <div class="form-group">
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" placeholder="From" value="<?php echo date('Y-m-d'); ?>">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" placeholder="To" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="input-group">
                  <label class="form-label">Invoice type: </label>
                    <select name="invoice-type1" class="form-control">
                      <option value="ppn">PPN</option>
                      <option value="nonppn">NON PPN</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                 <button type="submit" name="submit" class="btn btn-primary">Generate Register</button>
                 <!-- <button type="submit-report" name="submit-report" class="btn btn-primary">Generate Report</button> -->
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">
        <label class="form-label" style="font-size: 16pt;">Monthly Range</label>
      </div>
      <div class="panel-body">
          <form class="clearfix" method="POST" action="monthly_sales.php">
            <div class="form-group">
                <div class="input-group">
                  <label class="form-label">Month: </label>
                    <select name="month" class="form-control">
                      <?php
                        for($i=0; $i<12; $i++)
                        {
                            // $selmonth = date();
                            $monthtime = mktime(0,0,0,$month + $i);
                            $monthnum = date('m', $monthtime);
                            echo '
                            <option value="'.$monthnum.'"'.
                            ($monthnum ? ' selected="selected"' : '').
                            '>'.date('F', $monthtime).'</option>';
                        }                        
                      ?>
                    </select>
                </div>
                <div class="input-group">
                  <label>Year: </label>
                    <select name="year" class="form-control">
                      <?php
                          for($n=date('Y');$n<=2025;$n++){
                              ?>
                              <option value="<?php echo $n; ?>"><?php echo $n; ?></option>
                              <?php
                          }
                      ?>
                    </select>
                </div>
                <div class="input-group">
                  <label class="form-label">Invoice type: </label>
                    <select name="invoice-type2" class="form-control">
                      <option value="">All</option>
                      <option value="ppn">PPN</option>
                      <option value="nonppn">NON PPN</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                 <button type="submit" name="submit" class="btn btn-primary">Generate Register</button>
                 <button type="submit" name="submit" class="btn btn-primary" formaction="monthly_sales2.php">Generate Report</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>