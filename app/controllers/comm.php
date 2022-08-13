<?php
include_once SITE_ROOT."/app/database/database.php";

$commentsForAdm = selectAll('comments');

if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['post_id'])) {
$post_id = $_GET['post_id'];
}

$email = '';
$comment = '';
$errMsgs = [];
$status = 0;
$comments = [];

//ПОЛЬЗОВАТЕЛЬСКАЯ ЧАСТЬ
//ФОРМА ДОБАВЛЕНИЯ КОММЕНТАРИЯ
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add-comment-btn'])) {
    //Корректировка переменных
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);
    $post_id = trim($_POST['post_id']);

    //Поиск ошибок при заполнении формы
    if($email === '' || $comment === '') {
        array_push($errMsgs, 'Вы заполнили не все поля!');
    } else {
        if (mb_strlen($comment, 'utf-8') < 5) {
            array_push($errMsgs, 'Комментарий должен быть длиннее 5 символов');
        }
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errMsgs, "Введите корректный e-mail");
    } else {
        //Если админ - то публикуем комент сразу!
        $user = selectOne('users',['email'=>$email]);
        if(!empty($user) && $user['admin'] == 1) {
            $status = 1;
        }
    }

    //Если нет ошибок - отправляем на сервер
    if(empty($errMsgs)) {
//        $id_user = $_SESSION['id'];
        $comment = [
            'email' => $email,
            'comment' => $comment,
            'post_id' => $post_id,
            'status' => $status
        ];
        $id = insert('comments', $comment);
        $commentFromDb = selectOne('comments', ['id'=>$id]);
        $comments = selectAll('comments', ['post_id'=>$post_id, 'status'=>1]);
    }

} else {
    $email = '';
    $comment = '';
    if(isset($post_id)) {
    $comments = selectAll('comments', ['post_id'=>$post_id, 'status'=>1]);
    }
};





//АДМИНКА
//---------------------
//Заполняем поля при нажатии на кнопку редактирования
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $commentArr = selectOne('comments', ['id'=>$id]);
    //printDataAndDie($commentArr);
    $email = $commentArr['email'];
    $comment = $commentArr['comment'];
    $status = $commentArr['status'];
}

//РЕДАКТИРОВАНИЕ КОММЕНАРИЯ
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['edit-comment-btn'])) {
    //Заполнение переменных
    $id = trim($_POST['id']);
    $comment = trim($_POST['comment']);
    if(trim(@ $_POST['status'] === 'on')) {
        $status = 1;
    } else {
        $status = 0;
    }
    //Поиск ошибок при редактировании формы
    if($comment === '') {
        array_push($errMsgs, 'Комментарий не должен быть пустым');
    }
    if (mb_strlen($comment, 'utf-8') < 12) {
        array_push($errMsgs, 'Комментарий должен быть длиннее 5 символов');
    }

    //Если проверка проведена успешна - отправляем форму в БД
    if(empty($errMsgs)) {
        $comment = [
            'comment' => $comment,
            'status' => $status
        ];
        $id = update('comments', $id, $comment);
        $commentFromDb = selectOne('comments', ['id'=>$id]);
        header("location: " . BASE_URL . "admin/comments/index.php");
    }

}


//Кнопка удалить
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    delete('comments', $id);
    header("location: " . BASE_URL . "admin/comments/index.php");
}

//Кнопка отменить публикацию
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['unpub_id'])) {
    $id = $_GET['unpub_id'];
    update('comments', $id, ['status'=> 0]);
    header("location: " . BASE_URL . "admin/comments/index.php");
}

//Кнопка опубликовать
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['pub_id'])) {
    $id = $_GET['pub_id'];
    update('comments', $id, ['status'=> 1]);
    header("location: " . BASE_URL . "admin/comments/index.php");
}

?>


