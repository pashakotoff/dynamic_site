<?php

include_once "../../path.php";
include ("../../app/controllers/topics.php");

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
        <?php
        include("../../app/include/admin-sidebar.php");
        ?>
        <div class="posts col-9">
            <div class="button row">
                <!--                <a href="create.php" class="col-2 btn btn-success">Add posts</a>-->
                <a href="<?php echo BASE_URL."admin/topics/index.php";?>" class="col-2 btn btn
                btn-warning">Редактировать</a>
            </div>
            <h2>Редактирование категории</h2>
            <div class="row add-post">

                <form action="edit.php" method="post">

                    <div class="mb-3 col-12 col-md-12 err">
                        <!--ВЫВОД МАССИВА С ОШИБКОЙ-->
                        <?php include SITE_ROOT."/app/helpers/error_info.php";?>
                    </div>
                    <input type="hidden" name="id" value="<?=$id;?>">
                    <div class="col">
                        <label for="category-name" class="form-label">Название категории</label>
                        <input placeholder="Введите название категории" id="category-name" value="<?=$name;?>"

                               name="name"
                               type="text"
                               class="form-control"
                               aria-label="Название категории">
                    </div>
                    <div class="col">
                        <label for="category-info" class="form-label">Описание категории</label>
                        <textarea id="category-info" placeholder="Введите описание категории"
                                  name="description" class="form-control" id="content" rows="6"><?=$description;
                                  ?></textarea>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" name="edit-topic-btn" type="submit">Сохранить
                            изменения</button>
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
