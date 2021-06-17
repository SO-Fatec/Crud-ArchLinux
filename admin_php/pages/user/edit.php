<?php include '../../layout/head.php'; ?>
<?php include '../../layout/topo.php'; ?>
<?php include '../../db.php' ?>

<?php
(isset($_GET['id']) ? $id = $_GET['id'] : $id = '');
if (!$id) {
    echo '
    <script>
        alert("Id inválido!"); window.location.href="./list.php"
    </script>
    ';
}

$select = $pdo->query('SELECT * FROM users WHERE idusers = ' . $_GET['id'] . ';');
$user = $select->fetch(PDO::FETCH_ASSOC);

?>

<div class="container">
    <h1 class="text-center">Editar usuário</h1>
    <form>
        <input type="hidden" id="id" value="<?= $id ?>">
        <input type="hidden" id="current_name" value="<?= $user['name'] ?>">
        <div class="row">
            <div class="col-12 col-md-6 mt-2">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Nome do usuário" value="<?= $user['name'] ?>">
            </div>
            <div class="col-12 col-md-6 mt-2">
                <label for="group">Grupo principal:</label>
                <input type="text" name="group" id="group" class="form-control" placeholder="Grupo principal" value="<?= $user['groups'] ?>">
            </div>
            <div class="col-12 col-md-6 mt-2">
                <label for="secondary_groups">Grupos secundários:</label>
                <input type="text" name="secondary_groups" id="secondary_groups" class="form-control" placeholder="Grupos" value="<?= $user['secondary_groups'] ?>">
            </div>
            <div class="col-12 col-md-6 mt-2">
                <label for="password">Senha:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Deixe em branco para não alterar a senha">
            </div>
            <div class="col-12 col-md-6 mt-2">
                <label for="password_confirm">Confirmar senha:</label>
                <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Deixe em branco para não alterar a senha">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <a class="btn btn-danger" href="./list.php">Voltar</a>
                <button class="btn btn-info" id="btn_save" type="button">Salvar</button>
            </div>
        </div>
    </form>
</div>

<?php include '../../layout/footer.php'; ?>

<script>
    $('document').ready(function() {
        let id = $('#id').val();

        $('#btn_save').on('click', function() {
            let password = $('#password').val();
            let password_confirm = $('#password_confirm').val();
            let name = $('#name').val();
            let current_name = $('#current_name').val();
            let group = $('#group').val();
            let secondary_groups = $('#secondary_groups').val();

            if (name && group) {
                if (password === password_confirm) {
                    $.ajax({
                        url: '../../controllers/UserController.php',
                        type: 'post',
                        data: {
                            op: 'U',
                            id,
                            password,
                            name,
                            group,
                            secondary_groups,
                            current_name
                        },
                        success: function(res) {
                            console.log(res)
                            res = JSON.parse(res);
                            if (res.success) {
                                alert('Usuário alterado com sucesso!');
                                window.location.href = "./list.php";
                            } else {
                                alert('Erro ao alterar usuário, tente novamente mais tarde!');
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