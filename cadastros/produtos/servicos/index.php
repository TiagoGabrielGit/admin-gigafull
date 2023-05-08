<?php
require "../../../includes/menu.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Serviços</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab" aria-controls="service" aria-selected="true">Serviços</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="itens-tab" data-bs-toggle="tab" data-bs-target="#itens" type="button" role="tab" aria-controls="itens" aria-selected="false">Itens de Serviço</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="service" role="tabpanel" aria-labelledby="service-tab">
                                            <?php
                                            require "tab/service.php";
                                            ?>
                                        </div>
                                        <div class="tab-pane fade" id="itens" role="tabpanel" aria-labelledby="itens-tab">
                                            <?php
                                            require "tab/itens.php";
                                            ?>
                                        </div>
                                    </div><!-- End Default Tabs -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnEditarServico").click(function() {
        var dados1 = $("#editarService").serialize();
        $.post("processa/edit.php", dados1, function(retorna1) {
            $("#msgEditar").slideDown('slow').html(retorna1);

            //Limpar os campos
            $('#editarService')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgEditar();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditar() {
        setTimeout(function() {
            $("#msgEditar").slideUp('slow', function() {});
        }, 1700);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("#btnSalvarService").click(function() {
        var dados = $("#formNewService").serialize();

        $.post("processa/add.php", dados, function(retorna) {
            $("#msgCadastro").slideDown('slow').html(retorna);

            //Limpar os campos
            $('#formNewService')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgCadastro();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgCadastro() {
        setTimeout(function() {
            $("#msgCadastro").slideUp('slow', function() {});
        }, 1700);
    };
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("#btnSalvarItem").click(function() {
        var dados2 = $("#formNewItem").serialize();

        $.post("processa/addItem.php", dados2, function(retorna2) {
            $("#msgCadastroItem").slideDown('slow').html(retorna2);

            //Limpar os campos
            $('#formNewItem')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgItem();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgItem() {
        setTimeout(function() {
            $("#msgCadastroItem").slideUp('slow', function() {});
        }, 1700);
    };
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("#btnEditarItem").click(function() {
        var dados3 = $("#editarItem").serialize();
        $.post("processa/ediItem.php", dados3, function(retorna3) {
            $("#msgEditarItem").slideDown('slow').html(retorna3);

            //Limpar os campos
            $('#editarItem')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgEditarItem();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditarItem() {
        setTimeout(function() {
            $("#msgEditarItem").slideUp('slow', function() {});
        }, 1700);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>

<?php
require "../../../includes/footer.php";
?>