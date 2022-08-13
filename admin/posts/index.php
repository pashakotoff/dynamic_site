<?php
include_once "../../path.php";
include SITE_ROOT."/app/controllers/posts.php";
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
                <a href="<?php echo BASE_URL."admin/posts/create.php"?>" class="col-2 btn btn-success">Создать</a>
            </div>
            <h2>Управление записями</h2>
            <div class="row table-title">
                <div class="id col-1">ID</div>
                <div class="title col-4">Название</div>
                <div class="author col-3">Автор</div>
                <div class="edit col-4">Управление</div>
            </div>
            <?php foreach($postsAdm as $val):?>
            <div class="row post">
                <div class="id col-1"><?=$val['id'];?></div>
                <div class="title col-4"><?=textShortener($val,'title',$adminPostTitleLength);?></div>
                <div class="author col-3"><?=$val['user_name'];?></div>
                <div class="edit col-1"><a href="edit.php?id=<?=$val['id'];?>">Edit</a></div>
                <div class="del col-1"><a href="index.php?del_id=<?=$val['id'];?>">Delete</a></div>
                <?php if($val['status']):?>
                    <div class="status col-2"><a href="index.php?unpub_id=<?=$val['id']?>">unpublish</a></div>
                <?php else: ?>
                    <div class="status col-2" ><a name="pub" href="index.php?pub_id=<?=$val['id']?>">publish</a></div>
                <?php endif;?>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<!--FOOTER-->
<?php
include("../../app/include/footer.php");
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>

</body>
</html>