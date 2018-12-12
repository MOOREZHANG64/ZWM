<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
//   $products = join_product_table();
//    function join_product_table(){
//         global $db;
//         $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
//        $sql  .=" AS categorie,m.file_name AS image,p.update_date,u.name AS update_by";
//        $sql  .=" FROM products p";
//        $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
//        $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
//        $sql  .=" LEFT JOIN users u ON u.id = p.update_by";
//        $sql  .=" ORDER BY p.id ASC";
//        return find_by_sql($sql);
//
//       }

//        function find_by_sql($sql)
//        {
//          global $db;
//          $result = $db->query($sql);
//          $result_set = $db->while_loop($result);
//         return $result_set;
//        }
        
        global $db;
        $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
        $sql  .=" AS categorie,m.file_name AS image,p.update_date,u.name AS update_by";
        $sql  .=" FROM products p";
        $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
        $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
        $sql  .=" LEFT JOIN users u ON u.id = p.update_by";
//        $sql  .=" ORDER BY p.id ASC";

        $orderBy = array('name', 'categorie', 'date', 'update_date', 'update_by');

        $order = 'name';
        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
            $order = $_GET['orderBy'];
        }
        $sql .= " ORDER BY ".$order;
        

//        if ($_GET['sort'] == 'name')
//        {
//            $sql .= " ORDER BY name ASC";
//        }elseif ($_GET['sort'] == 'name'){
//            $sql .= " ORDER BY categorie";
//        }else{
//            $sql .= " ORDER BY p.id";
//        }

        $result = $db->query($sql);
        $products = $db->while_loop($result);

//    $products = find_by_sql($sql);

?>




<?php include_once('layouts/header.php'); ?>
 
<!-- testing testing testing-->
<!--
<div class="row">
    
</div>
-->
<!-- testing testing testing-->
 
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>All Products</span>
          </strong>
          
          <span class="pull-right">
              <a href="add_product.php" class="btn btn-primary">New Product</a>
          </span>
         </div>
        </div>
        <div class="panel-body">
          <table id="myTable" class="table table-bordered display" data-toggle="table">
            <thead>
              <tr>
                <th class="text-center" style="width: 30px;">#</th>
                <th> Photo</th>
                <th><a href="?orderBy=name"> Product Title </a></th>
                <th class="text-center" style="width: 10%;"><a href="?orderBy=categorie"> Categorie </a></th>
                <th class="text-center" style="width: 5%;"> Instock </th>
                <th class="text-center" style="width: 10%;"><a href="?orderBy=date"> Product Added </a></th>
                <th class="text-center" style="width: 10%;"><a href="?orderBy=update_date"> Last Update </a></th>
                <th class="text-center" style="width: 10%;"><a href="?orderBy=update_by"> Last Update By </a></th>
                <th class="text-center" style="width: 130px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                    <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                  <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center"> <?php echo read_date($product['update_date']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['update_by']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="stock_in.php?pdt_id=<?php echo (int)$product['id'];?>" class="btn btn-success btn-xs" title="Stock in/out" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                    </a>
                  </div>
                  <div class="btn-group">
                    <a href="detail_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-primary btn-xs"  title="Inventory Details" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-asterisk"></span>
                    </a>
                  </div>
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    
                    <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
          
<!--
          <table class="table table-bordered" data-toggle="table">
            <thead>
              <tr>
                <th class="text-center" style="width: 30px;">#</th>
                <th> Photo</th>
                <th> Product Title </th>
                <th class="text-center" style="width: 10%;"> Categorie </th>
                <th class="text-center" style="width: 5%;"> Instock </th>
                <th class="text-center" style="width: 10%;"> Product Added </th>
                <th class="text-center" style="width: 10%;"> Last Update</th>
                <th class="text-center" style="width: 10%;"> Last Update By</th>
                <th class="text-center" style="width: 130px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                    <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                  <?php endif; ?>
                </td>
                <td> <?php echo remove_junk($product['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center"> <?php echo read_date($product['update_date']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['update_by']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="stock_in.php?pdt_id=<?php echo (int)$product['id'];?>" class="btn btn-success btn-xs" title="Stock in/out" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                    </a>
                  </div>
                  <div class="btn-group">
                    <a href="detail_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-primary btn-xs"  title="Inventory Details" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-asterisk"></span>
                    </a>
                  </div>
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    
                    <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </table>
-->
          
        </div>
      </div>
    </div>
  </div>
  
  <script type="text/javascript">
    //console.log(<?php echo $products;?>);
    //console.log(<?php echo $products['quantity'];?>);
    //console.log(JSON.parse(JSON.stringify(<?php echo $products['id'];?>)));
    //var myJson = JSON.stringify(<?php echo $products;?>);
    //document.getElementById("demo").innerHTML = myJson;
    //console.log(myJson);
    //var obj1 = <?php echo $products;?>;
    //console.log(typeof obj1);
    //console.log(obj1());
//    $(document).ready( function () {
//        $('#myTable').DataTable();
//    } );
</script>
  

  <?php include_once('layouts/footer.php'); ?>
