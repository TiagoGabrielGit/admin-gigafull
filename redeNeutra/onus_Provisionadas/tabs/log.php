<?php
$register_log =
    "SELECT
rol.register_log as reg,
date_format(rol.created,'%H:%i:%S %d/%m/%Y') as criado
FROM
redeneutra_onu_log as rol
WHERE
rol.onu_id = $idProvisionamento
ORDER BY
rol.created DESC
";

$r_register_log = mysqli_query($mysqli, $register_log);
?>

<div class="row g-3">
    <div class="col-lg-12">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th  width="20%" scope="col">Horário do registro</th>
                        <th  width="80%" scope="col" style="text-align: left;">Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($c_register_log = $r_register_log->fetch_array()) { ?>
                        <tr>
                            <td  width="20%"><?= $c_register_log['criado'] ?></td>
                            <td  width="80%" style="text-align: left;"><?= $c_register_log['reg'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <hr class="sidebar-divider">
</div>