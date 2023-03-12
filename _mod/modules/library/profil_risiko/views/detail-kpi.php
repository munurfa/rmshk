<?php
function kepatuhan2($nilai)
{
    if ($nilai <= 0) {
        $hasil = "0";
    } elseif ($nilai < 75) {
        $hasil = "75";
    } elseif ($nilai >= 75 && $nilai < 100) {
        $hasil = "90";
    } elseif ($nilai == 100) {
        $hasil = "100";
    } elseif ($nilai > 100) {
        $hasil = "110";
    }

    return $hasil;
}
if (!$mode) : ?>
    <a class="btn btn-primary" href="<?= base_url(_MODULE_NAME_ . '/cetak-kri/' . $id); ?>" target="_blank">
        <i class="icon-file-excel"> Ms-Excel </i></a>
<?php endif; ?>
<center>
    PELAPORAN KEY RISK INDICATOR<br />
    DEPARTEMEN <strong><?= strtoupper($owner_name); ?></strong>
</center>
<br />&nbsp;
Sasaran Departemen :
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" border="1">
        <thead>
            <tr>
                <th width="5%" rowspan="2">No.</th>
                <th rowspan="2">Parameter</th>
                <th rowspan="2" width="8%">Satuan</th>
                <th rowspan="2" width="8%">Target</th>

                <?php
                for ($x = $bulan[0]; $x <= $bulan[1]; ++$x) :
                    $monthNum = $x;
                    $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
                ?>
                    <th colspan="4" width="15%"><?= $monthName; ?></th>
                <?php endfor; ?>
            </tr>
            <tr>
                <?php
                for ($x = $bulan[0]; $x <= $bulan[1]; ++$x) : ?>
                    <th>Std</th>
                    <th>Act</th>
                    <th>Sta</th>
                    <th>Nilai</th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            $cek = [];
            // $cekminggu = array_column($data, 'minggu_id_rcsa');
            // dumps($cekminggu);
            // dumps(count(array_unique($cekminggu)));
            foreach ($data as $key => $row) : ?>
                <?php
                // $kondisi = false;
                // if ($row['minggu_id_rcsa'] > 0 && $row['rcsa_id'] == $id) {
                //     $kondisi = ($row['rcsa_id'] == $id);
                //     $t = "ada";
                // }elseif($row['minggu_id_rcsa'] == 0){
                //     $kondisi =  (!in_array(trim($row['title']), $cek));
                //     $t = "gada";

                // }

                ?>
                <!--  && -->
                <?php if (!in_array(trim($row['title']), $cek)) : ?>
                    <tr>
                        <td><?= ++$no; ?></td>
                        <td><?= $row['title']; ?></td>
                        <td><?= $row['satuan']; ?></td>
                        <td><?= $ttl; ?></td>
                        <?php
                        for ($x = $bulan[0]; $x <= $bulan[1]; ++$x) :
                            $warna = 'bg-default';
                            // if ($row['indikator']==1){
                            //     $warna='bg-success-400';
                            // }elseif ($row['indikator']==2){
                            //     $warna='bg-orange-400';
                            // }elseif ($row['indikator']==3){
                            //     $warna='bg-danger-400';
                            // }


                            $int = intval($row['indikator']);
                            if ($int < 1 || $int > 5) {
                                $int = 1;
                            }

                            if (array_key_exists($x, $row['bulan'])) : ?>

                                <?php

                                if ($row['bulan'][$x]['score'] >= $row['bulan'][$x]['s_1_min'] && $row['bulan'][$x]['score'] <= $row['bulan'][$x]['s_1_max']) {
                                    $warna = 'bg-success-400';
                                    $bg = "background-color: #2c5b29;";
                                    $int = 1;
                                } elseif ($row['bulan'][$x]['score'] >= $row['bulan'][$x]['s_4_min'] && $row['bulan'][$x]['score'] <= $row['bulan'][$x]['s_4_max']) {
                                    $warna = 'bg-orange-400';
                                    $bg = "background-color: #50ca4e;";

                                    $int = 2;
                                } elseif ($row['bulan'][$x]['score'] >= $row['bulan'][$x]['s_2_min'] && $row['bulan'][$x]['score'] <= $row['bulan'][$x]['s_2_max']) {
                                    $warna = 'bg-danger-400';
                                    $bg = "background-color: #edfd17;";

                                    $int = 3;
                                } elseif ($row['bulan'][$x]['score'] >= $row['bulan'][$x]['s_5_min'] && $row['bulan'][$x]['score'] <= $row['bulan'][$x]['s_5_max']) {
                                    $warna = 'bg-danger-400';
                                    $bg = "background-color: #f0ca0f;";

                                    $int = 4;
                                } elseif ($row['bulan'][$x]['score'] >= $row['bulan'][$x]['s_3_min'] && $row['bulan'][$x]['score'] <= $row['bulan'][$x]['s_3_max']) {
                                    $warna = 'bg-danger-400';
                                    $bg = "background-color: #e70808;";

                                    $int = 5;
                                }
                                ?>
                                <td><?= $row['bulan'][$x]['p_1'] . ' ' . $row['bulan'][$x]['s_1_min'] . '-' . $row['bulan'][$x]['s_1_max']; ?></td>
                                <td><?= $row['bulan'][$x]['score']; ?></td>
                                <td class="<?= $warna; ?>" style="<?= $bg ?>"></td>
                                <?php
                                $nilai = 0;
                                if ($ttl > 0) {
                                    $nilai = (floatval($row['bulan'][$x]['score']) / $ttl) * 100;
                                }
                                ?>
                                <td><?= kepatuhan2($nilai) . "%" ?></td>

                            <?php else : ?>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        <?php endif;
                        endfor; ?>
                    </tr>
                    <?php
                    // dumps($row['detail']);

                    $nod = -1;
                    $alphabet = range('A', 'Z');
                    foreach ($row['detail'] as $row_det) :
                        // dumps($row_det);
                        $huruf = $alphabet[++$nod]; // returns D
                    ?>
                        <tr>
                            <td></td>
                            <td><?= $huruf . '. ' . $row_det['title']; ?></td>
                            <td><?= $row_det['satuan']; ?></td>
                            <td><?= $ttl; ?></td>
                            <?php
                            for ($x = $bulan[0]; $x <= $bulan[1]; ++$x) :
                                $warna = 'bg-default';
                                // if ($row_det['indikator']==1){
                                //     $warna='bg-success-400';
                                // }elseif ($row_det['indikator']==2){
                                //     $warna='bg-orange-400';
                                // }elseif ($row_det['indikator']==3){
                                //     $warna='bg-danger-400';
                                // }


                                $int = intval($row_det['indikator']);
                                if ($int < 1 || $int > 5) {
                                    $int = 1;
                                }
                                // dumps($row_det);
                                if (array_key_exists($x, $row_det['bulan'])) : ?>

                                    <?php
                                    if ($row_det['bulan'][$x]['score'] >= $row_det['bulan'][$x]['s_1_min'] && $row_det['bulan'][$x]['score'] <= $row_det['bulan'][$x]['s_1_max']) {
                                        $warna = 'bg-success-400';
                                        $bg = "background-color: #2c5b29";
                                        $int = 1;
                                    } elseif ($row_det['bulan'][$x]['score'] >= $row_det['bulan'][$x]['s_4_min'] && $row_det['bulan'][$x]['score'] <= $row_det['bulan'][$x]['s_4_max']) {
                                        $warna = 'bg-orange-400';
                                        $bg = "background-color: #50ca4e";

                                        $int = 2;
                                    } elseif ($row_det['bulan'][$x]['score'] >= $row_det['bulan'][$x]['s_2_min'] && $row_det['bulan'][$x]['score'] <= $row_det['bulan'][$x]['s_2_max']) {
                                        $warna = 'bg-danger-400';
                                        $bg = "background-color: #edfd17";

                                        $int = 3;
                                    } elseif ($row_det['bulan'][$x]['score'] >= $row_det['bulan'][$x]['s_5_min'] && $row_det['bulan'][$x]['score'] <= $row_det['bulan'][$x]['s_5_max']) {
                                        $warna = 'bg-danger-400';
                                        $bg = "background-color: #f0ca0f";

                                        $int = 4;
                                    } elseif ($row_det['bulan'][$x]['score'] >= $row_det['bulan'][$x]['s_3_min'] && $row_det['bulan'][$x]['score'] <= $row_det['bulan'][$x]['s_3_max']) {
                                        $warna = 'bg-danger-400';
                                        $bg = "background-color: #e70808";

                                        $int = 5;
                                    }
                                    ?>
                                    <td><?= $row_det['bulan'][$x]['p_1'] . ' ' . $row_det['bulan'][$x]['s_1_min'] . '-' . $row_det['bulan'][$x]['s_1_max']; ?></td>
                                    <td><?= $row_det['bulan'][$x]['score']; ?></td>
                                    <td class="<?= $warna; ?>" style="<?= $bg ?>"></td>
                                    <?php
                                    $nilaix = 0;
                                    if ($ttl > 0) {
                                        $nilaix = (floatval($row_det['bulan'][$x]['score']) / $ttl) * 100;
                                    }
                                    ?>
                                    <td><?= kepatuhan2($nilaix) . "%" ?></td>

                                <?php else : ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                            <?php endif;
                            endfor; ?>
                        </tr>
            <?php endforeach;


                    $cek[] =  trim($row['title']);
                endif;
            endforeach; ?>
        </tbody>
    </table>
</div>