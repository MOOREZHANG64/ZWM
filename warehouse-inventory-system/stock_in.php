<?php
  $page_title = 'Stock in/out';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  
?>

<?php
 
 if(isset($_POST['submit_inventory'])){
   $req_fields = array('inventory-quantity','inventory-remarks' );
   
   validate_fields($req_fields);
   if(empty($errors)){
     $qty           = remove_junk($db->escape($_POST['inventory-quantity']));
     $remarks       = remove_junk($db->escape($_POST['inventory-remarks']));
     
     $inventory_type= ($qty > 0 ? 1 : 0);
     $created_by    = current_user();
     $created_on    = make_date();
     $productid     = (int) $_GET['pdt_id'];

     //update product amount
     $query1  = "UPDATE products SET";
     $query1 .= " quantity = quantity + '{$qty}'";
     $query1 .= " WHERE id = '{$productid}'";
    
     //insert inventory
     $query  = "INSERT INTO inventories (";
     $query .= " product_id, inventory_type, created_by, created_on, qty, remarks";
     $query .= ") VALUES (";
     $query .=" '{$productid}', '{$inventory_type}', '{$created_by[id]}', '{$created_on}', '{$qty}', '{$remarks}'";
     $query .= ")";
 
     if($db->query($query) && $db->query($query1)){
       $session->msg('s',"Inventory created!");
       echo "<script>window.history.go(-2);</script>";
     } else {
       $session->msg('d','Sorry failed to create!');
        echo "<script>window.history.go(-2);</script>";
     }
       console.log("no error2");
   } else{
     $session->msg("d", $errors);
     redirect('stock_in.php?pdt_id='.(int) $_GET['pdt_id'],false);

   }
     
 }

?>


<?php include_once('layouts/header.php'); ?>
    <div class="row">
        <div class="col-md-12">
           <?php echo display_msg($msg); ?>
         </div>
        <div class="col-md-12">
            <form method="post" action="stock_in.php?pdt_id=<?php echo (int) $_GET['pdt_id'] ?>" class="clearfix">

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
                 <div class="col-md-12">
                     <div class="input-group">
                         <span class="input-group-addon">
                          <i class="glyphicon glyphicon-bookmark"></i>
                         </span>
                          <textarea rows="4" cols="50" type="text" class="form-control" name="inventory-remarks" placeholder="Remarks"></textarea>
                      </div>
                 </div>
                 
               </div>

              </div>
              <button type="submit" name="submit_inventory" class="btn btn-danger" >Submit</button>
              <a href="detail_product.php?id=<?php echo (int) $_GET['pdt_id']?>" class="btn btn-info pull-right" role="button">Inventory details</a>
            </form>
        </div>
    </div>
<?php include_once('layouts/footer.php'); ?>