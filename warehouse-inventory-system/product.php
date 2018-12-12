<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   $products = join_product_table();
   $pdt_array = array_values($products);

?>

<?php include_once('layouts/header.php'); ?>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

<script type="text/javascript">
    var mydata = <?php echo json_encode($pdt_array); ?>;
    console.log(mydata);
    
    $(document).ready(function() {
        $('#myTable').DataTable( {
                data: mydata,
                "pagingType": "full_numbers",
                rowId: 'id',
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                columns: [
                    { title: "#" },
                    { title: "Product Title" },
                    { title: "Categorie" },
                    { title: "Instock" },
                    { title: "Product Added" },
                    { title: "Last Update" },
                    { title: "Last Update By" },
                    { render: function ( data, type, row, meta ) {
                      return '<div class="btn-group">'
                          + '<a href="stock_in.php?pdt_id=' + row.id + '" title="Stock in/out"  class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-plus-sign"></span></a>' + '</div>' + '<div class="btn-group">' 
                          + '<a href="detail_product.php?id=' + row.id + '" title="Inventory Details"  class="btn btn-primary btn-xs" ><span class="glyphicon glyphicon-asterisk"></span></a>'  + '</div>' + '<div class="btn-group">' 
                          + '<a href="edit_product.php?id=' + row.id + '" title="Edit Product"  class="btn btn-info btn-xs" ><span class="glyphicon glyphicon-edit"></span></a>' + '</div>' + '<div class="btn-group">' 
                          + '<a href="delete_product.php?id=' + row.id + '" title="Delete Product"  class="btn btn-danger btn-xs" ><span class="glyphicon glyphicon-trash"></span></a>' 
                          + '</div>';
                    }}
                ]
            } );
        } );
    
</script>
 
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
          <table id="myTable" class="display nowrap" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Product Title</th>
                <th>Categorie</th>
                <th>Instock</th>
                <th>Product Added</th>
                <th>Last Update</th>
                <th>Last Update By</th>
                <th class="text-center" style="width: 80px;"> Actions </th>
              </tr>
            </thead>
<!--
            <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
-->
          </table>

          
        </div>
      </div>
    </div>
  </div>
  

  <?php include_once('layouts/footer_products.php'); ?>
