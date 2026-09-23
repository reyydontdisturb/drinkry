<?php

include 'koneksi.php';

$query_produk = "SELECT id_produk, nama_produk, harga, stok FROM produk";
$result_produk = mysqli_query($conn, $query_produk);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Stok - Drinkry</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">


    <!-- HEADER -->

    <header class="header">

        <div>

            <h1>Drinkry</h1>

            <p>
                Kasir: <strong>Mahardika</strong>
            </p>

        </div>


        <nav class="navbar">

            <a href="index.php">
                Kasir
            </a>

            <a href="restok.php" class="active">
                Kelola Stok
            </a>

        </nav>

    </header>


    <!-- NAVIGASI KELOLA -->

    <div class="kelola-nav">

        <a href="restok.php" class="kelola-nav-btn active">
            Restok Barang
        </a>

        <a href="tambah_menu.php" class="kelola-nav-btn">
            Tambah Menu
        </a>

    </div>


    <!-- HEADER HALAMAN -->

    <div class="menu-header">

        <div>

            <h2>Stok Minuman</h2>

            <span>
                <?= mysqli_num_rows($result_produk); ?> menu
            </span>

        </div>

    </div>


    <!-- DAFTAR STOK -->

    <div class="stok-container">

        <?php while ($produk = mysqli_fetch_assoc($result_produk)) { ?>

            <div class="stok-card">

                <div class="stok-info">

                    <h3>
                        <?= htmlspecialchars($produk['nama_produk']); ?>
                    </h3>

                    <p>
                        Harga:
                        Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>
                    </p>

                </div>


                <div class="stok-kanan">

                    <div class="stok-status">

                        <span class="stok-label">
                            Stok sekarang
                        </span>

                        <strong class="<?= $produk['stok'] == 0 ? 'stok-habis' : ''; ?>">
                            <?= $produk['stok']; ?>
                        </strong>

                    </div>


                    <div class="stok-actions">

                        <form action="proses_restok.php" method="POST">

                            <input
                                type="hidden"
                                name="id_produk"
                                value="<?= $produk['id_produk']; ?>"
                            >

                            <div class="restok-control">

                                <button
                                    type="button"
                                    class="btn-jumlah btn-minus"
                                >
                                    −
                                </button>

                                <input
                                    type="number"
                                    name="jumlah_restock"
                                    min="1"
                                    value="1"
                                    required
                                >

                                <button
                                    type="button"
                                    class="btn-jumlah btn-plus"
                                >
                                    +
                                </button>

                            </div>

                            <button type="submit" class="btn-restok">
                                Restok
                            </button>

                        </form>


                        <a
                            href="hapus_menu.php?id=<?= $produk['id_produk']; ?>"
                            class="btn-hapus"
                            onclick="return confirm('Yakin ingin menghapus menu <?= htmlspecialchars($produk['nama_produk']); ?>?');"
                        >
                            Hapus
                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>


    <footer>
        Drinkry
    </footer>

</div>


<script>

document.querySelectorAll('.restok-control').forEach(function(control) {

    const input = control.querySelector('input');
    const minus = control.querySelector('.btn-minus');
    const plus = control.querySelector('.btn-plus');


    minus.addEventListener('click', function() {

        let jumlah = parseInt(input.value) || 1;

        if (jumlah > 1) {
            jumlah--;
        }

        input.value = jumlah;

    });


    plus.addEventListener('click', function() {

        let jumlah = parseInt(input.value) || 1;

        jumlah++;

        input.value = jumlah;

    });


    input.addEventListener('wheel', function(event) {

        event.preventDefault();

    }, { passive: false });


    input.addEventListener('input', function() {

        let jumlah = parseInt(input.value) || 1;

        if (jumlah < 1) {
            jumlah = 1;
        }

        input.value = jumlah;

    });

});

</script>

</body>

</html>