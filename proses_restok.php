<?php

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: restok.php");
    exit;

}


$id_produk = (int) $_POST['id_produk'];

$jumlah_restock = (int) $_POST['jumlah_restock'];


if ($jumlah_restock <= 0) {

    header("Location: restok.php");
    exit;

}


$query = "UPDATE produk
          SET stok = stok + $jumlah_restock
          WHERE id_produk = $id_produk";


mysqli_query($conn, $query);


header("Location: restok.php");
exit;