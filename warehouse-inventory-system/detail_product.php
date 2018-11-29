<?php
  $page_title = 'Inventory details';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_product_by_id((int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
$inventories = find_inventories_by_product_id((int)$_GET['id']);
if(!$inventories){
  $session->msg("d","There is no inventory details for this product.");
  redirect('detail_product.php');
}
?>

<?php 
    
?>

<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity' );
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
       $now     = make_date();
       $current_user = current_user();
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}',";
       $query  .=" categorie_id ='{$p_cat}', media_id='{$media_id}', update_date='{$now}', update_by={$current_user[id]}";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Product updated ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th-large"></span>
            <span>INVENTORY DETAILS</span>
         </strong>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                   <tr>
                        <th class="text-center" style="width: 10%;"> Photo </th>
                        <th class="text-center" style="width: 10%;"> Product Title </th>
                        <th class="text-center" style="width: 10%;"> Categorie</th>
                        <th class="text-center" style="width: 10%;"> Instock </th>
                   </tr> 
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php if($product['media_id'] === '0'): ?>
                                <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                            <?php else: ?>
                                <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['media']; ?>" alt="">
                            <?php endif; ?>
                        </td>
                        <td class="text-center"> <?php echo remove_junk($product['name']);?> </td>
                        <td class="text-center"> 
                           <select  name="product-categorie" disabled>
                            <?php  foreach ($all_categories as $cat): ?>
                                <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                                    <?php echo remove_junk($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                           </select>
                        </td>
                        <td class="text-center"> <?php echo remove_junk($product['quantity']); ?> </td>
                    </tr>
                </tbody>
            </table>
<!--
         <div class="col-md-7">
          
          <div class="form-group">
            <div class="row">
               <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>" disabled>
               </div>
              <div class="col-md-6">
                <select class="form-control" name="product-categorie">
                <option value=""> Select a categorie</option>
               <?php  foreach ($all_categories as $cat): ?>
                 <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                   <?php echo remove_junk($cat['name']); ?></option>
               <?php endforeach; ?>
             </select>
              </div>
              <div class="col-md-6">
                <select class="form-control" name="product-photo">
                  <option value=""> No image</option>
                  <?php  foreach ($all_photo as $photo): ?>
                    <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                      <?php echo $photo['file_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
           <div class="row">
             <div class="col-md-4">
              <div class="form-group">
                <label for="qty">Quantity</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-shopping-cart"></i>
                  </span>
                  <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
               </div>
              </div>
             </div>

           </div>
          </div>
           
         </div>
-->
        </div>
      </div>
  </div>
   <div class="row">
       <div class="panel panel-default">
           <div class="panel-heading">
               <strong>
                   <span class="glyphicon glyphicon-th-list"></span>
                   <span> Inventory lists </span>
               </strong>
               <span class='btn-toolbar'>
                   <a href="#" class="btn btn-primary pull-right" onClick="MyWindow=window.open('stock_in.php?id=<?php echo (int)$_GET['id'];?>', 'MyWindow', 'location=1, status=1, scrollbars=1, width=800, height=455'); return false;"> Stock In / Out </a>
               </span>
           </div>
           <div class="panel-body">
               <table class="table table-bordered">
                   <thead>
                       <tr>
                           <th class="text-center" style="width: 50px;"> # </th>
                           <th> Product Title </th>
                           <th> Inventory Type </th>
                           <th> Quantity </th>
                           <th> Remarks </th>
                           <th> Created On </th>
                           <th> Created By </th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php foreach ($inventories as $inventory):?>
                       <tr>
                           <td class="text-center"><?php echo count_id();?></td>
                           <td><?php echo remove_junk($inventory['productname']); ?></td>
                           <td><?php echo remove_junk($inventory['inventory_type']); ?></td>
                           <td><?php echo remove_junk($inventory['qty']); ?></td>
                           <td><?php echo remove_junk($inventory['remarks']); ?></td>
                           <td><?php echo read_date($inventory['created_on']); ?></td>
                           <td><?php echo remove_junk($inventory['username']); ?></td>
                       </tr>
                       <?php endforeach; ?>
                   </tbody>
               </table>
           </div>
       </div>
   </div>
    <div class='row pull-right'>
        <a href="product.php" class="btn btn-info" role="button">Go Back</a>
    </div>
<?php include_once('layouts/footer.php'); ?>
