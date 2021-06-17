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
            let name = $('#name').val();

            if (name) {
                $.ajax({
                    url: '../../controllers/GroupController.php',
                    type: 'post',
                    data: {
                        op: 'I',
                        name,
                    },
                    success: function(res) {
                        res = JSON.parse(res);
                        if (res.success) {
                            alert('grupo criado com sucesso!');
                            window.location.href = "./list.php";
                        } else {
                            alert('Erro ao criar grupo, tente novamente mais tarde!');
                        }

                    },
                    fail: function(res) {
                        alert('Um erro inesperado aconteceu.')
                    }
                })
            } else {
                alert('Preencha todos os campos obrigatórios')
            }

        })
    })
</script>