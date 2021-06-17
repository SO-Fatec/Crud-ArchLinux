<?php
include '../models/Group.php';

(isset($_POST['op']) ? $op = $_POST['op'] : $op = '');
(isset($_POST['id']) ? $id = $_POST['id'] : $id = '');

switch ($op) {
    case 'I':
        Group::add();
        break;

    case 'D':
        Group::delete($id, $name);
        break;

    case 'U':
        Group::update($id);
        break;
}
