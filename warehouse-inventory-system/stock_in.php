<?php
  $page_title = 'Stock in/out';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  
?>


<?php include_once('layouts/header_stock.php'); ?>
    <div class="row">
        <div class="col-md-12">
           <?php echo display_msg($msg); ?>
         </div>
        <div class="col-md-12">
            <form method="post" action="stock_in.php" class="clearfix">

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="inventory-quantity" placeholder="Inventory Quantity">
                  </div>
                 </div>
                 <div class="col-md-4"></div>
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-bookmark"></i>
                     </span>
                     <input type="text" class="form-control" name="inventory-remarks" placeholder="Remarks">
                  </div>
                </div>
               </div>
              </div>
              <button type="submit" name="submit_inventory" class="btn btn-danger">Submit</button>
            </form>
        </div>
    </div>
<?php include_once('layouts/footer.php'); ?>