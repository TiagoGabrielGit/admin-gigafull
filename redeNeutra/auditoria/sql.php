<?php
$serial_duplicado = "SELECT
rop.serial_onu as serialONU
FROM
redeneutra_onu_provisionadas as rop
WHERE
active = 1
GROUP BY
rop.serial_onu
HAVING
count(rop.serial_onu) > 1";

$r_serial_duplicado = mysqli_query($mysqli, $serial_duplicado);

$codigo_duplicado = "SELECT
rop.descricao as descricao
FROM
redeneutra_onu_provisionadas as rop
WHERE
active = 1
GROUP BY
rop.descricao
HAVING
count(rop.descricao) > 1";

$r_codigo_duplicado = mysqli_query($mysqli, $codigo_duplicado);