<?php
require "../../includes/menu.php";
?>

<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_tipo_chamado =
"SELECT
tc.id as id_tipo,
tc.tipo as nome_tipo,
CASE
    WHEN tc.active = 1 THEN 'Ativado'
    WHEN tc.active = 0 THEN 'Inativado'
END as ativo_tipo
FROM
tipos_chamados as tc
WHERE
tc.id = '$id'
";
?>

<?php
require "../../includes/footer.php";
?>