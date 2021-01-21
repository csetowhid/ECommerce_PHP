<?php
require('top.inc.php');
if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from users where id='$id'";
		mysqli_query($con,$delete_sql);
	}
}
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Order Master</h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
                            <thead>
                                <tr>
<th class="product-name"><span class="nobr">Order Id</span></th>
<th class="product-price"><span class="nobr">Product </span></th>
<th class="product-price"><span class="nobr">Qty </span></th>
<th class="product-stock-stauts"><span class="nobr">Address</span></th>
<th class="product-add-to-cart"><span class="nobr">Payment Type</span></th>
<th class="product-add-to-cart"><span class="nobr">Payment Status</span></th>
<th class="product-add-to-cart"><span class="nobr">Order Status</span></th>
                                </tr>
                            </thead>
                            <tbody>
        <?php
        
        $res=mysqli_query($con,"select order_details.qty,product.name, `order`.*,order_status.name as order_status_str from order_details,product,`order`,order_status where order_status.id=`order`.order_status and product.id=order_details.product_id and `order`.id=order_details.order_id and product.added_by='".$_SESSION['ADMIN_ID']."' order by `order`.id desc");
        while ($row=mysqli_fetch_assoc($res)) {
         ?>
                                            <tr>
<td class="product-add-to-cart"><?php echo $row['id'] ?>
</td>
<td class="product-name"><a href="#"><?php echo $row['name'] ?></a></td>
<td class="product-name"><a href="#"><?php echo $row['qty'] ?></a></td>
<td class="product-price"><span class="amount">
    <?php echo $row['address'] ?>
    <?php echo $row['city'] ?>
    <?php echo $row['pincode'] ?>
</span></td>
<td class="product-price"><span class="amount"><?php echo $row['payment_type'] ?></span></td>
<td class="product-price"><span class="amount"><?php echo $row['payment_status'] ?></span></td>
<td class="product-stock-status"><span class="wishlist-in-stock"><?php echo $row['order_status_str'] ?></span></td>

                                            </tr>
                                    <?php } ?>
                                        </tbody>
                                    </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>
<?php
require('footer.inc.php');
?>