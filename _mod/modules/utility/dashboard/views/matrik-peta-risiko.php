<style>
    table {
        table-layout: fixed;
        width: 100%;
    }

    table,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }


    tr,
    td {
        width: 25px !important;
        height: 40px !important;
    }


    .top-border {
        border-style: solid;
        border-color: white;
        border-width: 10px;
    }

    .remove-border {
        border-style: hidden !important;
    }

    .rotate {
        -moz-transform: scale(-1, -1);
        -webkit-transform: scale(-1, -1);
        -o-transform: scale(-1, -1);
        -ms-transform: scale(-1, -1);
        transform: scale(-1, -1);
    }
</style>
<div class="row">
    <div class="col-md-4 text-center">
        <div class="row">
            <div class="col-md-12">
                <h6>Inherent &nbsp;<span class="badge badge-secondary text-center">
                        <?= ! empty( $jml_inherent ) ? $jml_inherent : 0; ?></span></h6>
                <?= $map_inherent ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="alert alert-secondary">
                    <table>
                        <?php foreach( $legendMatrix as $keyLegend => $vLegend )
                        { ?>
                            <tr>
                                <td><?= $keyLegend ?></td>
                                <td><?= $vLegend ?></td>
                            </tr>
                            <?php
                        } ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4 text-center">
        <div class="row">
            <div class="col-md-12">
                <h6>Current &nbsp;<span
                        class="badge badge-secondary text-center"><?= ! empty( $jml_residual ) ? $jml_residual : 0; ?></span>
                </h6>
                <?= $map_residual ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="alert alert-secondary">
                    <table>
                        <?php foreach( $legendMatrix as $keyLegend => $vLegend )
                        { ?>
                            <tr>
                                <td><?= $keyLegend ?></td>
                                <td><?= $vLegend ?></td>
                            </tr>
                            <?php
                        } ?>
                    </table>
                </div>

            </div>
        </div>

    </div>
    <div class="col-md-4 text-center">
        <div class="row">
            <div class="col-md-12">
                <h6>Residual &nbsp;<span
                        class="badge badge-secondary text-center"><?= ! empty( $jml_target ) ? $jml_target : 0; ?></span>
                </h6>
                <?= $map_target ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="alert alert-secondary">
                    <table>
                        <?php foreach( $legendMatrix as $keyLegend => $vLegend )
                        { ?>
                            <tr>
                                <td><?= $keyLegend ?></td>
                                <td><?= $vLegend ?></td>
                            </tr>
                            <?php
                        } ?>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>