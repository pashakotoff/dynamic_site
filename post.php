<?php
include_once ('path.php');
include_once SITE_ROOT."/app/controllers/topics.php";

//Выявляем переменные
$post_id = $_GET['post_id'];
$post = selectSinglePostWithAuthorName($post_id);
$title = $post['title'];
$content = $post['content'];
$img = BASE_URL."assets/images/posts/".$post['img'];
$id_user = $post['id_user'];
$author = $post['user_name'];
$postDate = date('M j, o',strtotime($post['created']));
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
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<!--header-->
<?php
include ("app/include/header.php");
?>

<!--БЛОК MAIN-->
<div class="container">
    <div class="content row">

        <!--    MAIN CONTENT-->
        <div class="main-content col-md-9">
            <h2><?=$title?></h2>
            <div class="single_post row">
                <div class="single_img col-12">
                    <img src="<?=$img?>" class="img-thumbnail" alt="">

                </div>
                <div class="single_info">
                    <i class="far fa-user"> <a href="<?=BASE_URL."author.php?author=".$id_user?>"><?=$author?></a></i>
                    <i class="far fa-calendar"> <?=$postDate?></i>
                </div>
                <div class="single_post-text col-12"><?=$content?></div>

                <!--Комментарии-->
                <?php include SITE_ROOT."/app/include/comments.php";?>
            </div>

        </div>
        <?php
        include SITE_ROOT."/app/include/sidebar.php";
        ?>

    </div>
</div><!--БЛОК MAIN-->

<?php
include("app/include/footer.php");
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>

</body>
</html>


<!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"-->
<!--        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"-->
<!--        crossorigin="anonymous"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"-->
<!--        integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK"-->
<!--        crossorigin="anonymous"></script>-->
