<?php

session_start();

//bikin koneksi
$c = mysqli_connect('localhost','root','','kasir');

//login
if(isset($_POST['login'])){
    //Initiate variable
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($c,"SELECT * FROM user WHERE username='$username' and password='$password' ");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        $_SESSION['login'] = 'True';
        header('location:index.php');
    } else {
        echo '      
        <script>
        alert("username atau password salah")
        window.location.href="login.php"
        </script>';
    }
}

// Tambah barang

if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($c,"insert into produk (namaproduk,deskripsi,harga,stock) values ('$namaproduk','$deskripsi','$harga','$stock')");

    if($insert){
        header('location:stock.php');
    } else {
        echo '
        <script>
        alert("Gagal input barang!")
        window.location.href="stock.php"
        </script>';
    }
}

//tambah pelanggan

if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    

    $insert = mysqli_query($c,"insert into pelanggan (namapelanggan,notelp,alamat) values ('$namapelanggan','$notelp','$alamat')");

    if($insert){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>
        alert("Gagal menambah pelanggan !")
        window.location.href="pelanggan.php"
        </script>';
    }
}

//tambah orderan

if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];
    

    $insert = mysqli_query($c,"insert into pesanan (idpelanggan) values ('$idpelanggan')");

    if($insert){
        header('location:index.php');
    } else {
        echo '
        <script>
        alert("Gagal menambah pesanan !")
        window.location.href="index.php"
        </script>';
    }
}

//tambah produk orderan

if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];
    $idp = $_POST['idp'];
    
    //hitung stok
    $hitung1 = mysqli_query($c,"select * from produk where idproduk='$idproduk'");
    $hitung2= mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; //stok barang saat ini

    if($stocksekarang>=$qty){
        //kurangi stock
        $selisih = $stocksekarang-$qty;
        
        //stock ckup
         $insert = mysqli_query($c,"insert into detailpesanan (idpesanan,idproduk,qty) values ('$idp','$idproduk','$qty')");
         $update = mysqli_query($c,"update produk set stock='$selisih' where idproduk='$idproduk'");
         if($insert&&$update){
            header('location:view.php?idp='.$idp);
         } else {
            echo '
            <script>
            alert("Gagal menambah pesanan baru")
            window.location.href="view.php?idp='.$idp.'"
            </script>';
         }
    } else {
        //stock gk cukup
        echo '
        <script>
        alert("Stock barang tidak cukup !")
        window.location.href="view.php?idp='.$idp.'"
        </script>';
    }
}


?>