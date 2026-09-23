<?php
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Menu - Drinkry</title>

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

        <a href="restok.php" class="kelola-nav-btn">
            Restok Barang
        </a>

        <a href="tambah_menu.php" class="kelola-nav-btn active">
            Tambah Menu
        </a>

    </div>


    <!-- HEADER TAMBAH MENU -->

    <div class="tambah-menu-header">

        <div>

            <h2>Tambah Menu</h2>

            <p>
                Tambahkan menu minuman baru ke dalam daftar.
            </p>

        </div>

    </div>


    <!-- FORM -->

    <form
        action="proses_tambah_menu.php"
        method="POST"
        class="form-menu"
    >


        <!-- NAMA MENU -->

        <div class="form-group">

            <label for="nama_produk">
                Nama Menu
            </label>

            <input
                type="text"
                id="nama_produk"
                name="nama_produk"
                placeholder="Masukkan Nama Menu"
                required
            >

        </div>


        <!-- GAMBAR -->

        <div class="form-group">

            <label for="gambar">
                Nama File Gambar
            </label>

            <input
                type="text"
                id="gambar"
                name="gambar"
                placeholder="Masukkan Foto Menu"
                required
            >

            <small>
                Masukkan nama file foto yang sudah ada di folder img.
            </small>

        </div>


        <!-- HARGA -->

        <div class="form-group">

            <label for="harga">
                Harga
            </label>

            <input
                type="number"
                id="harga"
                name="harga"
                placeholder="0"
                min="0"
                required
            >

        </div>


        <!-- STOK -->

        <div class="form-group">

            <label for="stok">
                Stok Awal
            </label>


            <div class="tambah-stok-control">

                <button
                    type="button"
                    class="btn-stok"
                    onclick="kurangStok()"
                >
                    −
                </button>


                <input
                    type="number"
                    id="stok"
                    name="stok"
                    value="0"
                    min="0"
                    required
                >


                <button
                    type="button"
                    class="btn-stok"
                    onclick="tambahStok()"
                >
                    +
                </button>

            </div>

        </div>


        <!-- TOMBOL -->

        <div class="form-menu-buttons">

            <a
                href="restok.php"
                class="btn-batal"
            >
                Batal
            </a>


            <button
                type="submit"
                class="btn-tambah-menu"
            >
                Simpan Menu
            </button>

        </div>

    </form>


    <footer>
        Drinkry
    </footer>


</div>


<script>

function kurangStok() {

    const stok = document.getElementById('stok');

    let jumlah = parseInt(stok.value) || 0;

    if (jumlah > 0) {
        jumlah--;
    }

    stok.value = jumlah;
}


function tambahStok() {

    const stok = document.getElementById('stok');

    let jumlah = parseInt(stok.value) || 0;

    jumlah++;

    stok.value = jumlah;
}


document
    .getElementById('stok')
    .addEventListener('input', function() {

        if (this.value === '') {
            return;
        }

        let jumlah = parseInt(this.value);

        if (isNaN(jumlah) || jumlah < 0) {
            this.value = 0;
        }

    });

</script>

</body>

</html>