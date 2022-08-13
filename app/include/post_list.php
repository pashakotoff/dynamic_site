<?php foreach ($posts as $val):?>
    <div class="post row">
        <div class="img col-12 col-md-4">
            <img src="<?=BASE_URL."assets/images/posts/".$val['img'];?>" alt="<?=$val['title']?>"
                 class="img-thumbnail">

        </div>
        <div class="post-text col-12 col-md-8">
            <h3>
                <a href="<?=BASE_URL."post.php?post_id=".$val['id']?>"><?php textShortener($val,'title',
                        $titleLength);
                    ?></a>
            </h3>
            <i class="far fa-user"><a href="<?=BASE_URL."author.php?page=1&author=".$val['id_user']?>">
                    <?=$val['user_name'];?></a></i>
            <i class="far fa-calendar"> <?=date('M j, o',strtotime($val['created']));?></i>
            <p class="preview-text">
                <?php
                if(mb_strlen($val['content'], 'UTF-8') >$contentLength) {
                    $postLink = BASE_URL."post.php?post_id=".$val['id'];
                    echo mb_substr($val['content'], 0, $contentLength) ."... "."<a class='read_more' href=".$postLink.">>>></a>";
                } else {
                    echo $val['content'];
                } ;?></p>
        </div>
    </div>
<?php endforeach; ?>

