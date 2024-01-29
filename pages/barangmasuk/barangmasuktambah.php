<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Data Barang Masuk</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=barangmasukdata" class="btn btn-primary float-end">
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
            $tanggal = $_POST['tanggal'];
            $sumber_dana = $_POST['sumber_dana'];
            $pemasok_id = $_POST['pemasok_id'];
            $karyawan_id = $_POST['karyawan_id'];

            $insertSQL = "INSERT INTO barang_masuk SET tanggal='$tanggal', 
            sumber_dana='$sumber_dana', pemasok_id=$pemasok_id, karyawan_id=$karyawan_id";
            $result = mysqli_query($koneksi, $insertSQL);
            if (!$result) {
        ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa fa-exclamation-circle"></i>
                    <?= mysqli_error($koneksi) ?>
                </div>
            <?php
            } else {
            ?>
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check-circle"></i>
                    Data berhasil ditambahkan
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>
<div id="bawah" class="row">
    <div class="col">
        <form action="" method="post">
            <div class="card px-3 py-3">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="id">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required value="<?= date("Y-m-d") ?>">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="id">Sumber Dana</label>
                            <select name="sumber_dana" id="" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Hibah">Hibah</option>
                                <option value="Penganggaran">Penganggaran</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
                $selectSQLPemasok = "SELECT * FROM pemasok";
                $resultSetPemasok = mysqli_query($koneksi, $selectSQLPemasok);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id">Pemasok</label>
                            <select name="pemasok_id" id="" class="form-control">
                                <option value="">-- Pilih --</option>
                                <?php
                                while ($rowPemasok = mysqli_fetch_assoc($resultSetPemasok)) {
                                ?>
                                    <option value="<?= $rowPemasok["id"] ?>"><?= $rowPemasok["nama_pemasok"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id">Karyawan </label>
                            <?php
                            if ($_SESSION["level"] == "admin") {
                                $selectSQLKaryawan = "SELECT * FROM karyawan";
                                $resultSetKaryawan = mysqli_query($koneksi, $selectSQLKaryawan);
                            ?>
                                <select name="karyawan_id" id="" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <?php
                                    while ($rowKaryawan = mysqli_fetch_assoc($resultSetKaryawan)) {
                                    ?>
                                        <option value="<?= $rowKaryawan["id"] ?>"><?= $rowKaryawan["nama_karyawan"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            <?php
                            } else {
                            ?>
                                <input type="hidden" class="form-control" name="karyawan_id" value="<?= $_SESSION["karyawan_id"] ?>">
                                <input type="text" class="form-control" value="<?= $_SESSION["nama_karyawan"] ?>" readonly>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col mb-3">
                        <button class="btn btn-success" type="submit" name="simpan_button">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>