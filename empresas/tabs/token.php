<div class="card-body">
    <form method="POST" action="processa/token.php" class="row g-3" onsubmit="return confirmarRenovacao()">
        <input type="hidden" name="id_empresa_token" value="<?= $row['id_empresa']; ?>">

        <hr class="sidebar-divider">

        <div class="row">
            <div class="col-4">
                <label for="token" class="form-label">Token</label>
                <input hidden value="<?= $row['token'] ?>" required name="token" type="text" class="form-control" id="token">
                <input disabled value="<?= $row['token'] ?>" type="text" class="form-control">

            </div>
            <div class="col-4">
                <button style="margin-top: 35px;" type="submit" class="btn btn-sm btn-danger">Renovar Token</button>
            </div>
        </div>
    </form>
</div>
<script>
    function confirmarRenovacao() {
        // Exibe um pop-up de confirmação
        return confirm("Você tem certeza que deseja renovar o token? Esta ação substituirá o token atual.");
    }
</script>