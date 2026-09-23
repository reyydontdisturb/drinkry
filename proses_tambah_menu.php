<?php

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: restok.php");
    exit;
}

$nama_produk = trim($_POST['nama_produk']);
$gambar = basename(trim($_POST['gambar']));
$harga = (int) $_POST['harga'];
$stok = (int) $_POST['stok'];


// Cek input
if ($nama_produk == '' || $gambar == '' || $harga < 0 || $stok < 0) {
    header("Location: tambah_menu.php");
    exit;
}


// Cek format gambar
$ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
    echo "<script>
        alert('Format gambar harus JPG, JPEG, PNG, atau WEBP!');
        window.location.href = 'tambah_menu.php';
    </script>";
    exit;
}


// Cek apakah gambar ada di folder img
if (!file_exists('img/' . $gambar)) {
    echo "<script>
        alert('File gambar tidak ditemukan di folder img!');
        window.location.href = 'tambah_menu.php';
    </script>";
    exit;
}


// Amankan data
$nama_aman = mysqli_real_escape_string($conn, $nama_produk);
$gambar_aman = mysqli_real_escape_string($conn, $gambar);


// Cek apakah nama menu sudah ada
$cek = mysqli_query(
    $conn,
    "SELECT id_produk FROM produk
     WHERE nama_produk = '$nama_aman'"
);

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Menu tersebut sudah ada!');
        window.location.href = 'tambah_menu.php';
    </script>";
    exit;
}


// Simpan menu
$query = "INSERT INTO produk
          (nama_produk, gambar, harga, stok)
          VALUES
          ('$nama_aman', '$gambar_aman', $harga, $stok)";


if (mysqli_query($conn, $query)) {

    echo "<script>
        alert('Menu berhasil ditambahkan!');
        window.location.href = 'restok.php';
    </script>";

} else {

    echo "<script>
        alert('Menu gagal ditambahkan!');
        window.location.href = 'tambah_menu.php';
    </script>";

}

?>