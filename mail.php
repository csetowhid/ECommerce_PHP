<?php 
require('connection.inc.php');
require('functions.inc.php');

$order_id=$_GET['id'];
$res=mysqli_query($con,"select distinct(order_details.id), order_details.*,product.name,product.image from order_details,product,`order` where order_details.order_id='$order_id' and order_details.product_id=product.id");

$user_order=mysqli_fetch_assoc(mysqli_query($con,"select `order`.*, users.name,users.email from `order`,users where users.id=`order`.user_id and `order`.id='$order_id'"));

$coupon_details=mysqli_fetch_assoc(mysqli_query($con,"select coupon_value,coupon_code from `order` where id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];
$total_price=0;
$html='<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">
                            </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Hi '.$user_order['name'].'
                            </td>
                            
                            <td>
                                Acme Corp.<br>
                                John Doe<br>
                                john@example.com
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        <tr class="details">
                <td>
                    Purchase On
                </td>
                
                <td>
                    '.$user_order['added_on'].'
                </td>
            </tr>

            <tr class="details">
                <td>
                    Total Price
                </td>
                
                <td>
                    '.$user_order['total_price'].'
                </td>
            </tr>

            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Price
                </td>
            </tr>';

            while ($row=mysqli_fetch_assoc($res)) {
              $total_price=$total_price+($row['qty']*$row['price']);
              $pp=$row['qty']*$row['price'];
      $html.='<tr class="item">
                <td>
                    '.$row['name'].'
                </td>
                
                <td>
                   '.$pp.'
                </td>
            </tr>';  
          }

            if ($coupon_value!='') {
$html.='<tr class="total">
                <td>
                </td>
                
                <td>
                   Coupon Value: '.$coupon_value.'
                </td>
            </tr>'; 
   }  
$total_price=$total_price-$coupon_value;
$html.='

            <tr class="total">
                <td></td>
                
                <td>
                   Total: '.$total_price.'
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
';
echo $html;
?>