<?php
  $page_title = 'Agregar venta';
  require_once('includes/load.php');
  $check=0;
  // Checkin What level user has permission to view this page
   page_require_level(2);
     if (isset($_POST['add_sale'])) {

     }else{
      $_SESSION['datos'] = array();
     }
  
?>
<?php

  if(isset($_POST['add_sale'])){
    $req_fields = array('s_id0','quantity0','price0','total0', 'date' );
   echo ("asdasdasdasda".$_POST['selectedtext']);
    validate_fields($req_fields);
        if(empty($errors)){
          $stotl= $_POST['t1'];
          $totl= $_POST['t2'];
          $sentencia="select idCliente from clientes where nombre= '".$_POST['selectedtext']."'";
          $IDE = obtenerIDCliente($sentencia);
          //$p_id      = $db->escape((int)$_POST['s_id0']);
          $s_qty     = $db->escape((int)$_POST['quantity0']);
          $s_total   = $db->escape($_POST['total0']);
          $date      = $db->escape($_POST['date']);
          $s_date    = make_date();
           $sql  = "INSERT INTO ventas (";
          $sql .= " idVenta,idCliente,fecha,total,subtotal";
          $sql .= ") VALUES (";
          $sql .= "'',{$IDE},'{$date}',{$totl},{$stotl}";
          $sql .= ")";
         $algo= insertarUniversal($sql);
         echo $algo;
         $sql2="SELECT * FROM ventas";
         $uid= obtenerUltimaVenta($sql2);
         $conta=0;
         $p_id      = $db->escape((int)$_POST['s_id'.$conta]);
         $s_qty     = $db->escape((int)$_POST['quantity'.$conta]);
         $s_total   = $db->escape($_POST['total'.$conta]);
         $s_totalA   = $db->escape($_POST['totalA'.$conta]);
         while($p_id!=0){
              $sql3="INSERT INTO sales(id,product_id,qty,price,date,tax,idVenta) values('',{$p_id},{$s_qty},{$s_total},'{$date}',{$s_totalA},{$uid})";
              insertarSales($sql3);
              update_product_qty($s_qty,$p_id);
              $conta=$conta+1;
              $p_id      = $db->escape((int)$_POST['s_id'.$conta]);
              if($p_id!=0){
                $s_qty     = $db->escape((int)$_POST['quantity'.$conta]);
                $s_total   = $db->escape($_POST['total'.$conta]);
                $s_totalA   = $db->escape($_POST['totalA'.$conta]);
              }
              $check=999;
         }
/*
          $sql  = "INSERT INTO sales (";
          $sql .= " product_id,qty,price,date";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
          $sql .= ")";
            
                if($db->query($sql)){
                  update_product_qty($s_qty,$p_id);
                  $session->msg('s',"Venta agregada ");
                  redirect('add_sale.php', false);
                } else {
                  $session->msg('d','Lo siento, registro falló.');
                  redirect('add_sale.php', false);
                }
                */
        } else {
           $session->msg("d", $errors);
           redirect('add_sale.php',false);
           //redirect('ajax.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
      <legend>Producto</legend>
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Búsqueda</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Buscar por el nombre del producto">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form2">
      <legend>Cliente</legend>
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
            <!--  <button name="submit" id="submit" type="submit" class="btn btn-primary">Búsqueda</button>-->
            <input type="text" id="sug_input2" class="form-control" name="title2"  placeholder="Buscar por el nombre del cliente" onmouseout ="textoVariables()" onmouseover ="textoVariables()"></span>
         </div>
         <div id="result2" class="list-group"></div>
        </div>
       
    </form>
  </div>
</div>


  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Editar venta</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php" >
         <table class="table table-bordered">
           <thead>
            <th> Producto </th>
            <th> Precio </th>
            <th> Cantidad </th>
            <th> SubTotal </th>
            <th> Impuesto (%) </th>
            <th> Total con Impuestos</th>
           </thead>
            <tbody  id="product_info">
            <?php 
                if (isset($_POST['add_sale'])) {
                     if($check==999){
                  echo "<h1>EXITO, la venta ha sido realizada correctamente.</h1>";
                  $_SESSION['datos'] = array();
                     }else{

                  echo "<h1>ERROR, ingrese los parametros correctamente.</h1>";
                        $page='';
                        $posw=0;
                        $_SESSION['datos2']=$_SESSION['datos'];
                        foreach ($_SESSION['datos'] as $item) {
                          $hello='';
                          $item = str_replace('\\', '0', $item);
                          $pos1= strpos($item, "s_id");
                          $item=substr_replace($item,$posw, $pos1+4,0);
                          $pos1= strpos($item, "price");
                          $item=substr_replace($item,$posw, $pos1+5,0);
                          $pos2= strpos($item, "quantity");
                          $item=substr_replace($item,$posw, $pos2+8,0);
                          $pos3= strpos($item, "imp");
                          $item=substr_replace($item,$posw, $pos3+3,0);
                          $pos4= strpos($item, "total");
                          $item=substr_replace($item,$posw, $pos4+5,0);
                          $pos5= strpos($item, "totalA");     
                          $item=substr_replace($item,$posw, $pos5+6,0);
                          $pos5= strpos($item, "id=\"totalA\"");     
                          $item=substr_replace($item,$posw, $pos5+10,0);
                          $pos5= strpos($item, "id=\"total\"");     
                          $item=substr_replace($item,$posw, $pos5+9,0);
                         // $pos5= strpos($item, "name=\"date\"");     
                         // $item=substr_replace($item,$posw, $pos5+10,0); */
                         //$page.=$str;
                         echo $item;
                         $posw++;
                        
     }
                     }
                
                     //  $session->msg("d", $errors);
                     ////  redirect('add_sale.php',false);
                       ///redirect('ajax.php',false);
                        
                    
                  
                   //echo json_encode($page);
                }
                             
            ?> 
           </tbody>
         </table>
         <table class="table table-bordered">
           <thead>
             <th>Fecha de Venta</th>
             <th>Calcular Todo</th>
             <th>Total de la Venta (Sin impuestos)</th>
             <th>Total de la Venta (Con impuestos)</th>
             <th>Acciones</th>
           </thead>
           <tbody>
             <td><input type="date" class="form-control datePicker" name="date" data-date="" data-date-format="yyyy-mm-dd" id="date" value="<?php echo date("Y-m-d");?>"></td>
             <td><input id="clickMe"  class="btn btn-primary" type="button" value="Calcular" onclick="cargarTotal()" /></td><td><input  class="form-control" id="t1" type="" name="t1"></td>
             <td><input class="form-control" id="t2" type="" name="t2"></td>
             <td><button type="submit" name="add_sale" class="btn btn-primary">Guardar Venta</button>
             </td>
           </tbody>
         </table>
          <input type="hidden" id="selectedtext" name="selectedtext" placeholder="Primer Nombre" >
       </form>
      </div>
    </div>
  </div>

<!--<input type="text" id="nombre1" placeholder="Primer Nombre"  onchange="textoVariables()" value="a">-->

</div>

<?php include_once('layouts/footer.php'); ?>
<script type="text/javascript">
    function textoVariables()
  {
    for (var i = 0; i <= 500; i++) {
      console.log("asd");
      var nombre = document.getElementById("sug_input2").value;
      if (nombre!='') {
          document.getElementById('selectedtext').value=nombre;
      }
      if (nombre!=document.getElementById("sug_input2").value) {
        document.getElementById('selectedtext').value=document.getElementById("sug_input2").value;
      }
    }
      
  }
  function cargarTotal(){
    var nombre = document.getElementById("sug_input2").value;
      if (nombre!='') {
          document.getElementById('selectedtext').value=nombre;
      }
      if (nombre!=document.getElementById("sug_input2").value) {
        document.getElementById('selectedtext').value=document.getElementById("sug_input2").value;
      }
    console.log("LA FECHA ES: q"+document.getElementById("date").value);
    var pose=0;
    var t1=0;
    var t2=0;
    var n1="total"+pose;
    var n2="totalA"+pose;
    console.log("Hola "+n1);
    t1 +=parseFloat(document.getElementById(n1).value);
    console.log("Hola1 "+t1);
    t2 +=parseFloat(document.getElementById(n2).value);
    console.log("Hola2 "+t2);
    document.getElementById('t1').value=t1;
    document.getElementById('t2').value=t2;
   pose++;
   n1="total"+pose;
   n2="totalA"+pose;
   while(parseFloat(document.getElementById(n1).value)!=0){
    t1 +=parseFloat(document.getElementById(n1).value);
    //console.log("Hola1 "+t1);
    t2 +=parseFloat(document.getElementById(n2).value);
    //console.log("Hola2 "+t2);
    document.getElementById('t1').value=t1;
    document.getElementById('t2').value=t2;
    pose++;
    n1="total"+pose;
   n2="totalA"+pose;
   
   }
   
  }

</script>
<script type="text/javascript" src="db.js"></script>