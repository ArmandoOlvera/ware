<?php
  $page_title = 'Edit sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$cliente = find_by_idCliente('clientes',(int)$_GET['id']);
if(!$cliente){
  $session->msg("d","Missing client id.");
  redirect('clients.php');
}
?>
<?php $datos = find_by_idCliente('clientes',$cliente['idCliente']); ?>
<?php

  if(isset($_POST['update_sale'])){
    $req_fields = array('nombreC','catC');
    validate_fields($req_fields);
        if(empty($errors)){
          $c_id      = $db->escape((int)$datos['idCliente']);
          $nombre   = $db->escape($_POST['nombreC']);
          $categoria      = $db->escape($_POST['catC']);
          
          $sql  = "UPDATE clientes SET";
          $sql .= " idCliente = {$c_id},nombre='{$nombre}',categoria='{$categoria}'";
          $sql .= " WHERE idCliente ={$c_id}";
          $result = $db->query($sql);
          if( $result && $db->affected_rows() === 1){
                   // update_product_qty($s_qty,$p_id);
                    $session->msg('s',"Sale updated.");
                    redirect('clients.php?id='.$cliente['idCliente'], false);
                  } else {
                    $session->msg('d',' Sorry failed to updated!');
                    redirect('clients.php', false);
                  }
        } else {
           $session->msg("d", $errors);
           redirect('clients.php?id='.(int)$cliente['idCliente'],false);
        }
  }

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
        <span>All Clients</span>
     </strong>
     <div class="pull-right">
       <a href="sales.php" class="btn btn-primary">Show all clients</a>
     </div>
    </div>
    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Nombre </th>
          <th> Categoria </th>
          <th> Acciones </th>
         </thead>
           <tbody  id="product_info">
              <tr>
              <form method="post" action="edit_client.php?id=<?php echo (int)$cliente['idCliente']; ?>">
                <td id="s_name">
                  <input type="text" class="form-control" id="nombreC" name="nombreC" value="<?php echo remove_junk($datos['nombre']); ?>">
                  <div id="result" class="list-group"></div>
                </td>
                <td id="s_price">
                  <input type="text" class="form-control" name="catC" value="<?php echo remove_junk($datos['categoria']); ?>" >
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-primary">Update Client</button>
                </td>
              </form>
              </tr>
           </tbody>
       </table>

    </div>
  </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
