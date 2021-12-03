<?php
session_start();
if (
    $_SESSION['user']['user_type'] === 'admin' and
    !empty($_SESSION['user']['user_type'] and !empty($_SESSION['user']))
) {
    if (isset($_GET['id'])) {
        require_once '../connect.php';
        $req = $conn->query('SELECT * FROM comments WHERE id=' . $_GET['id']);
        $userId = $req->fetch();
        if ($userId) {
            $req = $conn->query('DELETE FROM comments WHERE id=' . $_GET['id']);
            header(
                'Location: ../admin_function/modify_comment.php?id=' .
                    $_SESSION['user']['id']
            );
        } else {
            header('Location: ../profil.php');
        }
    }
} else {
    header('Location: ../profil.php');
}

?>