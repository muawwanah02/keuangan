<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Barang</h3>
            </div>
            <div class="col-md-6">
                <a href="?page=barangtambah" class="btn btn-success float-end">
                    <i class="fa fa-plus-circle"></i> Tambah
                </a>
                <a href="report/rekapitulasibarang.php" class="btn btn-primary float-end me-1" target="_blank">
                    <i class="fa fa-print"></i> Rekapitulasi Barang
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
    $resultSet = mysqli_query($koneksi, "SELECT * FROM barang");
    ?>
</div>
<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">
            <table class="table bg-white rounded shadow-sm  table-hover" id="example">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th>Nama Barang</th>
                        <th>Merk</th>
                        <th>Tipe</th>
                        <th>Satuan</th>
                        <th width="200">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($resultSet)) {
                    ?>
                        <tr class="align-middle">
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['merk'] ?></td>
                            <td><?= $row['tipe'] ?></td>
                            <td><?= $row['satuan'] ?></td>
                            <td>
                                <a href="?page=barangubah&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#" onclick="konfirmasi('?page=baranghapus&id=<?= $row['id'] ?>');" class="btn btn-sm btn-danger">
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