<?php
  $page_title = 'Lista de ventas';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sales = find_all_ventas();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Todas la ventas</span>
          </strong>
          <div class="pull-right">
            <a href="add_sale.php" class="btn btn-primary">Agregar venta</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;"># Folio</th>
                <th class="text-center" style="width: 15%;"> Cliente</th>
                <th class="text-center" style="width: 15%;"> Fecha </th>
                <th class="text-center" style="width: 15%;"> Total $ </th>
                <th class="text-center" style="width: 100px;"> Acciones </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo remove_junk($sale['nombre']); ?></td>
               <td class="text-center"><?php echo $sale['fecha']; ?></td>
               <td class="text-center">$ <?php echo remove_junk($sale['total']); ?></td>
               <td class="text-center">
                  <div class="btn-group">
                     <a href="edit_venta.php?id=<?php echo (int)$sale['idVenta'];?>" class="btn btn-warning btn-xs"  title="Ver" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-list-alt"></span>
                     </a>
                     <a href="delete_venta.php?id=<?php echo (int)$sale['idVenta'];?>" class="btn btn-danger btn-xs"  title="Borrar" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                  </div>
               </td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>
