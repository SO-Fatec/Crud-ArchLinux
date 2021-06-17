<?php
include '../models/User.php';

(isset($_POST['op']) ? $op = $_POST['op'] : $op = '');
(isset($_POST['id']) ? $id = $_POST['id'] : $id = '');
(isset($_POST['name']) ? $name = $_POST['name'] : $name = '');

switch ($op) {
    case 'I':
        User::add();
        break;

    case 'D':
        User::delete($id, $name);
        break;

    case 'U':
        User::update($id);
        break;
}
