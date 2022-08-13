<!--//Инклюд-->
<?php
include_once  SITE_ROOT."/app/controllers/comm.php";
?>

<div class="col-md-12 col-12 comments">
    <h3>Оставить комментарий</h3>
    <form action="<?=BASE_URL."post.php?post_id=".$post_id?>" method="post">
        <div class="mb-3 col-12 col-md-12 err">
            <!--ВЫВОД МАССИВА С ОШИБКОЙ-->
            <?php include SITE_ROOT."/app/helpers/error_info.php";?>

        </div>
        <input name="post_id" value="<?=$post_id?>" type="text" hidden>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Ваш Email</label>
            <input type="email" class="form-control" name="email" id="exampleFormControlInput1"
                   placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Ваш комментарий</label>
            <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
        </div>
        <div class="col-12">
            <button name="add-comment-btn" type="submit" class="btn btn-primary">Отправить комментарий</button>
        </div>
    </form>

    <div class="row comments_view">

        <?php if (count($comments) > 0):?>

        <h3 class="col-12">Комментарии</h3>
        <?php foreach($comments as $comment):?>
            <div class="comments_item col-12">
                <div class="comments_item-info">
                    <i class="fa-solid fa-envelope"></i>
                    <span><?=$comment['email'];?></span>
                    <i class="fa-solid fa-calendar-days"></i>
                    <span><?=$comment['created'];?></span>
                </div>
                <div class="col-12 comments_item-text">
                    <p><?=$comment['comment']?></p>
                </div>
            </div>
        <?php endforeach;?>
        <?php endif ?>
    </div>
</div>
