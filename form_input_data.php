<?php
    // file koneksi
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "servis_komputer";

    $koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

    // menghasilkan kode unik otomatis
    $tampil_kode_unik = mysqli_query($koneksi, "SELECT kode FROM kode_unik WHERE digunakan = 0 LIMIT 1");
    $data_kode_unik = mysqli_fetch_array($tampil_kode_unik);

    // Jika ada kode unik yang belum digunakan
    if ($data_kode_unik) {
        $vkode = $data_kode_unik['kode'];
    } else {
        // Jika semua kode unik sudah digunakan
        $vkode = "Kode Tidak Tersedia";
    }

    // Jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        // Pengujian apakah data akan diedit atau disimpan baru
        if(isset($_GET['hal']) && $_GET['hal'] == "edit")
        {
            // Data akan diedit
            $edit = mysqli_query($koneksi, "UPDATE pelanggan SET
                                kode_unik = '$_POST[tkode]',  
                                nama = '$_POST[tnama]', 
                                no_hp = '$_POST[tno_hp]', 
                                alamat = '$_POST[talamat]',
                                jasa_reparasi = '$_POST[tjasa_reparasi]'
                            WHERE id_pelanggan = '$_GET[id]'  
            ");

            if($edit) // jika edit sukses
            {
                echo "<script>
                        alert('Edit data sukses!');
                        document.location='daftar_pelanggan.php'; // Mengarahkan ke daftar_pelanggan.php
                    </script>";
            }   
            else
            {
                echo "<script>
                        alert('Edit data GAGAL!!');
                        document.location='index.php';
                    </script>";
            }
        }
        else
        {
            // Data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO pelanggan (kode_unik, nama, no_hp, alamat, jasa_reparasi)
            VALUES ('$vkode', 
                    '$_POST[tnama]', 
                    '$_POST[tno_hp]',
                    '$_POST[talamat]',
                    '$_POST[tjasa_reparasi]')
            ");

            if($simpan) // jika simpan sukses
            {
                // Set kode unik yang sudah digunakan
                mysqli_query($koneksi, "UPDATE kode_unik SET digunakan = 1 WHERE kode = '$vkode'");
                
                echo "<script>
                        alert('Simpan data SUKSES!');
                        document.location='daftar_pelanggan.php'; // Mengarahkan ke daftar_pelanggan.php
                    </script>";
            }   
            else
            {
                echo "<script>
                        alert('Simpan data GAGAL!!');
                        document.location='index.php';
                    </script>";
            } 
        }   
    }

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
                        document.location='index.php';
                    </script>";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Input Data Pelanggan</title>
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
        <h1 class="text-center">Input Data Pelanggan</h1>
        <h2 class="text-center">Toko TechHealers Palopo</h2>
        <h3 class="text-center">Service Computer Solution</h3>
    </div>
    <link rel ="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <div class="card mt-1">
        <div class="card-header bg-primary text-white ">
            Form Input Data Pelanggan
        </div>
        <div class="card-body">
            <form method="post" action="" >
                <div class="form-group mt-1">
                    <label>Kode Pelanggan</label>
                    <input type="text" name="tkode" value="<?= $vkode ?>" class="form-control"
                        placeholder="Input Kode Pelanggan di sini!" readonly>
                </div>
                <div class="form-group mt-1">
                    <label>Nama</label>
                    <input type="text" name="tnama" value="<?= @$vnama ?>" class="form-control"
                        placeholder="Input Nama anda di sini!" required>
                </div>
                <div class="form-group mt-1">
                    <label>No. HP</label>
                    <textarea class="form-control" name="tno_hp"
                        placeholder="Input No. HP anda di sini!"><?= @$vno_hp ?></textarea>
                </div>
                <div class="form-group mt-1">
                    <label>Alamat</label>
                    <textarea class="form-control" name="talamat" placeholder="Input Alamat anda di sini!" style="height: 60px;"><?= @$valamat ?></textarea>
                </div>
                <div class = "button mt-1">
                    <div class="form-group">
                        <label>Jasa Reparasi (Servis)</label>
                        <select class="form-control" name="tjasa_reparasi" required>
                            <option value="<?=@$vjasa_reparasi?>"><?=@$vjasa_reparasi?></option>
                            <option value="Install Ulang    [100 - 150 ribuan]">Install Ulang    [100 - 150 ribuan]</option>
                            <option value="Ganti Keyboard   [100.000 - 500 ribuan]">Ganti Keyboard   [100.000 - 500 ribuan]</option>
                            <option value="Ganti Touchpad   [200 - 400.000 ribuan]">Ganti Touchpad   [200 - 400.000 ribuan]</option>
                            <option value="Ganti Engsel     [100 - 200 ribuan]">Ganti Engsel     [100 - 200 ribuan]</option>
                            <option value="Ganti Kipas Baru [100 - 200 ribuan]">Ganti Kipas Baru [100 - 200 ribuan]</option>
                            <option value="Ganti LCD        [700 - 1,5 jutaan]">Ganti LCD      [700 - 1,5 jutaan]</option>
                            <option value="Ganti Harddisk    [320 - 800 ribuan]">Virus/Malware     [320 - 800 ribuan]</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                        <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
                </div>
            </form>
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