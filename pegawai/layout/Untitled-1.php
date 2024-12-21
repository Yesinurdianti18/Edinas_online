<table id="myTable" class="display">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Total Jam</th>
            <th>Total Terlambat</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php if (mysqli_num_rows($result) === 0) { ?>
        <tr>
            <td colspan="6">Data Presensi Masih kosong.</td>
        </tr>
    <?php } else { ?>
        <?php $no = 1;
                while ($rekap = mysqli_fetch_array($result)) :
                    // hitung total jam kerja
                    $jam_tanggal_masuk = date('Y-m-d H:i:s', strtotime($rekap['tanggal_masuk'] . '' . $rekap['jam_masuk']));
                    $jam_tanggal_keluar = date('Y-m-d H:i:s', strtotime($rekap['tanggal_keluar'] . '' . $rekap['jam_keluar']));
                    $timestamp_masuk = strtotime($jam_tanggal_masuk);
                    $timestamp_keluar = strtotime($jam_tanggal_keluar);
                    $selisih = $timestamp_keluar - $timestamp_masuk;
                    $total_jam_kerja = floor($selisih / 3600);
                    $selisih -= $total_jam_kerja * 3600;
                    $selisih_menit_kerja = floor($selisih / 60)
                    // hitung total jam terlambat
                    $jam_masuk = date('H:i:s', strtotime($rekap['jam_masuk']));
                    $timestamp_jam_masuk_real = strtotime($jam_masuk);
                    $timestamp_jam_masuk_kantor = strtotime($jam_masuk_kantor);
                    $terlambat = $timestamp_jam_masuk_real - $timestamp_jam_masuk_kantor;
                    $total_jam_terlambat = floor($terlambat / 3600);
                    $terlambat -= $total_jam_terlambat * 3600;
                    $selisih_menit_terlambat = floor($terlambat / 60);

        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?></td>
                <td class="text-center"><?= $rekap['jam_masuk'] ?></td>
                <td class="text-center"><?= $rekap['jam_keluar'] ?></td>
                <td class="text-center">
                    <?php if ($rekap['tanggal_keluar'] == '0000-00-00') : ?>
                        <span class="">0 Jam 0 Menit</span>
                    <?php else : ?>
                        <?= $total_jam_kerja . ' Jam ' . $selisih_menit_kerja . ' Menit' ?>
                </td>
            <?php endif; ?>
            <td class="text-center">
                <?php if ($total_jam_terlambat < 0): ?>
                    <span class="badge bg-success">ON TIME</span>
                <?php else : ?>
                    <?= $total_jam_terlambat . ' Jam ' . $selisih_menit_terlambat . ' Menit' ?>
            </td>
        <?php endif; ?>

            </tr>
        <?php endwhile; ?>
    <?php } ?>
    </tr>
    </tbody>
</table>

<table class="table table-bordered">
    <tr class="text-center">
        <th>No.</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
        <th>Total Jam</th>
        <th>Total Terlambat</th>
    </tr>
    <?php if (mysqli_num_rows($result) === 0) { ?>
        <tr>
            <td colspan="6">Data Presensi Masih kosong.</td>
        </tr>
    <?php } else { ?>
        <?php $no = 1;
        while ($rekap = mysqli_fetch_array($result)) :
            // hitung total jam kerja
            $jam_tanggal_masuk = date('Y-m-d H:i:s', strtotime($rekap['tanggal_masuk'] . '' . $rekap['jam_masuk']));
            $jam_tanggal_keluar = date('Y-m-d H:i:s', strtotime($rekap['tanggal_keluar'] . '' . $rekap['jam_keluar']));
            $timestamp_masuk = strtotime($jam_tanggal_masuk);
            $timestamp_keluar = strtotime($jam_tanggal_keluar);
            $selisih = $timestamp_keluar - $timestamp_masuk;
            $total_jam_kerja = floor($selisih / 3600);
            $selisih -= $total_jam_kerja * 3600;
            $selisih_menit_kerja = floor($selisih / 60);

            // hitung total jam terlambat
            $jam_masuk = date('H:i:s', strtotime($rekap['jam_masuk']));
            $timestamp_jam_masuk_real = strtotime($jam_masuk);
            $timestamp_jam_masuk_kantor = strtotime($jam_masuk_kantor);
            $terlambat = $timestamp_jam_masuk_real - $timestamp_jam_masuk_kantor;
            $total_jam_terlambat = floor($terlambat / 3600);
            $terlambat -= $total_jam_terlambat * 3600;
            $selisih_menit_terlambat = floor($terlambat / 60);

        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?></td>
                <td class="text-center"><?= $rekap['jam_masuk'] ?></td>
                <td class="text-center"><?= $rekap['jam_keluar'] ?></td>
                <td class="text-center">
                    <?php if ($rekap['tanggal_keluar'] == '0000-00-00') : ?>
                        <span class="">0 Jam 0 Menit</span>
                    <?php else : ?>
                        <?= $total_jam_kerja . ' Jam ' . $selisih_menit_kerja . ' Menit' ?>
                </td>
            <?php endif; ?>
            <td class="text-center">
                <?php if ($total_jam_terlambat < 0): ?>
                    <span class="badge bg-success">ON TIME</span>
                <?php else : ?>
                    <?= $total_jam_terlambat . ' Jam ' . $selisih_menit_terlambat . ' Menit' ?>
            </td>
        <?php endif; ?>

            </tr>
        <?php endwhile; ?>
    <?php } ?>
</table>