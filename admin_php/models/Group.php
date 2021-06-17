<?php
include '../packages/CommandsFile.php';

class Group
{

    public static function add()
    {

        //save user in DB
        include '../db.php';
        $stmt = $pdo->prepare('INSERT INTO groups ( name ) VALUES( :name )');
        $stmt->execute(array(
            ':name' => $_POST['name'],
        ));

        if ($stmt->rowCount() > 0) {
            //creates the linux command
            $command = 'groupadd ' . $_POST['name'];

            //saves the command in the txt
            CommandsFile::write($command);

            echo json_encode(['success' => true]);
        } else {
            echo print_r($_POST);
            echo json_encode(['success' => false]);
        }
    }

    public static function update($id)
    {
        //save user in DB
        include '../db.php';

        $stmt = $pdo->prepare('UPDATE groups SET name = :name WHERE idgroups = :id');
        $stmt->execute(array(
            ':name' => $_POST['name'],
            ':id' => $id
        ));

        if ($stmt->rowCount() > 0) {
            //creates the linux command
            $command = 'groupmod -n ' . $_POST['name'] . ' ' . $_POST['current_name'];

            //saves the command in the txt
            CommandsFile::write($command);

            echo json_encode(['success' => true]);
        } else {
            echo print_r($_POST);
            echo json_encode(['success' => false]);
        }
    }

    public static function delete($id, $name)
    {
        //removes user from db
        include '../db.php';
        $stmt = $pdo->prepare('DELETE FROM groups WHERE idgroups = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        //creates the linux command
        $command = 'groupdel ' . $name;

        //saves the command in the txt
        CommandsFile::write($command);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
