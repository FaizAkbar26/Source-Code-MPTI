-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2024 at 05:57 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(75, 15, 1, 'Tent', 20000, 1, 'Picture1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 4, 'Muhammad Faiz Akbar', 'faizakbarmei@gmail.com', '081362096752', 'dasdsadsasadsadsadas'),
(2, 4, 'Muhammad Faiz Akbar', 'faizakbarmei@gmail.com', '321312', 'ndjnsajndsandjndksandksandksandksandksandksandsakndksandksadnsakdnskandsakdnsakdnsandaskdnsadnsakdsakdnsakndskadnskadnsakndsakndsakndsak');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `label` varchar(500) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `image_payment` varchar(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `label`, `address`, `total_products`, `total_price`, `image_payment`, `placed_on`, `payment_status`) VALUES
(33, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Cash on Delivery', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Kursi Lipat (18000 x 1) ', 18000, '1718448734_data-08-00096-g003.png', '2024-06-15', 'pending'),
(34, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Credit Card', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Kursi Lipat (18000 x 1) Tenda 3x3 (20000 x 1) ', 38000, '1718452758_Untitled Diagram-Page-4.drawio.png', '2024-06-15', 'pending'),
(35, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Matras (12000 x 1) Tenda 3x3 (20000 x 1) ', 32000, '1718710570_bg2.jpg', '2024-06-18', 'completed'),
(36, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Tenda 3x3 (20000 x 1) ', 20000, '1718710968_bni.png', '2024-06-18', 'pending'),
(37, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Tenda 3x3 (20000 x 1) ', 20000, '1718711018_bg1.jpg', '2024-06-18', 'pending'),
(38, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Tenda 3x3 (20000 x 19) ', 380000, '1718711131_bca.png', '2024-06-18', 'pending'),
(39, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Tenda 3x3 (20000 x 1) ', 20000, '1718714897_bsi.png', '2024-06-18', 'pending'),
(40, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Tenda 3x3 (20000 x 1) ', 20000, '1718715334_bni.png', '2024-06-18', 'pending'),
(41, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Tenda 3x3 (20000 x 1) ', 20000, '1718715360_bca.png', '2024-06-18', 'pending'),
(42, 4, 'Muhammad Faiz Akbar', '0813620967', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'Jl.pendidikan Gg Sempurba No13d, Medan, Sumatera Utara, Indonesia - 20157', 'Kursi Lipat (18000 x 1) ', 18000, '1718715398_bri.png', '2024-06-18', 'pending'),
(43, 15, 'dasd', '2324233', 'faizakbarmei@gmail.com', 'Qris', 'Apartment', 'dsadsa, dsa, dsa, Indonesia - 312', 'Tent (20000 x 1) Foldable Chair (18000 x 1) ', 38000, '1719154359_IMG_0858.JPG', '2024-06-23', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`, `stock`) VALUES
(1, 'Tent', 'Tenda ini dibangun dengan bahan-bahan berkualitas tinggi yang tahan air dan tahan angin, menjadikannya cocok untuk digunakan dalam berbagai kondisi cuaca. Dilengkapi dengan rangka yang kuat dan stabil, tenda ini mampu bertahan di bawah tekanan angin dan beban cuaca lainnya.', 20000, 'Picture1.jpg', 'bg4.jpg', 'bg3.jpg', 75),
(3, 'Foldable Chair', 'Kursi lipat camping adalah pilihan yang praktis dan portabel untuk menambah kenyamanan di alam terbuka. Dengan desain ringkas dan kokoh, kursi ini mudah dilipat dan dibawa ke mana saja. Meskipun ringkas, kursi ini tetap nyaman dengan dukungan ergonomis untuk punggung dan tempat duduk yang luas.', 18000, 'Picture4.png', 'Picture9.png', 'Picture10.png', 1119),
(4, 'Sleeping Bag', 'Sleeping bag atau kantung tidur adalah peralatan penting yang digunakan untuk berkemah, mendaki gunung, dan berbagai aktivitas luar ruangan lainnya. Fungsi utama dari sleeping bag adalah menyediakan kehangatan dan kenyamanan saat tidur di luar ruangan.', 23000, 'Picture3.jpg', 'Picture3.jpg', 'Picture3.jpg', 100),
(5, 'Mattress', 'Matras adalah peralatan penting yang digunakan untuk tidur atau beristirahat di berbagai situasi, terutama saat berkemah, mendaki gunung, atau melakukan perjalanan luar ruangan lainnya.', 12000, 'Picture5.jpg', 'Picture5.jpg', 'Picture5.jpg', 100),
(6, 'Bag', 'Tas gunung, juga dikenal sebagai ransel hiking atau backpack hiking, adalah jenis tas yang dirancang khusus untuk digunakan selama kegiatan pendakian gunung atau trekking. Dapat menampung berbagai peralatan dan perlengkapan yang dibutuhkan selama perjalanan.', 15000, 'Picture7.jpg', 'Picture7.jpg', 'Picture7.jpg', 100),
(7, 'Foldable Table', 'Meja camping adalah peralatan praktis yang dirancang untuk digunakan saat berkemah, piknik, atau aktivitas luar ruangan lainnya. Terbuat dari bahan ringan seperti aluminium, plastik, atau kayu, meja ini dirancang untuk mudah dibawa dan disimpan karena dapat dilipat menjadi ukuran kecil.', 16000, 'Picture8.jpg', 'Picture8.jpg', 'Picture8.jpg', 100),
(8, 'Portable Stove', 'Portable stove atau kompor portabel adalah perangkat yang dirancang untuk memasak saat berkemah, hiking, atau dalam situasi darurat. Kompor ini ringan, mudah dibawa, dan dapat beroperasi dengan berbagai jenis bahan bakar seperti butana, propana, atau alkohol.', 25000, 'Picture11.png', 'Picture11.png', 'Picture11.png', 110),
(9, 'Flysheet', 'Flysheet adalah lembaran pelindung yang sering digunakan dalam kegiatan berkemah untuk melindungi tenda atau area berkemah dari hujan, angin, dan sinar matahari. Terbuat dari bahan tahan air dan tahan angin seperti polyester atau nylon yang dilapisi dengan lapisan anti-air.', 17000, 'Picture6.jpg', 'Picture6.jpg', 'Picture6.jpg', 100);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(2, 'zaki', 'zakiauzan@gmail.com', '9feb93307bf390233503b2c8e381ff342c35c78b'),
(3, 'zaki', 'zaki@gmail.com', '25a4fea69672eda93765e618ad2af8aa55de3ab0'),
(4, 'Faiz Akbar', 'faizakbarmei@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(5, 'Kursi Lipat', 'akakkka@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(6, 'f', 'miladftiuad@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(7, 'Kursi Lipat', 'fi@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(8, 'Kursi Lipat', 'faai@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(9, 'admin', 'fai@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(10, 'Kursi Lipat', 'faaisda@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(11, 'Kursi Lipat', 'miladftiruad@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(12, 'Muhammad Faiz Akbar', 'miladftiu32ad@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(13, 'admin', 'akbar21000182361@webmail.uad.ac.id', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(14, 'Muhammad Faiz Akbar', 'akbar210002218361@webmail.uad.ac.id', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(15, 'okta', 'okta@gmail.com', '4aaa75016a6f962e2a412102cfe9e9711a5fde6b');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
