<?php
include __DIR__."/../database/database.php";

$usersArr = selectAll('users');
$errMsgs = [];
$errMsg = '';

function userAuth($arr) {
    $_SESSION['id'] = $arr['id'];
    $_SESSION['login'] = $arr['user_name'];
    $_SESSION['admin'] = $arr['admin'];
    if($_SESSION['admin']) {
        header('location: '.BASE_URL.'admin/posts/index.php');
    } else {
        header("location: ". BASE_URL);
    }
}

//РЕГИСТРАЦИЯ
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['reg-button'])) {

    $admin = 0;
    $user_name = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password1 = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);

    //Проверки формы
    if($user_name === '' || $email === '' || $password1 === '') {
        array_push($errMsgs, 'Вы заполнили не все поля!');
    } else {
        if (mb_strlen($user_name, 'utf-8') <= 5) {
            array_push($errMsgs, "Логин должен быть больше 5 символов");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errMsgs, "Введите корректный e-mail");
        }
        if ($password1 !== $password2) {
            array_push($errMsgs, 'Пароли в обоих полях должны соответствовать!');
        }
    }
    //Если проверка проведена успешна - отправляем форму в БД
    if(empty($errMsgs)) {
        if(selectOne('users', ['email'=>"$email"])) {
            $errMsg = "Пользователь с e-mail $email, уже зарегистрирован";
        } else {
            $password1 = password_hash($password1, PASSWORD_DEFAULT);
            $post = [
            'admin' => $admin,
            'user_name' => $user_name,
            'email' => $email,
            'password' => $password1
            ];

            $id = insert('users', $post);
            //$addedRow = selectOne('users', ['id'=> $id]);
            //printData($addedRow);
            $user = selectOne("users", ['id'=>$id]);
            userAuth($user);
        }
    }

} else {
    $user_name = '';
    $email = '';
};



//АВТОРИЗАЦИЯ
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['login-button'])) {
    $email = trim($_POST['email']);
    $password1 = trim($_POST['password1']);

    if($email === '') {
        array_push($errMsgs, "Заполните поле e-mail");
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errMsgs, "Введите корректный e-mail");
    }
    if ($password1 === '') {
        array_push($errMsgs, "Заполните поле пароль");
    }

    if(empty($errMsgs)) {
        $ifExist = selectOne('users', ['email'=>$email]);
        if (!$ifExist || !password_verify($password1, $ifExist['password'])) {
            $errMsg = "Почта или пароль введены не верно";
            $email = '';
        }
        else {
            userAuth($ifExist);
        }
    }
}


if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['create-user-btn'])) {

    $user_name = trim($_POST['user_name']);
    $email = trim($_POST['email']);
    $password1 = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);
    if(array_key_exists('admin', $_POST)){
        $admin = trim($_POST['admin']);
    } else {
        $admin = '0';
    }


    //Проверки формы
    if($user_name === '' || $email === '' || $password1 === '') {
        array_push($errMsgs, 'Вы заполнили не все поля!');
    } else {
        if (mb_strlen($user_name, 'utf-8') <= 2) {
            array_push($errMsgs, "Логин должен быть больше 2 символов");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errMsgs, "Введите корректный e-mail");
        } elseif (selectOne('users', ['email'=>"$email"])) {
                array_push($errMsgs, "Пользователь с e-mail $email, уже зарегистрирован!");
        }
        if ($password1 !== $password2) {
            array_push($errMsgs, 'Пароли в обоих полях должны соответствовать!');
        }
    }

    if(empty($errMsgs)) {
            $password1 = password_hash($password1, PASSWORD_DEFAULT);
            $post = [
                'admin' => $admin,
                'user_name' => $user_name,
                'email' => $email,
                'password' => $password1
            ];

            $id = insert('users', $post);
            //$addedRow = selectOne('users', ['id'=> $id]);
            //printData($addedRow);
            $user = selectOne("users", ['id'=>$id]);
            header("location: ". BASE_URL."admin/users/index.php");
    }
}
//Заполняем поля при нажатии на кнопку редактирования
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = selectOne('users', ['id'=>$id]);
    $user_name = $user['user_name'];
    $email = $user['email'];
    $admin = $user['admin'];
}

//ОБНОВЛЯЕМ ДАННЫЕ ПОЛЬЗОВАТЕЛЯ
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update-user-btn'])) {
    //Вносим переменные
    $id = trim($_POST['id']);
    $user_name = trim($_POST['user_name']);
    $email = trim($_POST['email']);
    $password1 = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);

    if(array_key_exists('admin', $_POST)){
        $admin = trim($_POST['admin']);
    } else {
        $admin = '0';
    }
    //Проверка правильности заполнения формы
    if($user_name === '' || $email === '') {
        array_push($errMsgs, 'Вы заполнили не все поля!');
    } else {
        if (mb_strlen($user_name, 'utf-8') <= 2) {
            array_push($errMsgs, "Логин должен быть больше 2 символов");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errMsgs, "Введите корректный e-mail");
        } elseif (selectOne('users', ['email'=>"$email"]) && $id !== selectOne('users', ['email'=>"$email"])['id']) {
            array_push($errMsgs, "Пользователь с e-mail $email, уже зарегистрирован!");
            $email = selectOne('users', ['id'=>"$id"])['email'];
        }
        if ($password1 !== $password2) {
            array_push($errMsgs, 'Пароли в обоих полях должны соответствовать!');
        }
    }
    if(empty($errMsgs)) {
        if(!empty($password1) && !empty($password2)) {
            $password1 = password_hash($password1, PASSWORD_DEFAULT);
            $user = [
                'admin' => $admin,
                'user_name' => $user_name,
                'email' => $email,
                'password' => $password1
            ];
        } else {
            $user = [
                'admin' => $admin,
                'user_name' => $user_name,
                'email' => $email
            ];
        }

        $id = update('users',$id,$user);
        //$addedRow = selectOne('users', ['id'=> $id]);
        //printData($addedRow);
        $user = selectOne("users", ['id'=>$id]);
        header("location: ". BASE_URL."admin/users/index.php");
    }



}

//УДАЛЕНИЕ
if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    delete('users', $id);
    header("location: " . BASE_URL . "admin/users/index.php");
}