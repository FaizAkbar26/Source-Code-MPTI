<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   // Sanitize and validate input data
   $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'] ?? '', FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_STRING);
   $method = filter_var($_POST['method'] ?? '', FILTER_SANITIZE_STRING);
   $label = filter_var($_POST['label'] ?? '', FILTER_SANITIZE_STRING);
   $address = filter_var(
       ($_POST['flat'] ?? '') . ', ' . ($_POST['city'] ?? '') . ', ' . ($_POST['state'] ?? '') . ', ' . ($_POST['country'] ?? '') . ' - ' . ($_POST['pin_code'] ?? ''), 
       FILTER_SANITIZE_STRING
   );

   $image_payment = $_FILES['image_payment'] ?? '';
   if ($image_payment && $image_payment['tmp_name']) {
       $uploadDir = 'uploads/';
       // Check if the uploads directory exists, if not create it
       if (!is_dir($uploadDir)) {
           mkdir($uploadDir, 0755, true);
       }

       $imageName = time() . '_' . basename($image_payment['name']);
       $imagePath = $uploadDir . $imageName;
       if (move_uploaded_file($image_payment['tmp_name'], $imagePath)) {
           $image_payment = $imageName;
       } else {
           $image_payment = '';
           $message[] = 'Failed to upload image';
       }
   } else {
       $image_payment = '';
   }

   $total_products = filter_var($_POST['total_products'] ?? '', FILTER_SANITIZE_STRING);
   $total_price = filter_var($_POST['total_price'] ?? 0, FILTER_SANITIZE_NUMBER_INT);

   // Check if cart is not empty
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){
      $all_products_in_stock = true;
      $cart_items = $check_cart->fetchAll(PDO::FETCH_ASSOC);

      // Check stock for each product in the cart
      foreach($cart_items as $item){
         $pid = $item['pid'];
         $quantity = $item['quantity'];

         $check_stock = $conn->prepare("SELECT stock FROM `products` WHERE id = ?");
         $check_stock->execute([$pid]);
         $product = $check_stock->fetch(PDO::FETCH_ASSOC);

         if($product['stock'] < $quantity){
            $all_products_in_stock = false;
            $message[] = "Not enough stock for product ID: $pid";
            break;
         }
      }

      if($all_products_in_stock){
         // Insert order into the database
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, label, address, total_products, total_price, image_payment) VALUES(?,?,?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $label, $address, $total_products, $total_price, $image_payment]);

         // Decrease stock for each product in the cart and delete cart items
         foreach($cart_items as $item){
            $pid = $item['pid'];
            $quantity = $item['quantity'];

            $update_stock = $conn->prepare("UPDATE `products` SET stock = stock - ? WHERE id = ?");
            $update_stock->execute([$quantity, $pid]);

            $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ? AND pid = ?");
            $delete_cart_item->execute([$user_id, $pid]);
         }

         header('location:orders.php'); 

      }

   }else{
      $message[] = 'Your cart is empty';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
   <link rel="stylesheet" href="css/style.css">
   <style type="text/css">
     .content-wrapper {
         display: flex;
         justify-content: center;
         align-items: flex-start;
         gap: 20px;
         flex-wrap: wrap;
         margin-bottom: 20px;
     }

     .content-container {
         padding: 20px;
         border: 1px solid #ccc;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         width: 220px;
         height: 180px;
         text-align: center;
         display: flex;
         flex-direction: column;
         justify-content: space-between;
         box-sizing: border-box;
         background-color: var(--white);
     }

     .content-container img {
         max-width: 100px;
         height: auto;
         margin: 0 auto 10px;
     }
     .content-container .logo-qris { max-width: 120px; margin-top: 30px; }
     .content-container .logo-bni { max-width: 150px; margin-top: 35px; }
     .content-container .logo-bca { max-width: 150px; margin-top: 30px; }
     .content-container .logo-bri { max-width: 180px; margin-top: 35px; }
     .content-container .logo-mandiri { max-width: 150px; margin-top: 35px; }
     .content-container .logo-bsi { max-width: 150px; margin-top: 35px; }

     .content-container p {
         font-size: 16px;
         margin: 10px 0;
     }

     .button-container {
         display: flex;
         justify-content: center;
         margin-top: 10px;
     }

     .button-container button {
         padding: 10px 20px;
         border: none;
         background-color: #28a745;
         color: white;
         border-radius: 5px;
         cursor: pointer;
         border: 1px solid #fff;
         transition: all 0.3s ease;
     }

     .button-container button:hover {
         font-weight: 900;
         background: transparent;
         color: #228C22;
         border-color: #228C22;
     }

     .primary-btn {
         display: flex;
         justify-content: center; 
         margin-top: 10px; 
         padding: 10px 20px;
         background-color: #28a745; 
         color: white;
         border-radius: 5px;
         cursor: pointer;
         text-transform: uppercase;
         transition: all 0.3s ease;
     }

     .primary-btn:hover {
         font-weight: 900;
         background: transparent;
         color: #228C22;
         border-color: #228C22;
     }

     .extra-content {
         width: 80%;
         max-width: 500px;
         text-align: center;
         margin: 20px auto;
         padding: 20px;
         border: 1px solid #ccc;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         background-color: #f9f9f9;
     }
     .heading22{
         font-size: 2rem;
         color:var(--black);
         
         text-align: center;
      }
     .heading3{
         font-size: 1.5rem;
         color:var(--black);
         text-align: center;
         color: #DC3545;
      }
      .heading4{
         font-size: 1rem;
         color:var(--black);
         text-align: center;
      }
      .checkout-orders form .flex1 {
          display: flex;
          flex-direction: column; /* Use this if you want elements stacked vertically */
      }

      .checkout-orders form .flex1 .try {
          display: flex;
          flex: 1; /* Allow this element to grow and fill available space */
      }

      .checkout-orders form .flex1 .try .inputBox {
          width: 100%; /* Make sure the inputBox takes full width */
      }

      .checkout-orders form .flex1 .try .inputBox .box {
          width: 100%; /* Make the input element take full width */
          border: var(--border);
          border-radius: .5rem;
          font-size: 1.8rem;
          color: var(--black);
          padding: 1.2rem 1.4rem;
          margin: 1rem 0;
          background-color: var(--light-bg);
          box-sizing: border-box; /* Include padding and border in the element's total width */
      }

      .checkout-orders form .flex1 .try .inputBox span {
          font-size: 1.8rem;
          color: var(--light-color);
      }
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>



<section class="checkout-orders">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= 'Rp. '.$fetch_cart['price'].' x '. $fetch_cart['quantity']; ?> )</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Grand Total : <span>Rp. <?= $grand_total; ?></span></div>
      </div>

      <h3>Detail of Address</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Phone Number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999999999" onkeypress="if(this.value.length == 16) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Payment :</span>
            <select name="method" class="box" required>
               <!-- <option value="Qris">Qris(Maintenance)</option>-->
               <option value="Transfer BCA">Transfer(BCA)</option>
               <option value="Transfer Mandiri">Transfer(Mandiri)</option>
               <option value="Transfer BSI">Transfer(BSI)</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address :</span>
            <input type="text" name="flat" placeholder="Address" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Type :</span>
            <select name="label" class="box" required>
               <option value="Apartment">Apartment</option>
               <option value="Home">Home</option>
               <option value="Office">Office</option>
               <option value="Boarding House">Boarding House</option>
            </select>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" placeholder="City" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Province:</span>
            <input type="text" name="state" placeholder="Province" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" placeholder="Country" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>ZIP CODE :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 20157" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>
      
      <section class="category">
         <h3>Bank Details</h3>
         <div class="content-wrapper"><!--
            <div class="content-container">
               <img src="images/logoqris.png" alt="QRIS Image" class="logo-qris">
               <div class="button-container">
                  <a data-fancybox="gallery" class="primary-btn" href="images/Maintenance.png">View</a>
               </div>
            </div> -->
            <div class="content-container">
               <img src="images/bca.png" alt="BCA" class="logo-bca">
               <div class="button-container">
                  <a data-fancybox class="primary-btn" href="#bca-content">View</a>
               </div>
               <div style="display: none;" id="bca-content">
                  <h2 class="heading">Bank Central Asia</h2>
                  <p class="heading2">8465455353 an. nurul adzkia ghearizky</p>
               </div>
            </div>
            <div class="content-container">
               <img src="images/mandiri.png" alt="Mandiri" class="logo-mandiri">
               <div class="button-container">
                  <a data-fancybox class="primary-btn" href="#mandiri-content">View</a>
               </div>
               <div style="display: none;" id="mandiri-content">
                  <h2 class="heading">Bank Mandiri</h2>
                  <p class="heading2">9000032833262 a.n nurul adzkia ghearizky</p>
               </div>
            </div>
            <div class="content-container">
               <img src="images/bsi.png" alt="BSI" class="logo-bsi">
               <div class="button-container">
                  <a data-fancybox class="primary-btn" href="#bsi-content">View</a>
               </div>
               <div style="display: none;" id="bsi-content">
                  <h2 class="heading">Bank Syariah Indonesia</h2>
                  <p class="heading2">7201506489 a.n nurul adzkia ghearizky</p>
               </div>
            </div>
         </div>
      </section>
      <div class="flex1">
         <div class="try">
            <div class="inputBox">
               <span>Upload Image Payment</span>
               <input type="file" name="image_payment" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
         </div>
      </div>
      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>

<!-- other sections remain unchanged -->

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script>
var swiper = new Swiper(".reviews-slider", {
   loop: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
   breakpoints: {
      0: {
         slidesPerView: 1,
      },
      768: {
         slidesPerView: 2,
      },
      1024: {
         slidesPerView: 3,
      },
   },
});
</script>

</body>
</html>