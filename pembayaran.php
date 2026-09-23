<?php

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');

if ($nama_pelanggan == '') {
    die("Nama pelanggan belum diisi.");
}

$total = 0;

$query_produk = "SELECT id_produk, nama_produk, harga, stok FROM produk";
$result_produk = mysqli_query($conn, $query_produk);

$produk_dipilih = [];

while ($produk = mysqli_fetch_assoc($result_produk)) {

    $id_produk = $produk['id_produk'];

    $jumlah = (int) ($_POST['jumlah_' . $id_produk] ?? 0);

    if ($jumlah > 0) {

        if ($jumlah > $produk['stok']) {
            die("Stok {$produk['nama_produk']} tidak cukup.");
        }

        $subtotal = $produk['harga'] * $jumlah;

        $total += $subtotal;

        $produk_dipilih[] = [
            'id_produk' => $id_produk,
            'nama_produk' => $produk['nama_produk'],
            'harga' => $produk['harga'],
            'jumlah' => $jumlah,
            'subtotal' => $subtotal
        ];
    }
}

if ($total == 0) {
    die("Belum ada produk yang dipilih.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran - Drinkry</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <header class="header">

        <h1>Drinkry</h1>

        <div class="kasir">
            Kasir: <strong>Mahardika</strong>
        </div>

    </header>


    <div class="payment-header">

        <h2>Pembayaran</h2>

        <a href="index.php">
            ← Kembali
        </a>

    </div>


    <div class="payment-layout">


        <!-- DETAIL PESANAN -->

        <div class="section">

            <h2>Detail Pesanan</h2>


            <div class="customer-box">

                <span>Pelanggan</span>

                <strong>
                    <?= htmlspecialchars($nama_pelanggan); ?>
                </strong>

            </div>


            <?php foreach ($produk_dipilih as $produk) { ?>

                <div class="order-row">

                    <div>

                        <div class="order-name">
                            <?= htmlspecialchars($produk['nama_produk']); ?>
                        </div>

                        <div class="order-detail">

                            <?= $produk['jumlah']; ?> ×
                            Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>

                        </div>

                    </div>


                    <div class="order-price">

                        Rp <?= number_format($produk['subtotal'], 0, ',', '.'); ?>

                    </div>

                </div>

            <?php } ?>


            <div class="grand-total">

                <span>Total Pembayaran</span>

                <strong>
                    Rp <?= number_format($total, 0, ',', '.'); ?>
                </strong>

            </div>

        </div>


        <!-- PEMBAYARAN -->

        <div class="payment-card">

            <h3>Pembayaran</h3>


            <div class="payment-total">

                <span>Total yang harus dibayar</span>

                <strong>
                    Rp <?= number_format($total, 0, ',', '.'); ?>
                </strong>

            </div>


            <form action="proses_transaksi.php" method="POST">

                <input
                    type="hidden"
                    name="nama_pelanggan"
                    value="<?= htmlspecialchars($nama_pelanggan); ?>"
                >


                <?php foreach ($produk_dipilih as $produk) { ?>

                    <input
                        type="hidden"
                        name="jumlah_<?= $produk['id_produk']; ?>"
                        value="<?= $produk['jumlah']; ?>"
                    >

                <?php } ?>


                <label class="payment-label">
                    Uang diterima
                </label>


                <input
                    type="number"
                    name="uang_bayar"
                    id="uang_bayar"
                    class="payment-input"
                    placeholder="Rp 0"
                    min="<?= $total; ?>"
                    required
                >


                <div class="change-box">

                    <span>Kembalian</span>

                    <strong id="kembalian">
                        Rp 0
                    </strong>

                </div>


                <button
                    type="submit"
                    class="btn-pay"
                    id="btn-bayar"
                    disabled
                >
                    Bayar & Cetak Nota
                </button>

            </form>


            <div class="payment-note">
                Pastikan uang yang diterima sudah sesuai.
            </div>

        </div>

    </div>

</div>


<script>

const total = <?= $total; ?>;

const uangInput = document.getElementById('uang_bayar');

const kembalian = document.getElementById('kembalian');

const tombolBayar = document.getElementById('btn-bayar');


uangInput.addEventListener('input', function () {

    const uang = parseInt(this.value) || 0;


    if (uang >= total) {

        const hasil = uang - total;

        kembalian.textContent =
            'Rp ' + hasil.toLocaleString('id-ID');

        tombolBayar.disabled = false;

    } else {

        kembalian.textContent = 'Uang kurang';

        tombolBayar.disabled = true;

    }

});

</script>

</body>

</html>