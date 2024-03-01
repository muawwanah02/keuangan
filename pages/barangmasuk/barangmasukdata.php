<div id="atas" class="row">
    <div class="col">
        <div class="row">
            <div class="col-md-6">
                <h3>Barang Masuk</h3>
            </div>
            <div class="col-md-6">
                <div class="col">
                    <form action="" method="post">
                        <div class="input-group">
                            <?php
                            $level = $_SESSION["level"];
                            $karyawan_id = $_SESSION["karyawan_id"];
                            $selectSQL = "SELECT YEAR(tanggal) tahun FROM barang_masuk GROUP BY tahun ORDER BY tahun DESC";
                            $resultSet = mysqli_query($koneksi, $selectSQL);
                            $default_tahun = 0;
                            ?>
                            <select class="form-select" name="tahun">
                                <?php
                                while ($row = mysqli_fetch_assoc($resultSet)) {
                                    $default_tahun = $default_tahun == 0 ? $row["tahun"] : $default_tahun;
                                    $selected = $_POST['tahun'] == $row["tahun"] ? " selected" : "";
                                ?>
                                    <option value="<?= $row['tahun'] ?>" <?= $selected ?>><?= $row['tahun'] ?></option>
                                <?php
                                }
                                $selected_tahun = !isset($_POST['tahun']) ? $default_tahun : $_POST['tahun'];
                                ?>
                            </select>
                            <button type="submit" class="btn btn-primary" type="button">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                            <a href="?page=barangmasuktambah" class="btn btn-success float-end">
                                <i class="fa fa-plus-circle"></i> Tambah
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="tengah">
    <?php
    if ($level == "admin") {
        $selectSQL = "SELECT BM.*,P.nama_pemasok, K.nama_karyawan FROM barang_masuk BM
        LEFT JOIN pemasok P ON BM.pemasok_id=P.id
        LEFT JOIN karyawan K ON BM.karyawan_id=K.id WHERE YEAR(tanggal)=$selected_tahun ORDER BY tanggal DESC";
    } else {
        $selectSQL = "SELECT BM.*,P.nama_pemasok, K.nama_karyawan FROM barang_masuk BM
        LEFT JOIN pemasok P ON BM.pemasok_id=P.id
        LEFT JOIN karyawan K ON BM.karyawan_id=K.id WHERE YEAR(tanggal)=$selected_tahun AND BM.karyawan_id = $karyawan_id ORDER BY tanggal DESC";
    }

    $resultSet = mysqli_query($koneksi, $selectSQL);
    ?>
</div>
<div id="bawah" class="row mt-3">
    <div class="col">
        <div class="card my-card">

            <table class="table bg-white rounded shadow-sm  table-hover" id="example">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Tanggal</th>
                        <th>Sumber Dana</th>
                        <th>Pemasok</th>
                        <th>Karyawan</th>
                        <th width="300">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($resultSet)) {
                    ?>
                        <tr class="align-middle">
                            <td><?= $no++ ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['sumber_dana'] ?></td>
                            <td><?= $row['nama_pemasok'] ?></td>
                            <td><?= $row['nama_karyawan'] ?></td>
                            <td>
                                <a href="?page=barangmasukdetail&id=<?= $row['id'] ?>" class="btn btn-sm btn-dark">
                                    <i class="fa fa-info-circle"></i> Detail
                                </a>
                                <a href="?page=barangmasukubah&id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#" onclick="konfirmasi('?page=barangmasukhapus&id=<?= $row['id'] ?>');" class="btn btn-sm btn-danger">
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

<div class="row">

</div>