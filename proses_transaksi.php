<?php

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$nama_pelanggan = trim($_POST['nama_pelanggan'] ?? '');
$uang_bayar = (int) ($_POST['uang_bayar'] ?? 0);

if ($nama_pelanggan == '') {
    die("Nama pelanggan belum diisi.");
}


// ==========================
// AMBIL PRODUK
// ==========================

$query_produk = "SELECT id_produk, nama_produk, harga, stok FROM produk";
$result_produk = mysqli_query($conn, $query_produk);

$total = 0;
$produk_dipilih = [];

while ($produk = mysqli_fetch_assoc($result_produk)) {

    $id_produk = $produk['id_produk'];

    $jumlah = (int) ($_POST['jumlah_' . $id_produk] ?? 0);

    if ($jumlah <= 0) {
        continue;
    }

    // Cek stok
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


// ==========================
// CEK PRODUK
// ==========================

if ($total == 0) {
    die("Belum ada produk yang dipilih.");
}


// ==========================
// CEK UANG
// ==========================

if ($uang_bayar < $total) {
    die("Uang pembayaran kurang.");
}

$kembalian = $uang_bayar - $total;


// ==========================
// SIMPAN PELANGGAN
// ==========================

$query_pelanggan = "INSERT INTO pelanggan (nama_pelanggan)
                    VALUES ('$nama_pelanggan')";

if (!mysqli_query($conn, $query_pelanggan)) {
    die("Gagal menyimpan pelanggan: " . mysqli_error($conn));
}

$id_pelanggan = mysqli_insert_id($conn);


// ==========================
// SIMPAN TRANSAKSI
// ==========================

$query_transaksi = "INSERT INTO transaksi (id_pelanggan, total)
                    VALUES ('$id_pelanggan', '$total')";

if (!mysqli_query($conn, $query_transaksi)) {
    die("Gagal menyimpan transaksi: " . mysqli_error($conn));
}

$id_transaksi = mysqli_insert_id($conn);


// ==========================
// SIMPAN DETAIL + KURANGI STOK
// ==========================

foreach ($produk_dipilih as $produk) {

    $id_produk = $produk['id_produk'];
    $jumlah = $produk['jumlah'];
    $subtotal = $produk['subtotal'];

    $query_detail = "INSERT INTO detail_transaksi
                    (id_transaksi, id_produk, jumlah, subtotal)
                    VALUES
                    ('$id_transaksi', '$id_produk', '$jumlah', '$subtotal')";

    if (!mysqli_query($conn, $query_detail)) {
        die("Gagal menyimpan detail transaksi: " . mysqli_error($conn));
    }


    $query_stok = "UPDATE produk
                   SET stok = stok - $jumlah
                   WHERE id_produk = '$id_produk'";

    if (!mysqli_query($conn, $query_stok)) {
        die("Gagal mengurangi stok: " . mysqli_error($conn));
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nota Transaksi</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, sans-serif;
            background: #f1f3f5;
            color: #222;
        }

        .container {
            max-width: 430px;
            margin: auto;
        }

        .nota {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #aaa;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 5px 0 0;
            color: #777;
            font-size: 14px;
        }

        .info {
            padding: 18px 0;
            border-bottom: 1px dashed #aaa;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .produk {
            padding: 18px 0;
            border-bottom: 1px dashed #aaa;
        }

        .produk-row {
            margin-bottom: 15px;
        }

        .produk-row:last-child {
            margin-bottom: 0;
        }

        .produk-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .produk-detail {
            display: flex;
            justify-content: space-between;
            color: #777;
            font-size: 13px;
        }

        .total {
            padding: 18px 0;
            border-bottom: 1px dashed #aaa;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-row:last-child {
            margin-bottom: 0;
        }

        .total-utama {
            font-size: 20px;
            font-weight: bold;
        }

        .kembalian {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
        }

        .footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #777;
        }

        .tombol {
            margin-top: 20px;
        }

        .tombol button,
        .tombol a {
            display: block;
            width: 100%;
            padding: 13px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .print {
            border: none;
            background: #222;
            color: white;
            margin-bottom: 10px;
        }

        .kembali {
            border: 1px solid #ccc;
            background: white;
            color: #222;
        }


        /* PRINT */

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .nota {
                box-shadow: none;
                border-radius: 0;
            }

            .tombol {
                display: none;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="nota">

        <!-- HEADER -->

        <div class="header">

            <h1>Drinkry</h1>

            <p>Sistem Kasir Minuman</p>

            <p>Nota Transaksi</p>

        </div>


        <!-- INFORMASI -->

        <div class="info">

            <div class="info-row">

                <span>ID Transaksi</span>

                <strong>
                    <?= $id_transaksi; ?>
                </strong>

            </div>


            <div class="info-row">

                <span>ID Pelanggan</span>

                <strong>
                    <?= $id_pelanggan; ?>
                </strong>

            </div>


            <div class="info-row">

                <span>Nama Pelanggan</span>

                <strong>
                    <?= htmlspecialchars($nama_pelanggan); ?>
                </strong>

            </div>


            <div class="info-row">

                <span>Tanggal</span>

                <strong>
                    <?= date('d/m/Y H:i'); ?>
                </strong>

            </div>

        </div>


        <!-- PRODUK -->

        <div class="produk">

            <?php foreach ($produk_dipilih as $produk) { ?>

                <div class="produk-row">

                    <div class="produk-header">

                        <span>
                            <?= htmlspecialchars($produk['nama_produk']); ?>
                        </span>

                        <span>
                            Rp <?= number_format($produk['subtotal'], 0, ',', '.'); ?>
                        </span>

                    </div>


                    <div class="produk-detail">

                        <span>
                            <?= $produk['jumlah']; ?> x
                            Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>
                        </span>

                    </div>

                </div>

            <?php } ?>

        </div>


        <!-- TOTAL -->

        <div class="total">

            <div class="total-row total-utama">

                <span>Total</span>

                <span>
                    Rp <?= number_format($total, 0, ',', '.'); ?>
                </span>

            </div>


            <div class="total-row">

                <span>Uang Bayar</span>

                <span>
                    Rp <?= number_format($uang_bayar, 0, ',', '.'); ?>
                </span>

            </div>


            <div class="total-row kembalian">

                <span>Kembalian</span>

                <span>
                    Rp <?= number_format($kembalian, 0, ',', '.'); ?>
                </span>

            </div>

        </div>


        <!-- FOOTER -->

        <div class="footer">

            <strong>Terima kasih!</strong>

            <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>

        </div>

    </div>


    <!-- BUTTON -->

    <div class="tombol">

        <button
            class="print"
            onclick="window.print()"
        >
            Print Struk
        </button>


        <a
            href="index.php"
            class="kembali"
        >
            Kembali ke Kasir
        </a>

    </div>

</div>

</body>

</html>