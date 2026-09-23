<?php

include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: restok.php");
    exit;
}

$id_produk = (int) $_GET['id'];


/* Cek apakah menu sudah pernah dipakai dalam transaksi */

$cek = mysqli_query(
    $conn,
    "SELECT id_detail
     FROM detail_transaksi
     WHERE id_produk = $id_produk
     LIMIT 1"
);


if (mysqli_num_rows($cek) > 0) {

    echo "<script>
        alert('Menu tidak bisa dihapus karena sudah pernah digunakan dalam transaksi!');
        window.location.href = 'restok.php';
    </script>";

    exit;
}


/* Hapus menu */

$query = "DELETE FROM produk WHERE id_produk = $id_produk";


if (mysqli_query($conn, $query)) {

    echo "<script>
        alert('Menu berhasil dihapus!');
        window.location.href = 'restok.php';
    </script>";

} else {

    echo "<script>
        alert('Menu gagal dihapus!');
        window.location.href = 'restok.php';
    </script>";

}

?>