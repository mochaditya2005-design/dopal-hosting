<?php

// koneksi database
$koneksi = mysqli_connect("localhost","root","","Dopal_hosting");

if(!$koneksi){
die("Koneksi database gagal");
}

// ambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$layanan = $_POST['layanan'];
$paket = $_POST['paket'];
$catatan = $_POST['catatan'];

// simpan ke database
mysqli_query($koneksi,"INSERT INTO orders
(nama,email,layanan,paket,catatan)
VALUES
('$nama','$email','$layanan','$paket','$catatan')");

// ambil ID order terakhir
$order_id = mysqli_insert_id($koneksi);

// format pesan whatsapp
$pesan = "Order Baru Dopal Hosting\n\n".
"Nama: $nama\n".
"Email: $email\n".
"Layanan: $layanan\n".
"Paket: $paket\n".
"Catatan: $catatan";

// kirim WA via Fonnte
$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.fonnte.com/send",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_POST => true,
CURLOPT_POSTFIELDS => [
'target' => "6285607598817",
'message' => $pesan
],
CURLOPT_HTTPHEADER => [
"Authorization: KxAYnPHj3HCfkbUnB1qE"
],
));

$response = curl_exec($curl);
curl_close($curl);

// redirect ke halaman invoice
header("Location: invoice.php?id=$order_id");
exit();

?>