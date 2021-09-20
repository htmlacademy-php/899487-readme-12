<div class="popular__posts">
    <?php foreach ($posts as $postIndex => $post): ?>
        <article class="popular__post post">
            <header class="post__header">
                <h2><a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
            </header>
            <div class="post__main">
                <?php if ($post['icon_class'] === 'quote'): ?>
                    <blockquote>
                        <p><?= $post['content'] ?></p>
                        <cite>Неизвестный Автор</cite>
                    </blockquote>
                <?php elseif ($post['icon_class'] === 'text'): ?>
                    <?= trimMessage($post['content']); ?>
                <?php elseif ($post['icon_class'] === 'photo'): ?>
                    <div class="post-photo__image-wrapper">
                        <img src="img/<?= $post['image'] ?>" alt="Фото от пользователя" width="360" height="240">
                    </div>
                <?php elseif ($post['icon_class'] === 'link'): ?>
                    <div class="post-link__wrapper">
                        <a class="post-link__external" href="<?= $post['link'] ?>" title="Перейти по ссылке">
                            <div class="post-link__info-wrapper">
                                <div class="post-link__icon-wrapper">
                                    <img src="" alt="Иконка">
                                </div>
                                <div class="post-link__info">
                                    <h3><?= $post['title'] ?></h3>
                                </div>
                            </div>
                            <span><?= $post['content'] ?></span>
                        </a>
                    </div>
                <?php endif ?>
            </div>
            <footer class="post__footer">
                <div class="post__author">
                    <a class="post__author-link" href="#" title="Автор">
                        <div class="post__avatar-wrapper">
                            <!--укажите путь к файлу аватара-->
                            <img class="post__author-avatar" src="img/<?= $post['avatar'] ?>" alt="Аватар пользователя">
                        </div>
                        <div class="post__info">
                            <b class="post__author-name"><?= $post['login'] ?></b>
                            <?php
                            $postTime = generate_random_date($postIndex);
                            $postTimestamp = strtotime($postTime);
                            ?>
                            <time class="post__time" datetime="<?= $postTime ?>" title="<?= date('d-m-Y H:i', $postTimestamp) ?>"><?= getTimeToShow($postTimestamp) ?></time>
                        </div>
                    </a>
                </div>
                <div class="post__indicators">
                    <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                            <svg class="post__indicator-icon" width="20" height="17">
                                <use xlink:href="#icon-heart"></use>
                            </svg>
                            <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                <use xlink:href="#icon-heart-active"></use>
                            </svg>
                            <span><?= $post['likes_amount'] ?></span>
                            <span class="visually-hidden">количество лайков</span>
                        </a>
                        <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                            <svg class="post__indicator-icon" width="19" height="17">
                                <use xlink:href="#icon-comment"></use>
                            </svg>
                            <span><?= $post['comments_amount'] ?></span>
                            <span class="visually-hidden">количество комментариев</span>
                        </a>
                    </div>
                </div>
            </footer>
        </article>
    <?php endforeach; ?>
</div>
