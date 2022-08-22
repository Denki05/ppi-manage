<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>

  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default"> 
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a id="exportProduct" href="report/crpdf1.php" class="btn btn-primary">Export Product List PDF</a>
         </div>
        </div>
        <div class="panel-body">
          <table id="product" class="table table-responsive-sm">
            <thead>
              <tr>
                <th class="text-center" >#</th>
                <th> Kode Bahan</th>
                <th> Nama Bahan </th>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Pabrik </th>
                <th> Merek </th>
                <th> Kategori </th>
                <th> Status </th>
                <th> Tipe Barang </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td> <?php echo remove_junk($product['product_material_code']); ?></td>
                <td> <?php echo remove_junk($product['product_material_name']); ?></td>
                <td> <?php echo remove_junk($product['product_code']); ?></td>
                <td> <?php echo remove_junk($product['product_name']); ?></td>
                <td> <?php echo remove_junk($product['factory_name']); ?></td>
                <td> <?php echo remove_junk($product['brand_name']); ?></td>
                <td> <?php echo remove_junk($product['category_name']); ?></td>
                <td> <?php echo remove_junk($product['product_status']); ?></td>
                <td> <?php echo remove_junk($product['product_type']); ?></td>
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
  $(document).ready( function () {
    $('#product').DataTable()
  });
  </script>