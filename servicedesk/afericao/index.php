<?php
require '../../includes/menu.php';
require '../../conexoes/conexao_pdo.php';

try {
    $equipe_usuario = $pdo->prepare("SELECT * FROM equipes_integrantes WHERE integrante_id = :usuario_id");
    $equipe_usuario->bindParam(':usuario_id', $_SESSION['id']);
    $equipe_usuario->execute();
    $row_equipe = $equipe_usuario->fetch(PDO::FETCH_ASSOC);
    $equipe_id = $row_equipe['equipe_id'];
} catch (PDOException $e) {
    // Lidar com exceções, se houver
    echo "Erro ao executar a consulta: " . $e->getMessage();
}
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <form id="formAbrirChamado" method="POST" action="processa/abrir_afericao.php">

                        <?php
                        $stmt_tipos_chamados = $pdo->prepare("SELECT tc.id, tc.tipo, tc.mascara
                            FROM chamados_autorizados_by_equipe AS cae
                            LEFT JOIN tipos_chamados as tc ON cae.tipo_id = tc.id
                            WHERE cae.equipe_id = :equipe_id AND tc.mobile = 1 AND tc.active = 1 AND tc.afericao = 1 LIMIT 1");

                        $stmt_tipos_chamados->bindParam(':equipe_id', $equipe_id);

                        $stmt_tipos_chamados->execute();

                        $row_tipos_chamados = $stmt_tipos_chamados->fetch(PDO::FETCH_ASSOC);
                        $id_tipo_chamado = $row_tipos_chamados['id'];
                        $tipo_chamado = $row_tipos_chamados['tipo'];
                        $mascara = $row_tipos_chamados['mascara'];

                        ?>
                        <input hidden id="chamado" name="chamado" value="<?= $id_tipo_chamado; ?>" readonly></input>


                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label"><b>Selecione a OLT*</b></label>
                            <div class="col-sm-10">
                                <select name="olt" id="olt" class="form-select" aria-label="Default select example" required>
                                    <option disabled selected value="">Selecione uma opção</option>
                                    <?php
                                    try {
                                        // Consulta SQL
                                        $sql = "SELECT go.id, go.olt_name, go.city
                                        FROM gpon_olts_interessados as goi
                                        LEFT JOIN gpon_olts as go ON goi.gpon_olt_id = go.id
                                        WHERE goi.interessado_empresa_id = :empresa_id AND goi.active = 1 and go.active = 1
                                        ORDER by go.olt_name ASC";

                                        // Preparar a consulta
                                        $stmt = $pdo->prepare($sql);

                                        // Substituir o parâmetro :empresa_id pelo valor da sessão
                                        $empresa_id = $_SESSION['empresa_id'];
                                        $stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);

                                        // Executar a consulta
                                        $stmt->execute();

                                        // Verificar se há resultados
                                        if ($stmt->rowCount() == 0) {
                                            echo '<option disabled value="">Nenhuma OLT encontrada</option>';
                                        } else {
                                            // Loop através dos resultados e exibir opções
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo '<option value="' . $row['id'] . '">' . $row['olt_name'] . ' - ' . $row['city'] . '</option>';
                                            }
                                        }
                                    } catch (PDOException $e) {
                                        // Caso ocorra algum erro na conexão ou na consulta
                                        echo "Erro: " . $e->getMessage();
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label"><b>Selecione a CTO*</b></label>
                            <div class="col-sm-10">
                                <input type="text" id="ctoInput" name="cto" class="form-control" placeholder="Selecione primeiro a OLT" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="relato_chamado" class="col-sm-2 col-form-label">Descreva</label>
                            <div class="col-sm-10">
                                <textarea name="relato" id="relato_chamado" class="form-control" rows="10" required><?= $mascara ?></textarea>
                            </div>
                        </div>

                        <input hidden id="latitude" name="latitude">
                        <input hidden id="longitude" name="longitude">

                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button id="buttonAbrirChamado" type="submit" class="btn btn-sm btn-danger">Abrir
                                    Chamado</button>
                                <div id="buttonAbrirChamadoLoading" style="display: none;">
                                    <div class="spinner-border text-success" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    window.onload = function() {
        getLocation(); // Chama a função getLocation() assim que a página é carregada
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    document.getElementById("latitude").value = latitude;
                    document.getElementById("longitude").value = longitude;
                },
                function(error) {
                    alert("Erro ao obter a localização: " + error.message);
                }
            );
        } else {
            alert("Geolocalização não é suportada pelo seu navegador.");
        }
    }


    $(function() {
        $('#ctoInput').prop('disabled', true).attr('placeholder', 'Selecione primeiro a OLT');

        var availableCTOs = []; // Array para armazenar os nomes das CTOs disponíveis

        // Função para atualizar as opções disponíveis para o campo de entrada de texto 'ctoInput'
        function updateAvailableCTOs() {
            $.ajax({
                url: "busca_ctos_autocomplete.php",
                dataType: "json",
                data: {
                    term: '', // Termo vazio para buscar todas as CTOs disponíveis para a OLT
                    oltID: $("#olt").val()
                },
                success: function(data) {
                    availableCTOs = data.map(function(item) {
                        return item.value;
                    });
                }
            });
        }

        // Quando uma OLT for selecionada, habilitar o campo ctoInput e atualizar as opções disponíveis
        $('#olt').change(function() {
            $('#ctoInput').prop('disabled', false).attr('placeholder', 'Pesquise a CTO');
            $('#ctoInput').val(''); // Limpar o valor do campo quando a OLT é alterada
            updateAvailableCTOs(); // Atualizar as opções disponíveis para a nova OLT selecionada
        });

        // Função para fornecer as opções disponíveis ao widget de autocompletar
        function provideAvailableCTOs(request, response) {
            var term = request.term;
            var matched = $.grep(availableCTOs, function(value) {
                return value.toLowerCase().indexOf(term.toLowerCase()) !== -1; // Procurar correspondências ignorando maiúsculas e minúsculas
            });
            response(matched);
        }

        $("#ctoInput").autocomplete({
            source: provideAvailableCTOs, // Fornecer as opções disponíveis
            minLength: 0, // Permitir mostrar todas as opções disponíveis sem limite de caracteres
            autoFocus: true // Autofocus para abrir a lista de opções assim que o campo estiver focado
        });

        // Validar se o valor digitado pelo usuário está na lista de opções disponíveis ao enviar o formulário
        $('form').submit(function() {
            var ctoInputValue = $('#ctoInput').val();
            if (availableCTOs.indexOf(ctoInputValue) === -1) {
                alert('Por favor, selecione uma CTO válida da lista.');
                return false; // Impedir o envio do formulário se a CTO digitada não estiver na lista de opções
            }
        });

        // Atualizar as opções disponíveis ao carregar a página
        updateAvailableCTOs();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('formAbrirChamado').addEventListener('submit', function(event) {
            // Impedir o envio do formulário
            event.preventDefault();

            // Esconder o botão "Abrir Chamado"
            document.getElementById('buttonAbrirChamado').style.display = 'none';

            // Mostrar o spinner de carregamento
            document.getElementById('buttonAbrirChamadoLoading').style.display = 'block';

            // Enviar o formulário
            this.submit();
        });
    });
</script>


<?php
require '../../includes/footer.php';
?>