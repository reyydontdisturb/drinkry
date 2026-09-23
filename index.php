<?php

include 'koneksi.php';

$query_produk = "SELECT id_produk, nama_produk, gambar, harga, stok FROM produk";
$result_produk = mysqli_query($conn, $query_produk);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Drinkry</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">


    <!-- HEADER -->

    <header class="header">

        <div>
            <h1>Drinkry</h1>
            <p>Kasir: <strong>Mahardika</strong></p>
        </div>

        <nav class="navbar">

            <a href="index.php" class="active">
                Kasir
            </a>

            <a href="restok.php">
                Kelola Stok
            </a>

        </nav>

    </header>


    <form action="pembayaran.php" method="POST">


        <!-- PELANGGAN -->

        <div class="customer-section">

            <label>Nama Customers</label>

            <input
                type="text"
                name="nama_pelanggan"
                placeholder="Masukkan nama customers"
                value="customers"
                required
            >

        </div>


        <!-- MENU -->

        <div class="menu-header">

            <h2>Menu Minuman</h2>

            <span>
                <?= mysqli_num_rows($result_produk); ?> menu
            </span>

        </div>


        <div class="produk-container">


            <?php while ($produk = mysqli_fetch_assoc($result_produk)) { ?>


                <div class="produk-card">


                    <!-- FOTO -->

                    <div class="produk-image">

                        <?php if (!empty($produk['gambar'])) { ?>

                            <img
                                src="img/<?= htmlspecialchars($produk['gambar']); ?>"
                                alt="<?= htmlspecialchars($produk['nama_produk']); ?>"
                            >

                        <?php } ?>


                    </div>


                    <!-- INFO -->

                    <div class="produk-info">


                        <div class="produk-name">

                            <h3>
                                <?= htmlspecialchars($produk['nama_produk']); ?>
                            </h3>

                            <span>
                                Stok <?= $produk['stok']; ?>
                            </span>

                        </div>


                        <div class="produk-bottom">


                            <strong>
                                Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>
                            </strong>


                            <div class="jumlah">

                                <label>Qty</label>

                                <div class="jumlah-control">

                                    <button
                                        type="button"
                                        class="btn-jumlah btn-minus"
                                        data-target="jumlah_<?= $produk['id_produk']; ?>"
                                    >
                                        −
                                    </button>

                                    <input
                                        type="number"
                                        id="jumlah_<?= $produk['id_produk']; ?>"
                                        name="jumlah_<?= $produk['id_produk']; ?>"
                                        class="jumlah-produk"
                                        data-harga="<?= $produk['harga']; ?>"
                                        value="0"
                                        min="0"
                                        max="<?= $produk['stok']; ?>"
                                        <?= $produk['stok'] <= 0 ? 'disabled' : ''; ?>
                                    >

                                    <button
                                        type="button"
                                        class="btn-jumlah btn-plus"
                                        data-target="jumlah_<?= $produk['id_produk']; ?>"
                                        <?= $produk['stok'] <= 0 ? 'disabled' : ''; ?>
                                    >
                                        +
                                    </button>

                                </div>

                            </div>


                        </div>


                    </div>


                </div>


            <?php } ?>


        </div>


        <!-- TOTAL -->

        <div class="checkout">

            <div class="checkout-total">

                <span>Total</span>

                <strong id="total">
                    Rp 0
                </strong>

            </div>


            <button type="submit" class="btn-primary">
                Lanjut ke Pembayaran
            </button>

        </div>


    </form>


    <footer>
        Drinkry
    </footer>


</div>


<script>

const inputJumlah = document.querySelectorAll('.jumlah-produk');

const totalElement = document.getElementById('total');


function hitungTotal() {

    let total = 0;


    inputJumlah.forEach(function(input) {

        const harga = parseInt(input.dataset.harga);

        const jumlah = parseInt(input.value) || 0;

        total += harga * jumlah;

    });


    totalElement.textContent =
        'Rp ' + total.toLocaleString('id-ID');

}


// Tombol + dan -
document.querySelectorAll('.btn-jumlah').forEach(function(button) {

    button.addEventListener('click', function() {

        const targetId = button.dataset.target;

        const input = document.getElementById(targetId);

        if (input.disabled) {
            return;
        }

        let jumlah = parseInt(input.value) || 0;

        const min = parseInt(input.min) || 0;

        const max = parseInt(input.max);


        if (button.classList.contains('btn-plus')) {

            if (jumlah < max) {
                jumlah++;
            }

        } else {

            if (jumlah > min) {
                jumlah--;
            }

        }


        input.value = jumlah;

        hitungTotal();

    });

});


// Kalau angka diketik manual, total tetap berubah
inputJumlah.forEach(function(input) {

    input.addEventListener('input', function() {

        let jumlah = parseInt(input.value) || 0;

        const min = parseInt(input.min) || 0;

        const max = parseInt(input.max);


        if (jumlah < min) {
            jumlah = min;
        }

        if (jumlah > max) {
            jumlah = max;
        }


        input.value = jumlah;

        hitungTotal();

    });


    // Mencegah scroll mouse/trackpad mengubah jumlah
    input.addEventListener('wheel', function(event) {

        event.preventDefault();

    }, { passive: false });

});


</script>


</body>

</html>