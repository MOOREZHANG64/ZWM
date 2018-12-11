<?php
  $page_title = 'Inventory details';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_product_by_id((int)$_GET['id']);
$all_categories = find_all('categories');
//$all_photo = find_all('media');

//if(!$product){
//  $session->msg("d","Missing product id.");
//  redirect('product.php');
//}
$inventories = find_inventories_by_product_id((int)$_GET['id']);

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
<!--
               <span class='btn-toolbar'>
                   <a href="#" class="btn btn-primary pull-right" onClick="MyWindow=window.open('stock_in.php?pdt_id=<?php echo (int)$_GET['id'];?>', 'MyWindow', 'location=1, status=1, scrollbars=1, width=800, height=455'); return false;"> Stock In / Out </a>
                   
                   
               </span>
-->
               <span class="pull-right">
                   <a href="stock_in.php?pdt_id=<?php echo (int)$_GET['id'];?>"  Class="btn btn-primary">
                       STOCK IN/OUT
                   </a>
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
        <a href="product.php" class="btn btn-info" role="button">Product list</a>
    </div>
<?php include_once('layouts/footer.php'); ?>
