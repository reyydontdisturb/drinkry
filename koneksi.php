<?php

$conn = mysqli_connect("localhost", "root", "", "drinkry");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}