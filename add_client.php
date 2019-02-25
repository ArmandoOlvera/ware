<?php
  $page_title = 'Agregar Cliente';
  require_once('includes/load.php');
  
  // Checkin What level user has permission to view this page
   page_require_level(3);
   
  
?>
<?php

  if(isset($_POST['add_client123'])){
    $req_fields = array('nombrec','catc');
    $nombrec= $_POST['nombrec'];
    $catc= $_POST['catc'];
    validate_fields($req_fields);
        if(empty($errors)){
          echo "Todo bien";
          echo "$nombrec";
          echo "$catc";
          $sql  = "INSERT INTO clientes (";
          $sql .= " idCliente,nombre,categoria";
          $sql .= ") VALUES (";
          $sql .= "0,'{$nombrec}','{$catc}'";
          $sql .= ")";
          $algo= insertarUniversal($sql);
        } else {
           $session->msg("d", $errors);
           redirect('add_client.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Agregar Cliente</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_client.php" >
          <legend>Ingrese los datos del cliente:</legend>
         <table class="table table-bordered">
           <thead>
             <th>Nombre</th>
             <th>Categoria</th>
             <th>Acciones</th>
           </thead>
           <tbody>
            <td><input type="text" id="nombrec" class="form-control" name="nombrec"></td>
            <td>
            <select id="catc" name="catc"  >
            <option value="Premium">Premium</option>
            <option value="Normal">Normal</option>
            </select>
            </td> 
             <td><button type="submit" name="add_client123" class="btn btn-primary">Guardar Cliente</button>
             </td>
           </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

<!--<input type="text" id="nombre1" placeholder="Primer Nombre"  onchange="textoVariables()" value="a">-->

</div>

<?php include_once('layouts/footer.php'); ?>
