<?php
include_once "../../path.php";
include "../../app/controllers/users.php";
//include "../../app/database/database.php";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <!--    Bootstrap5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- google fonts comfortaa-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!--    Font Awasome - сервис иконок-->
    <script src="https://kit.fontawesome.com/b4b9c9d1d0.js" crossorigin="anonymous"></script>
    <!--    кастумные стили-->
    <link rel="stylesheet" href="../../assets/css/admin.css">

</head>
<body>
<!--header-->
<?php
include("../../app/include/adminheader.php");
?>

<div class="container">
    <div class="row">

        <!--SIDEBAR-->
        <?php include("../../app/include/admin-sidebar.php");
        ?>

        <div class="posts col-9">
            <div class="button row">
                <!--                <a href="create.php" class="col-2 btn btn-success">Add posts</a>-->
                <a href="<?php echo BASE_URL."admin/users/index.php"?>" class="col-2 btn btn
                btn-warning">Редактировать</a>
            </div>

            <h2>Добавление пользователя</h2>
            <div class="row add-post">
                <form action="create.php" method="post">
                    <div class="mb-3 col-12 col-md-12 err">
                        <!--ВЫВОД МАССИВА С ОШИБКОЙ-->
                        <?php include SITE_ROOT."/app/helpers/error_info.php";?>

                    </div>
                    <div class="col">
                        <label for="formGroupExampleInput" class="form-label">Ваш логин</label>
                        <input name="user_name" value="<?=$user_name?>" type="text" class="form-control"
                               id="formGroupExampleInput">
                    </div>
                    <div class="col">
                        <label for="exampleInputEmail1" class="form-label">Ваш Email</label>
                        <input name="email" type="email" value="<?=$email?>" class="form-control" id="exampleInputEmail1"
                               aria-describedby="emailHelp">
                        <div  id="emailHelp" class="form-text">Ваш e-mail не будет использован для рассылок</div>
                    </div>
                    <div class="col">
                        <label for="exampleInputPassword1" class="form-label">Пароль</label>
                        <input name="password1" type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="col">
                        <label for="exampleInputPassword2" class="form-label">Повторите пароль</label>
                        <input name="password2" type="password" class="form-control" id="exampleInputPassword2">
                    </div>
                    <select name='admin' class="form-select" aria-label="Default select example">
                        <option selected value="0">User</option>
                        <option value="1">Admin</option>
                    </select>

                    <div class="col">
                        <button class="btn btn-primary" name="create-user-btn" type="submit">Добавить пользователя</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<?php
include("../../app/include/footer.php");
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>

</body>
</html>