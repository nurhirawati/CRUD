<?php
    // file koneksi 
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "servis_komputer";

    $koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

    // Pengujian jika tombol Edit / Hapus diklik
    if(isset($_GET['hal']))
    {
        // Pengujian jika edit data
        if($_GET['hal'] == "edit")
        {
            // Tampilkan Data yang akan diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                // Jika data ditemukan, maka data ditampung ke dalam variabel
                $vkode = $data['kode_unik'];
                $vnama = $data['nama'];
                $vno_hp = $data['no_hp'];
                $valamat = $data['alamat'];
                $vjasa_reparasi = $data['jasa_reparasi'];
            }
        }
        else if ($_GET['hal'] == "hapus")
        {
            // Persiapan hapus data 
            $hapus = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus data sukses!!');
                        window.location='daftar_pelanggan.php';  // Perubahan ini
                    </script>";
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Daftar Pelanggan</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="sidebar">
        <a href="index.php"><img src="https://i.ibb.co/rkD7GVF/logo-home.png" alt="logo-home" border="0"> Home</a>
        <a href="form_input_data.php"><img src="https://i.ibb.co/Vx9RdZH/input-data-1.png" alt="input-data-1" border="0"> Input Data</a>
        <a href="daftar_pelanggan.php"><img src="https://i.ibb.co/1vfD15y/daftar-4.jpg" alt="daftar-1" border="0"> Daftar Pelanggan</a>
    </div>
    <div class="content">
        <div class="container">
        <h1 class="text-center">Data Pelanggan</h1>
        <h2 class="text-center">Toko TechHealers Palopo</h2>
        <h3 class="text-center">Service Computer Solution</h3>
    </div>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    
    <link rel ="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Daftar Pelanggan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Alamat</th>
                    <th>Jasa Reparasi</th>
                    <th>Aksi</th>
                </tr>
                <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
                    while ($data = mysqli_fetch_array($tampil)) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['kode_unik'] ?></td>
                    <td><?= $data['nama'] ?></td>
                    <td><?= $data['no_hp'] ?></td>
                    <td><?= $data['alamat'] ?></td>
                    <td><?= $data['jasa_reparasi'] ?></td>
                    <td>
                        <a href="form_input_data.php?hal=edit&id=<?= $data['id_pelanggan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="form_input_data.php?hal=hapus&id=<?= $data['id_pelanggan'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <div class="footer-container">
        <div></div>
        <footer>
            <div class="footer-table">
                <div class="footer-table-row">
                    <img class="footer-image" src="https://i.ibb.co/6NpjX23/foto-nunu.jpg" alt="Your Photo">
                    <div class="footer-table-cell">&copy; 653_Nur Hirawati</div>
                </div>
            </div>
        </footer>
        <div></div>
    </div>
    <script type="text/javascript" src="js/bootstrap.min.js"></script> 
</body>
</html>