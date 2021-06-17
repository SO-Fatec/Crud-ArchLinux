<?php include '../../layout/head.php'; ?>
<?php include '../../layout/topo.php'; ?>

<div class="container">
    <h1 class="text-center">Adicionar usuário</h1>
    <form>
        <div class="row">
            <div class="col-12 col-md-6 mt-2">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nome do usuário">
            </div>
            <div class="col-12 col-md-6 mt-2">
                <label for="group">Grupo principal:</label>
                <input type="text" name="group" id="group" class="form-control" placeholder="Grupo principal">
            </div>
            <div class="col-12 col-md-6 mt-2">
                <label for="secondary_groups">Grupos secundários:</label>
                <input type="text" name="secondary_groups" id="secondary_groups" class="form-control" placeholder="Grupos">
            </div>
            <div class="col-12 col-md-6 mt-2">
                <label for="password">Senha:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Senha">
            </div>
            <div class="col-12 col-md-6 mt-2">
                <label for="password_confirm">Confirmar senha:</label>
                <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirmar senha">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <a class="btn btn-danger" href="./list.php">Voltar</a>
                <button class="btn btn-info" id="btn_add" type="button">Adicionar</button>
            </div>
        </div>
    </form>
</div>

<?php include '../../layout/footer.php'; ?>

<script>
    $('document').ready(function() {
        $('#btn_add').on('click', function() {
            let password = $('#password').val();
            let password_confirm = $('#password_confirm').val();
            let name = $('#name').val();
            let group = $('#group').val();
            let secondary_groups = $('#secondary_groups').val();

            if (name && group && password && password_confirm) {
                if (password === password_confirm) {
                    $.ajax({
                        url: '../../controllers/UserController.php',
                        type: 'post',
                        data: {
                            op: 'I',
                            password,
                            name,
                            group,
                            secondary_groups
                        },
                        success: function(res) {
                            res = JSON.parse(res);
                            if (res.success) {
                                alert('Usuário criado com sucesso!');
                                window.location.href = "./list.php";
                            } else {
                                alert('Erro ao criar usuário, tente novamente mais tarde!');
                            }

                        },
                        fail: function(res) {
                            alert('Um erro inesperado aconteceu.')
                        }
                    })
                } else {
                    alert('Senhas não coincidem.')
                }
            } else {
                alert('Preencha todos os campos obrigatórios')
            }
        })
    })
</script>