<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Consulta OLTs
$stmt = $pdo->query("SELECT id, olt_name FROM gpon_olts");
$olts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main id="main" class="main">
    <section class="section">

        <!-- Formulário e mapa já incluídos aqui -->
        <form id="select-form">
            <label for="olt-select">Selecione OLT(s):</label>
            <select id="olt-select" name="olt[]" multiple>
                <!-- Preencher as opções de OLT via PHP -->
                <?php foreach ($olts as $olt) : ?>
                    <option value="<?= $olt['id']; ?>"><?= $olt['olt_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="pon-select">Selecione PON(s):</label>
            <select id="pon-select" name="pon[]" multiple>
                <!-- Opções de PON carregadas dinamicamente via AJAX -->
            </select>

            <label for="cto-select">Selecione CTO(s):</label>
            <select id="cto-select" name="cto[]" multiple>
                <!-- Opções de CTO carregadas dinamicamente via AJAX -->
            </select>

            <button type="button" id="show-map-btn">Mostrar no Mapa</button>
        </form>

        <div id="map" style="height: 500px; width: 100%;"></div>

        <!-- Incluindo a biblioteca de mapas Leaflet -->
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

        <!-- Incluindo o seu arquivo JavaScript -->
        <script src="script.js"></script>
    </section>
</main>
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');

?>