<?php
  $page_title = 'Edit sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$ide=(int)$_GET['id'];
$sale = findVenta_by_id('ventas',$ide);
$cliente =find_by_idCliente('clientes',$sale['idCliente']);
$compras = findSales_by_id('sales',$ide);
//$productos=findProducts_by_id('products',$compras['product_id']);
if(!$sale){
  $session->msg("d","Missing Venta id.");
  redirect('sales.php');
}
?>
<?php $product = find_by_id('products',$sale['product_id']); ?>
<?php
/*
  if(isset($_POST['update_sale'])){
    $req_fields = array('title','quantity','price','total', 'date' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$product['id']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
          $s_total   = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = date("Y-m-d", strtotime($date));

          $sql  = "UPDATE sales SET";
          $sql .= " product_id= '{$p_id}',qty={$s_qty},price='{$s_total}',date='{$s_date}'";
          $sql .= " WHERE id ='{$sale['id']}'";
          $result = $db->query($sql);
          if( $result && $db->affected_rows() === 1){
                    update_product_qty($s_qty,$p_id);
                    $session->msg('s',"Sale updated.");
                    redirect('edit_sale.php?id='.$sale['id'], false);
                  } else {
                    $session->msg('d',' Sorry failed to updated!');
                    redirect('sales.php', false);
                  }
        } else {
           $session->msg("d", $errors);
           redirect('edit_sale.php?id='.(int)$sale['id'],false);
        }
       
  } */

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
  <div class="panel">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Ver Venta - Folio de Venta: <?php echo (int)$sale['idVenta']; ?></span>
     </strong>
     <div class="pull-right">
       <a href="sales.php" class="btn btn-primary">Ver todas las ventas</a>
     </div>
    </div>
    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Cliente </th>
          <th> Fecha </th>
          <th> Total </th>
          <th> Total sin impuestos</th>
         </thead>
           <tbody  id="product_info">
              <tr>
              <form method="post"  autocomplete="off" action="ajax.php" id="sug-form2"><!--action="edit_sale.php?id=<?php //echo (int)$sale['id']; ?>"-->
                <td id="s_name">
                  <input type="text"  id="sug_input2" class="form-control" name="title2"    value="<?php echo remove_junk($cliente['nombre']); ?>" disabled required>
                  <div id="result" class="list-group"></div>
                </td>
                <td id="s_qty">
                  <input type="text" class="form-control" name="quantity" value="<?php echo $sale['fecha']; ?>" disabled>
                </td>
                <td id="s_price">
                  <input type="text" class="form-control" name="price" value="<?php echo remove_junk($sale['total']); ?>" disabled>
                </td>
                <td>
                  <input type="text" class="form-control" name="total" value="<?php echo remove_junk($sale['subtotal']); ?>" disabled>
                </td>
              <!--  <td id="s_date">
                  <input type="date" class="form-control datepicker" name="date" data-date-format="" value="<?php echo remove_junk($sale['date']); ?>" disabled>
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-primary" onclick="" >Update sale</button>
                </td>-->
              </form>
              </tr>
           </tbody>
       </table>
       <hr>
       <table class="table table-bordered">
         <thead>
          <th> Producto </th>
          <th> Cantidad </th>
          <th> Total </th>
          <th> Total sin impuestos</th>
         </thead>
           <tbody  id="product_info">
             
                <?php foreach ($compras as $compras):?>
                  <?php  $nombreproducto = findProducts_by_id('products',$compras['product_id']); ?>
              <tr>
                <td id="s_name">
                 
                  <input type="text"  id="sug_input2" class="form-control" name="title22"    value="<?php echo $nombreproducto['name']; ?>" disabled>
                 
                  <div id="result" class="list-group"></div>
                </td>
                <td id="s_qty">
                  <input type="text" class="form-control" name="quantity33" value="<?php echo  $compras['qty']; ?>" disabled>
                </td>
                <td id="s_price">
                  <input type="text" class="form-control" name="price33" value="<?php echo remove_junk($sale['total']); ?>" disabled>
                </td>
                <td>
                  <input type="text" class="form-control" name="total33" value="<?php echo remove_junk($sale['subtotal']); ?>" disabled>
                </td>
              <!--  <td id="s_date">
                  <input type="date" class="form-control datepicker" name="date" data-date-format="" value="<?php echo remove_junk($sale['date']); ?>" disabled>
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-primary" onclick="" >Update sale</button>
                </td>-->
             </tr>
              <?php endforeach;?>
              
           </tbody>
       </table>

    </div>
  </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
