<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            <hr class="sidebar-divider">

            <div class="row g-3">
                <div class="col-lg-12">
                    <span><b>Últimos 10 Acessos</b></span>
                </div>

                <div class="col-lg-12">
                    <div class="row">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sessão</th>
                                    <th scope="col">IP</th>
                                    <th scope="col">Horário</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($campos_log = $r_log->fetch_array()) { ?>
                                    <tr>
                                        <td><?= $campos_log['id'] ?></td>
                                        <td><?= $campos_log['ip_address'] ?></td>
                                        <td><?= $campos_log['horario'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="sidebar-divider">
            </div>
        </div>
    </div>
</div>