<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Transaksi Pemasok</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=transaksipemasoktambah" class="btn btn-success float-end">
                    <i class="fa fa-plus-circle"></i> Tambah
                </a>
                <a href="report/rekapitulasitransaksipemasok.php" class="btn btn-primary float-end me-1" target="_blank">
                    <i class="fa fa-print"></i> Rekapitulasi
                </a>
            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <script>
        // konfirmasi()
        // pesanToast()
    </script>
    <?php
    $query = "SELECT transaksi_pemasok.*, pemasok.nama_pemasok FROM transaksi_pemasok 
    INNER JOIN pemasok ON transaksi_pemasok.pemasok_id = pemasok.id";

    $resultSet = mysqli_query($koneksi, $query);

    if (!$resultSet) {
        die("Query error: " . mysqli_error($koneksi));
    }
    ?>
</div>
<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <table class="table bg-white rounded shadow-sm  table-hover" id="example">
                <thead>
                    <tr>
                        <th width="20">ID</th>
                        <th>Nama Pemasok</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                        <th>Status Transaksi</th>
                        <th width="150">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($resultSet)) {
                    ?>
                        <tr class="align-middle">
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['nama_pemasok'] ?></td>
                            <td><?= $row['tgl_tran'] ?></td>
                            <td><?= $row['tot_bayar'] ?></td>
                            <td><?= $row['status_transaksi'] ?></td>
                            <td>
                                <a href="?page=transaksipemasokubah&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="?page=transaksipemasokhapus&id=<?= $row['id'] ?>" onclick="javascript: return confirm('Yakin hapus?');" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>