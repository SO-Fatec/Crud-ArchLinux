<?php include '../../layout/head.php'; ?>
<?php include '../../layout/topo.php'; ?>

<div class="container">

    <div class="d-flex align-items-center justify-content-center">
        <h1 class="text-center">Listagem de groupos</h1>
        <a class="btn btn-outline-primary btn-rounded btn-sm ml-3 add_button" href="https://localhost/trabalho_rossano/pages/group/add.php"><i class="fa fa-plus mt-0"></i></a>
    </div>


    <table class="table table-striped table-bordered table-responsive-md table-sm btn-table">
        <thead>
            <td class="text-center"><b>Nome</b></td>
            <td class="text-center"><b>Ações</b></td>
        </thead>
        <tbody>
            <?php
            include '../../db.php';
            $select = $pdo->query("SELECT * FROM groups;");


            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                    <td>' . $row['name'] . '</td>
                    <td class="text-center">         
                        <a class="btn btn-outline-danger btn-rounded btn-sm add_button" onClick="delete_group(' . $row['idgroups'] . ', \'' . $row['name'] . '\')"><i class="fa fa-trash-alt mt-0"></i></a>
                        <a class="btn btn-outline-info btn-rounded btn-sm add_button" href="./edit.php?id=' . $row['idgroups'] . '"><i class="fa fa-pencil-alt mt-0"></i></a>
                    </td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../../layout/footer.php'; ?>
<script>
    $('document').ready(function() {

    })

    function delete_group(id, name) {
        if (confirm('Deseja excluir esse registro?')) {
            $.ajax({
                url: '../../controllers/GroupController.php',
                data: {
                    op: 'D',
                    id,
                    name
                },
                type: 'post',
                success: function(res) {
                    // console.log(res);
                    res = JSON.parse(res);
                    if (res.success) {
                        alert('Grupo deletado com sucesso!');
                        window.location.reload()
                    } else {
                        alert('Erro ao deletar usuário, tente novamente mais tarde!');
                    }

                },
                fail: function(res) {
                    alert('Um erro inesperado aconteceu.')
                }
            })
        }
    }
</script>