<?php
include 'path.php';
include SITE_ROOT."/app/database/database.php";
//$postsAll = selectAll('posts');
//$allPosts = selectDataForIndexPage();

$postsForSlider = selectDataForSlider();
$page = isset($_GET['page'])? $_GET['page']:1;
$posts = selectDataForIndexWithLimit($limitOfPostsPerPage, $page);
$numOfActivePosts = countNumOfActivePosts();
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
include("app/include/header.php");
?>

<!--Карусель-->
<div class="container">
    <div class="row">
        <h2 class="slider-title">Топ публикации</h2>
    </div>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-inner">
            <?php foreach ($postsForSlider as $key => $val):?>
            <?php if($key === 0):?>
            <div class="carousel-item active carousel-item-div">
                <?php else:?>
                <div class="carousel-item carousel-item-div">
                    <?php endif;?>
                <img src="<?=BASE_URL."assets/images/posts/".$val['img'];?>" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5><a href="<?=BASE_URL."post.php?post_id=".$val['id']?>"><?php textShortener($val,'title', $titleSliderLength); ?></a></h5>
                </div>
            </div>
            <?php endforeach;?>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<!--БЛОК MAIN-->
<div class="container">
    <div class="content row">

        <!--    MAIN CONTENT-->
        <div class="main-content col-md-9">
            <h2>Последние публикации</h2>
            <!--СПИСОК ПОСТОВ-->
            <?php include SITE_ROOT . "/app/include/post_list.php" ?>
            <!--ПАГИНАЦИЯ-->
            <?php include SITE_ROOT . "/app/include/pagination.php" ?>


        </div>
        <?php include SITE_ROOT."/app/include/sidebar.php"; ?>

    </div>
</div><!--БЛОК MAIN-->

    <!--FOOTER-->
    <?php include("app/include/footer.php"); ?>
    <!--FOOTER END-->


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
