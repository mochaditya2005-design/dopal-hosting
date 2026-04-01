<?php

$koneksi = mysqli_connect("localhost","root","","Dopal_hosting");

$id = $_GET['id'];

$data = mysqli_query($koneksi,"SELECT * FROM orders WHERE id='$id'");
$order = mysqli_fetch_assoc($data);

$invoice = "INV-".$order['id'];

$pesan = urlencode("Halo Admin Dopal Hosting

Saya ingin konfirmasi order

Invoice : $invoice
Nama : ".$order['nama']."
Paket : ".$order['paket']);

$wa = "https://wa.me/6285607598817?text=$pesan";

?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>
<link rel="stylesheet" href="Style/style.css">
</head>

<body>

<!-- Navbar -->
    <nav id="navbar">
      <div class="container nav-container">
        <a href="#" class="logo">
          <div class="logo-icon">
            <i data-lucide="server"></i>
          </div>
          <span class="logo-text">Dopal<span class="text-gradient">Hosting</span></span>
        </a>

        <div class="desktop-nav">
          <div class="desktop-nav">
            <a href="#hosting">Hosting</a>
            <a href="#services">Layanan</a>
            <a href="#pricing">Harga</a>
            <a href="#contact">Kontak</a>
          </div>
        </div>

        <div class="desktop-cta">
          <a href="#contact" class="btn btn-primary">Contact Person</a>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-btn" id="mobile-menu-btn">
          <i data-lucide="menu"></i>
        </button>
      </div>

      <!-- Mobile Navigation -->
      <div class="mobile-nav" id="mobile-nav">

          <a href="#hosting" class="mobile-link">Hosting</a>
          <a href="#services" class="mobile-link">Layanan</a>
          <a href="#pricing" class="mobile-link">Harga</a>
          <a href="#contact" class="mobile-link">Kontak</a>
        <div class="mobile-cta">
          <a href="#contact" class="btn btn-primary">Contact Person</a>
        </div>
      </div>
    </nav>

<div class="invoice-card">

<h2>Invoice Dopal Hosting</h2>

<p><b>Invoice ID :</b> <?php echo $invoice; ?></p>
<p><b>Nama :</b> <?php echo $order['nama']; ?></p>
<p><b>Email :</b> <?php echo $order['email']; ?></p>
<p><b>Layanan :</b> <?php echo $order['layanan']; ?></p>
<p><b>Paket :</b> <?php echo $order['paket']; ?></p>

<a href="<?php echo $wa; ?>" class="btn-wa">
Konfirmasi via WhatsApp
</a>

</div>

</body>
</html>