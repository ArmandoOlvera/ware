<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php
$num=0;
$num=(int)$_GET['id'];/*
  $d_sale = find_by_id('clientes',$num);
  if(!$d_sale){
    $session->msg("d","ID vacío.");
    redirect('clients.php');
  }
*/
?>
<?php
  //$num=0;
  //$num=(int)$d_cliente['idCliente'];
  $delete_id = delete_by_idClientes('clientes',$num);
  if($delete_id){
      $session->msg("s","Cliente eliminado.");
      redirect('clients.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('clients.php');
  }
?>
