<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Barang Masuk Detail</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=barangmasukdata" class="btn btn-primary float-end">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </a>
                <a href="report/tandaterima.php?id=<?= $_GET['id'] ?>" class="btn btn-success float-end me-1" target="_blank">
                    <i class="fa fa-print"></i> Tanda Terima
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <div class="col">
        <?php
        if (isset($_POST['tambah_button'])) {
            $barang_masuk_id = $_POST['barang_masuk_id'];
            $barang_id = $_POST['barang_id'];
            $jumlah = $_POST['jumlah'];

            $cariSQL = "SELECT * FROM barang_masuk_detail WHERE barang_masuk_id=$barang_masuk_id AND barang_id=$barang_id";
            $resultSetCari = mysqli_query($koneksi, $cariSQL);
            $sudahAda = (mysqli_num_rows($resultSetCari) > 0) ? true : false;

            if ($sudahAda) {
                $rowCari = mysqli_fetch_assoc($resultSetCari);
                $jumlah_lama = $rowCari["jumlah"];
                $id_lama = $rowCari["id"];
                $jumlah_baru = $jumlah + $jumlah_lama;
                $SQL = "UPDATE barang_masuk_detail SET jumlah=$jumlah_baru WHERE id=$id_lama";
            } else {
                $SQL = "INSERT INTO barang_masuk_detail SET barang_masuk_id=$barang_masuk_id,
                barang_id=$barang_id,
                jumlah=$jumlah,
                status_kode='Belum'";
            }

            $result = mysqli_query($koneksi, $SQL);
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
                    Data berhasil ditambah
                </div>
        <?php
            }
        }

        if (isset($_POST['delete_button'])) {
            $barang_masuk_detail_id = $_POST["barang_masuk_detail_id"];
            $deleteSQL = "DELETE FROM barang_masuk_detail WHERE id=$barang_masuk_detail_id";
            $result = mysqli_query($koneksi, $deleteSQL);

            $deleteSQL = "DELETE FROM kode WHERE barang_masuk_detail_id=$barang_masuk_detail_id";
            $result = mysqli_query($koneksi, $deleteSQL);
        }

        if (isset($_POST['kode_button'])) {
            // print_r($_POST);
            $barang_masuk_detail_id = $_POST['barang_masuk_detail_id'];
            $tahun = substr($_POST["tanggal"], 0, 4);
            $bulan = substr($_POST["tanggal"], 5, 2);
            $barang_id = str_pad($_POST['barang_id'], 4, '0', STR_PAD_LEFT);

            $kode_temp = $tahun . "/" . $bulan . "/" . $barang_id . "/";

            $cariSQL = "SELECT * FROM kode WHERE kode like '$kode_temp%' ORDER BY kode DESC LIMIT 1";
            $resultSetCari = mysqli_query($koneksi, $cariSQL);

            $mulai = 1;
            $akhir = $_POST['jumlah'];
            if (mysqli_num_rows($resultSetCari) > 0) {
                $rowCari = mysqli_fetch_assoc($resultSetCari);
                $mulai = (int) substr($rowCari["kode"], 13, 4) + 1;
                $akhir = $mulai + $akhir - 1;
            }

            for ($i = $mulai; $i <= $akhir; $i++) {
                $kode = str_pad($i, 4, '0', STR_PAD_LEFT);
                $kode_new = $kode_temp . $kode;

                $insertSQL = "INSERT INTO kode SET barang_masuk_detail_id=$barang_masuk_detail_id,
                    kode='$kode_new', kondisi_barang = 'Baru'";
                $result = mysqli_query($koneksi, $insertSQL);
            }

            $updateSQL = "UPDATE barang_masuk_detail SET status_kode='Sudah' WHERE id=$barang_masuk_detail_id";
            $result = mysqli_query($koneksi, $updateSQL);
        }

        $id = $_GET['id'];

        $selectSQL = "SELECT BM.*,P.nama_pemasok, K.nama_karyawan FROM barang_masuk BM
        LEFT JOIN pemasok P ON BM.pemasok_id=P.id
        LEFT JOIN karyawan K ON BM.karyawan_id=K.id WHERE BM.id=$id";
        $result = mysqli_query($koneksi, $selectSQL);
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<meta http-equiv='refresh' content='0;url=?page=barangmasukdata'>";
        } else {
            $row = mysqli_fetch_assoc($result);
        }

        $selectSQLDetail = "SELECT BMD.*, B.nama_barang, B.merk, B.tipe, B.satuan 
        FROM barang_masuk_detail BMD 
        LEFT JOIN barang B ON BMD.barang_id = B.id
        WHERE BMD.barang_masuk_id=$id";
        $resultDetail = mysqli_query($koneksi, $selectSQLDetail);

        ?>
    </div>
</div>
<div id="bawah" class="row">
    <div class="col">
        <div class="card px-3 py-3">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="id">Tanggal</label>
                        <input type="text" class="form-control" value="<?= $row['tanggal'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="id">Sumber Dana</label>
                        <input type="text" class="form-control" value="<?= $row['sumber_dana'] ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id">Pemasok</label>
                        <input type="text" class="form-control" value="<?= $row['nama_pemasok'] ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id">Karyawan </label>
                        <input type="text" class="form-control" value="<?= $row['nama_karyawan'] ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="bawah_detail" class="row mt-3">
    <div class="col">
        <div class="card px-3 py-3">
            <form action="" method="post">
                <input type="hidden" id="id" name="barang_masuk_id" value="<?= $id ?>" required>
                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="id">Barang</label>
                            <?php
                            $selectSQL = "SELECT * FROM barang ORDER BY nama_barang";
                            $resultSet = mysqli_query($koneksi, $selectSQL);
                            $default_tahun = 0;
                            ?>
                            <select class="form-select" name="barang_id" required>
                                <option value="">-- Pilih --</option>
                                <?php
                                while ($rowBarang = mysqli_fetch_assoc($resultSet)) {
                                ?>
                                    <option value="<?= $rowBarang['id'] ?>"><?= $rowBarang['nama_barang'] . " | " . $rowBarang["merk"] . " | " . $rowBarang["tipe"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="jumlah">Jumlah</label>
                            <div class="input-group">
                                <input type="number" id="jumlah" name="jumlah" class="form-control" required>
                                <button type="submit" name="tambah_button" class="btn btn-success"><i class="fa fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="tabel" class="row mt-3">
    <div class="col">
        <table class="table bg-white rounded shadow-sm  table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Barang</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($rowDetail = mysqli_fetch_assoc($resultDetail)) {
                ?>
                    <tr class="align-middle">
                        <td><?= $no++ ?></td>
                        <td><?= $rowDetail['nama_barang'] ?></td>
                        <td><?= $rowDetail['merk'] ?></td>
                        <td><?= $rowDetail['tipe'] ?></td>
                        <td><?= $rowDetail['jumlah'] ?></td>
                        <td><?= $rowDetail['satuan'] ?></td>
                        <td>
                            <div class="row">

                                <form action="" method="post">
                                    <?php
                                    if ($rowDetail['status_kode'] == "Belum") {
                                    ?>
                                        <button type="submit" name="kode_button" class="btn btn-sm btn-dark" onclick="javascript: return confirm('Lanjut buat kode?');">
                                            <i class="fa fa-info-circle"></i>
                                        </button>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="?page=barangmasukdetailkode&id=<?= $row['id'] ?>&detail_id=<?= $rowDetail['id'] ?>" class="btn btn-sm btn-success">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                    <input type="hidden" name="barang_masuk_detail_id" value=" <?= $rowDetail['id'] ?>">
                                    <input type="hidden" name="jumlah" value="<?= $rowDetail['jumlah'] ?>">
                                    <input type="hidden" name="barang_id" value="<?= $rowDetail['barang_id'] ?>">
                                    <input type="hidden" name="tanggal" value="<?= $row['tanggal'] ?>">
                                    <button type="submit" name="delete_button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>

                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>