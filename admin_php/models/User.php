<?php
include '../packages/CommandsFile.php';

class User
{

    public static function add()
    {
        //save user in DB
        include '../db.php';
        $stmt = $pdo->prepare('INSERT INTO users ( name, password, secondary_groups, groups ) VALUES( :name, :password, :secondary_groups, :group )');
        $stmt->execute(array(
            ':name' => $_POST['name'],
            ':password' => $_POST['password'],
            ':secondary_groups' => $_POST['secondary_groups'],
            ':group' => $_POST['group']
        ));

        if ($stmt->rowCount() > 0) {
            $commands = [];
            //creates the linux command
            $command = 'useradd -m ';
            if ($_POST['secondary_groups'] != '') {
                $command .= '-G ' . $_POST['secondary_groups'];
            }
            $command .= ' -g ' . $_POST['group'] . ' ' . $_POST['name'];
            $commands[] = $command;

            $command = 'passwd ' . $_POST['name'];
            $commands[] = $command;

            //saves the command in the txt
            CommandsFile::write($commands);

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

        if ($_POST['password']) {
            $query = 'UPDATE users SET name = :name , password = :password, secondary_groups = :secondary_groups, groups = :group WHERE idusers = :id';
            $arr = [
                ':name' => $_POST['name'],
                ':password' => $_POST['password'],
                ':secondary_groups' => $_POST['secondary_groups'],
                ':group' => $_POST['group'],
                ':id' => $id
            ];
        } else {
            $query = 'UPDATE users SET name = :name, secondary_groups = :secondary_groups, groups = :group WHERE idusers = :id';
            $arr = [
                ':name' => $_POST['name'],
                ':secondary_groups' => $_POST['secondary_groups'],
                ':group' => $_POST['group'],
                ':id' => $id
            ];
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($arr);

        if ($stmt->rowCount() > 0) {
            //creates the linux command
            $command = 'usermod ';
            if ($_POST['secondary_groups'] != '') {
                $command .= '-G ' . $_POST['secondary_groups'];
            }
            $command .= ' -l ' . $_POST['name'] . ' ' . $_POST['current_name'];
            $command .= ' -g ' . $_POST['group'];
            $command .= '; passwd ' . $_POST['name'] . ' ;';
            $command .= $_POST['password'] . ' ;';
            $command .= $_POST['password'];

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
        $stmt = $pdo->prepare('DELETE FROM users WHERE idusers = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        //creates the linux command
        $command = 'userdel ' . $name;

        //saves the command in the txt
        CommandsFile::write($command);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
