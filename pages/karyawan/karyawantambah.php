<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Data Karyawan</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=karyawandata" class="btn btn-primary float-end">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <div class="col">
        <?php
        if (isset($_POST['simpan_button'])) {
            $nama_karyawan = $_POST['nama_karyawan'];
            $nomor_hp = $_POST['nomor_hp'];
            $alamat = $_POST['alamat'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_ulangi = $_POST['password_ulangi'];
            $checkSQL = "SELECT * FROM karyawan WHERE email = '$email'";
            $resultCheck = mysqli_query($koneksi, $checkSQL);
            $sudahAda = (mysqli_num_rows($resultCheck) > 0) ? true : false;
            if ($sudahAda) {
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    Email sama sudah ada
                </div>
                <?php
            } else {

                $passwordBeda = $password != $password_ulangi ? true : false;

                if ($passwordBeda) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle"></i>
                        Password Beda
                    </div>
                    <?php
                } else {
                    $insertSQL = "INSERT INTO karyawan SET nama_karyawan='$nama_karyawan', 
                    nomor_hp='$nomor_hp',
                    alamat='$alamat',
                    email='$email',
                    password=MD5('$password'),
                    level='user'";
                    $result = mysqli_query($koneksi, $insertSQL);
                    if (!$result) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i>
                            <?= mysqli_error($koneksi) ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fa fa-check-circle"></i>
                        Data berhasil ditambahkan
                    </div>
        <?php
                }
            }
        }
        ?>
    </div>
</div>
<div id="bawah" class="row">
    <div class="col">
        <div class="card px-3 py-3">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="nama_karyawan">Nama Karyawan</label>
                    <input type="text" class="form-control" name="nama_karyawan" required>
                </div>
                <div class="mb-3">
                    <label for="nomor_hp">HP</label>
                    <input type="text" class="form-control" name="nomor_hp" required>
                </div>
                <div class="mb-3">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password_ulangi" required>
                </div>
                <div class="col mb-3">
                    <button class="btn btn-success" type="submit" name="simpan_button">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>