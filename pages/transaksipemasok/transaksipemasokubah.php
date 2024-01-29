<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Ubah Data Transaksi Pemasok</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=transaksipemasokdata" class="btn btn-primary float-end">
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
            $id = $_POST['id'];
            $pemasok_id = $_POST['pemasok_id'];
            $tgl_tran = $_POST['tgl_tran'];
            $tot_bayar = $_POST['tot_bayar'];
            $status_transaksi = $_POST['status_transaksi'];

            $updateSQL = "UPDATE transaksi_pemasok SET pemasok_id=$pemasok_id, 
                tgl_trans='$tgl_trans', 
                tot_bayar='$tot_bayar', 
                status_transaksi=$status_transaksi 
                WHERE id=$id";
            $result = mysqli_query($koneksi, $updateSQL);
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
                    Data berhasil diubah
                </div>
        <?php
            }
        }

        $id = $_GET['id'];
        $selectSQL = "SELECT * FROM transaksi_pemasok WHERE id=$id";
        $result = mysqli_query($koneksi, $selectSQL);
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<meta http-equiv='refresh' content='0;url=?page=transaksipemasokdata'>";
        } else {
            $row = mysqli_fetch_assoc($result);
        }
        ?>
    </div>
</div>
<div id="bawah" class="row">
    <div class="col">
        <div class="card px-3 py-3">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" name="id" value="<?= $row['id'] ?>" readonly>
                </div>
                <?php
                $selectSQLPemasok = "SELECT * FROM pemasok";
                $resultSetPemasok = mysqli_query($koneksi, $selectSQLPemasok);
                ?>
                <div class="mb-3">
                    <label for="id">Pemasok</label>
                    <select name="pemasok_id" id="" class="form-control">
                        <option value="">-- Pilih --</option>
                        <?php
                        while ($rowPemasok = mysqli_fetch_assoc($resultSetPemasok)) {
                            $selected = $rowPemasok["id"] == $row["pemasok_id"] ? " selected" : "";
                        ?>
                            <option value="<?= $rowPemasok["id"] ?>" <?= $selected ?>><?= $rowPemasok["nama_pemasok"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_tran">Tanggal Transaksi</label>
                    <input type="date" class="form-control" name="tgl_tran" value="<?= $row['tgl_tran'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tot_bayar">Total Bayar</label>
                    <input type="text" class="form-control" name="tot_bayar" value="<?= $row['tot_bayar'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status_transaksi">Status Transaksi</label>
                    <input type="text" class="form-control" name="status_transaksi" value="<?= $row['status_transaksi'] ?>" required>
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