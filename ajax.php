<?php
  require_once('includes/load.php');
  
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
 // Auto suggetion
    $html = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $products = find_product_by_title($_POST['product_name']);
     if($products){
        foreach ($products as $product):
           $html .= "<li class=\"list-group-item\">";
           $html .= $product['name'];
           $html .= "</li>";
         endforeach;
      } else {

        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'No encontrado';
        $html .= "</li>";

      }

      echo json_encode($html);
   }
 ?>
 <?php 
    if(isset($_POST['client_name']) && strlen($_POST['client_name']))
   {
     $products = find_client_by_title($_POST['client_name']);
     
     if($products){
        foreach ($products as $product):
           $html .= "<li class=\"list-group-item\">";
           $html .= $product['nombre'];
           $html .= "</li>";
         endforeach;
      } else {

        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'No encontrado';
        $html .= "</li>";

      }

      echo json_encode($html);
  
   }
  ?>
 <?php
 // find all product
  if(isset($_POST['p_name']) && strlen($_POST['p_name']) )
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if($results = find_all_product_info_by_title($product_title)){
        foreach ($results as $result) {
          $html .= "<tr>";

          $html .= "<td id=\"s_name\">".$result['name']."</td>";
          $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\" >";
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"price\" value=\"{$result['sale_price']}\" >";
          $html  .= "</td>";
          $html .= "<td id=\"s_qty\">";
          $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"0\" required>";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"total\" value=\"{$result['sale_price']}\" id=\"total\"  required>";
          $html  .= "</td>";
          ////
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"imp\" value=\"16\" required>";
          $html  .= "</td>";
          ////
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"totalA\" value=\"0\"  id=\"totalA\" required >";
          $html  .= "</td>";
          $html  .= "</tr>";
          array_push($_SESSION['datos'],$html);
        }
    } else {
        $html ='<tr><td>El producto no se encuentra registrado en la base de datos</td></tr>';
        echo json_encode($html);
    }
    $page='';
    $posw=0;
    foreach ($_SESSION['datos'] as $item) {
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
     // $item=substr_replace($item,$posw, $pos5+10,0);
     $page.=$item;
     $posw++;
    }
    echo json_encode($page);
  }
 ?>
