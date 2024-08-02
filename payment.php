<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['payment'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $image_payment = $_FILES['image_payment']['name'];
   $image_payment = filter_var($image_payment, FILTER_SANITIZE_STRING);
   $image_size_payment = $_FILES['image_payment']['size'];
   $image_tmp_name_payment = $_FILES['image_payment']['tmp_name'];
   $image_folder_payment = '../uploaded_img/'.$image_payment;


   $select_products = $conn->prepare("SELECT * FROM `payment` WHERE user_id = ?");
   $select_products->execute([$user_id]);

   $insert_payment = $conn->prepare("INSERT INTO `payment`(user_id, name, image_payment) VALUES(?,?,?)");
   $insert_payment->execute([$user_id, $name, $image_payment]);

      if($insert_payment){
         if($image_size_payment > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_payment, $image_folder_payment);
            $message[] = 'Picture Uploaded';
         }

      }

   };


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

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <h1 class="heading">Bukti Pembayaran</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Name</span>
            <input type="text" class="box" required maxlength="100" placeholder="Enter name" name="name">
         </div>
        <div class="inputBox">
            <span>Upload Image</span>
            <input type="file" name="image_payment" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
      <input type="submit" value="upload_payment" class="btn" name="payment">
   </form>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>