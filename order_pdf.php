<?php 
include('vendor/autoload.php');
require('connection.inc.php');
require('functions.inc.php');
if (!$_SESSION['ADMIN_LOGIN']) {
    if (!isset($_SESSION['USER_ID'])) {
    die();
}
}

$order_id=get_safe_value($con,$_GET['id']);

$css=file_get_contents('css/bootstrap.min.css');
$css.=file_get_contents('style.css');


$html='<div class="wishlist-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>

<th class="product-name">Product Name</th>
<th class="product-thumbnail">Product Image</th>
<th class="product-price">Qty</th>
<th class="product-stock-stauts">Price</th>
<th class="product-add-to-cart">Total Price</th>

                                            </tr>
                                        </thead>
                                        <tbody>';
        
        if (isset($_SESSION['ADMIN_LOGIN'])) {
            $res=mysqli_query($con,"select distinct(order_details.id), order_details.*,product.name,product.image from order_details,product,`order` where order_details.order_id='$order_id' and order_details.product_id=product.id");
        }else{
            $uid=$_SESSION['USER_ID'];
            $res=mysqli_query($con,"select distinct(order_details.id), order_details.*,product.name,product.image from order_details,product,`order` where order_details.order_id='$order_id' and `order`.user_id='$uid' and order_details.product_id=product.id");
        }
        
        if(mysqli_num_rows($res)==0) {
        	die();
        }
        $total_price=0;
        while ($row=mysqli_fetch_assoc($res)) {
        $total_price=$total_price+($row['qty']*$row['price']);
        $pp=$row['qty']*$row['price'];

$html.='<tr>
<td class="product-name">'.$row['name'].'</td>
<td class="product-thumbnail"><img src="'.PRODUCT_IMAGE_SITE_PATH.$row['image'].'"></td>
<td class="product-price">'.$row['qty'].'</td>
<td class="product-stock-stauts">'.$row['price'].'</td>
<td class="product-add-to-cart">'.$pp.'</td>
</tr>';}
$html.='<tr>
<td colspan="3"></td>
<td class="product-name">Total Price</td>
<td class="product-stock-status">'.$total_price.'</td>
                                    </tr>';
          
                                        $html.='</tbody>
                                    </table>
                                </div>';
$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
$file=time().'.pdf';
$mpdf->output($file,'D');

?>
