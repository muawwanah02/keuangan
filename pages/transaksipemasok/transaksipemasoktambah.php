<div id="atas" class="row mb-3">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Data Transaksi Pemasok</h3>
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
            $pemasok_id = $_POST['pemasok_id'];
            $tgl_tran = $_POST['tgl_tran'];
            $tot_bayar = $_POST['tot_bayar'];
            $status_transaksi = $_POST['status_transaksi'];

            $insertSQL = "INSERT INTO transaksi_pemasok SET pemasok_id=$pemasok_id, tgl_tran='$tgl_tran', 
            tot_bayar='$tot_bayar',  status_transaksi=$status_transaksi";
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
        <div class="card px-3 py-3">
            <form action="" method="post">
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
                        ?>
                            <option value="<?= $rowPemasok["id"] ?>"><?= $rowPemasok["nama_pemasok"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_trans">Tanggal Transaksi</label>
                    <input type="date" class="form-control" name="tgl_trans" required>
                </div>
                <div class="mb-3">
                    <label for="tot_bayar">Total Bayar</label>
                    <input type="text" class="form-control" name="tot_bayar" required>
                </div>
                <div class="mb-3">
                    <label for="status_transaksi">Status Transaksi</label>
                    <input type="text" class="form-control" name="status_transaksi" required>
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