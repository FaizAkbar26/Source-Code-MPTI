<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
   $select_orders->execute([$user_id]);
   $fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC);
} else {
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
   <link rel="stylesheet" href="css/style.css">
   <style type="text/css">
     /* Your existing CSS styles */
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
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?> 

<section class="category">

   <h1 class="heading2">Order placed, Contact Whatsapp For Payment Confirmation</h1>

   <div class="content-wrapper">
      <div class="content-container">
         <img src="images/logoqris.png" alt="QRIS Image" class="logo-qris">
         <div class="button-container">
            <a data-fancybox="gallery" class="primary-btn" href="images/qris.png">View</a>
         </div>
      </div>
      <div class="content-container">
         <img src="images/bni.png" alt="BNI" class="logo-bni">
         <div class="button-container">
            <a data-fancybox class="primary-btn" href="#bni-content">View</a>
         </div>
         <div style="display: none;" id="bni-content">
            <h2 class="heading">Bank Negara Indonesia</h2>
            <p class="heading2">1234567890 a.n Muhammad Faiz Akbar</p>
         </div>
      </div>
      <div class="content-container">
         <img src="images/bca.png" alt="BCA" class="logo-bca">
         <div class="button-container">
            <a data-fancybox class="primary-btn" href="#bca-content">View</a>
         </div>
         <div style="display: none;" id="bca-content">
            <h2 class="heading">Bank Central Asia</h2>
            <p class="heading2">1234567890 a.n Muhammad Faiz Akbar</p>
         </div>
      </div>
      <div class="content-container">
         <img src="images/bri.png" alt="BRI" class="logo-bri">
         <div class="button-container">
            <a data-fancybox class="primary-btn" href="#bri-content">View</a>
         </div>
         <div style="display: none;" id="bri-content">
            <h2 class="heading">Bank Rakyat Indonesia</h2>
            <p class="heading2">1234567890 a.n Muhammad Faiz Akbar</p>
         </div>
      </div>
      <div class="content-container">
         <img src="images/mandiri.png" alt="Mandiri" class="logo-mandiri">
         <div class="button-container">
            <a data-fancybox class="primary-btn" href="#mandiri-content">View</a>
         </div>
         <div style="display: none;" id="mandiri-content">
            <h2 class="heading">Bank Mandiri</h2>
            <p class="heading2">1234567890 a.n Muhammad Faiz Akbar</p>
         </div>
      </div>
      <div class="content-container">
         <img src="images/bsi.png" alt="BSI" class="logo-bsi">
         <div class="button-container">
            <a data-fancybox class="primary-btn" href="#bsi-content">View</a>
         </div>
         <div style="display: none;" id="bsi-content">
            <h2 class="heading">Bank Syariah Indonesia</h2>
            <p class="heading2">1234567890 a.n Muhammad Faiz Akbar</p>
         </div>
      </div>
   </div>

   <!-- Add new box below the existing ones and above the Confirmation button -->
   <div class="extra-content">
      <h2 class="heading22">Additional Information</h2>
      <?php if ($fetch_orders) { ?>
         <p class="heading3">Amount to be paid Rp. <?= $fetch_orders['total_price']; ?></p>
      <?php } else { ?>
         <p>No orders found.</p>
      <?php } ?>
      <p class="heading4">Please confirm the transaction using the button below</p>
   </div>

   <div class="button-container">
      <button type="button" onclick="location.href='https://wa.me/081362096752'">Confirmation</button>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>

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
