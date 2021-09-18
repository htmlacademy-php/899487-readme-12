<main class="page__main page__main--publication">
  <div class="container">
      <?php $post = $post[0] ?>
    <h1 class="page__title page__title--publication">
        <?= $post['title'] ?>
    </h1>
    <section class="post-details">
      <h2 class="visually-hidden">Публикация</h2>
      <div class="post-details__wrapper post-<?= $post['icon_class'] ?>">
        <div class="post-details__main-block post post--details">
          <?= $template = $postTemplate ? $postTemplate : 'Error! No template.'; ?>
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
              <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                <svg class="post__indicator-icon" width="19" height="17">
                  <use xlink:href="#icon-repost"></use>
                </svg>
                <span>--</span>
                <span class="visually-hidden">количество репостов</span>
              </a>
            </div>
            <span class="post__view"><?= $post['views'] ?></span>
          </div>
          <ul class="post__tags">
            -- hashtags --
            <!--                        <li><a href="#">#nature</a></li>-->
            <!--                        <li><a href="#">#globe</a></li>-->
            <!--                        <li><a href="#">#photooftheday</a></li>-->
            <!--                        <li><a href="#">#canon</a></li>-->
            <!--                        <li><a href="#">#landscape</a></li>-->
            <!--                        <li><a href="#">#щикарныйвид</a></li>-->
          </ul>
          <div class="comments">
            <form class="comments__form form" action="#" method="post">
              <div class="comments__my-avatar">
                <img class="comments__picture" src="../img/userpic-medium.jpg" alt="Аватар пользователя">
              </div>
              <div class="form__input-section form__input-section--error">
                <textarea class="comments__textarea form__textarea form__input" placeholder="Ваш комментарий"></textarea>
                <label class="visually-hidden">Ваш комментарий</label>
                <button class="form__error-button button" type="button">!</button>
                <div class="form__error-text">
                  <h3 class="form__error-title">Ошибка валидации</h3>
                  <p class="form__error-desc">Это поле обязательно к заполнению</p>
                </div>
              </div>
              <button class="comments__submit button button--green" type="submit">Отправить</button>
            </form>
            <div class="comments__list-wrapper">
              <ul class="comments__list">
                  <?php foreach ($postComments as $postComment) : ?>
                    <li class="comments__item user">
                      <div class="comments__avatar">
                        <a class="user__avatar-link" href="#">
                          <img class="comments__picture" src="../img/<?= $postComment['avatar'] ?>" alt="Аватар пользователя">
                        </a>
                      </div>
                      <div class="comments__info">
                        <div class="comments__name-wrapper">
                          <a class="comments__user-name" href="#">
                            <span><?= $postComment['login'] ?></span>
                          </a>
                          <time class="comments__time"
                                datetime="<?= $postComment['created_at'] ?>">
                              <?php $commentTimestamp = strtotime($postComment['created_at']); ?>
                              <?= getTimeToShow($commentTimestamp) ?>
                          </time>
                        </div>
                        <p class="comments__text">
                            <?= $postComment['content'] ?>
                        </p>
                      </div>
                    </li>
                  <?php endforeach; ?>
              </ul>
              <a class="comments__more-link" href="#">
                <span>Показать все комментарии</span>
                <sup class="comments__amount"><?= count($postComments) ?></sup>
              </a>
            </div>
          </div>
        </div>
        <div class="post-details__user user">
          <div class="post-details__user-info user__info">
            <div class="post-details__avatar user__avatar">
              <a class="post-details__avatar-link user__avatar-link" href="#">
                <img class="post-details__picture user__picture" src="img/<?= $post['avatar'] ?>" alt="Аватар пользователя">
              </a>
            </div>
            <div class="post-details__name-wrapper user__name-wrapper">
              <a class="post-details__name user__name" href="#">
                <span><?= $postAuthor[0]['login'] ?></span>
              </a>
                <?php
                $userRegistrationDateTimeStamp = strtotime($userRegistrationDate)
                ?>
              <time class="post-details__time user__time"
                    datetime="<?= $userRegistrationDate ?>"
                    title="<?= date('d-m-Y H:i',
                        $userRegistrationDateTimeStamp) ?>"
              >
                  <?= getTimeToShow($userRegistrationDateTimeStamp) ?>
              </time>
            </div>
          </div>
          <div class="post-details__rating user__rating">
            <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
              <span class="post-details__rating-amount user__rating-amount"><?= count($authorSubscribers) ?></span>
              <span class="post-details__rating-text user__rating-text">подписчиков</span>
            </p>
            <p class="post-details__rating-item user__rating-item user__rating-item--publications">
              <span class="post-details__rating-amount user__rating-amount"><?= count ($totalPosts) ?></span>
              <span class="post-details__rating-text user__rating-text">публикаций</span>
            </p>
          </div>
          <div class="post-details__user-buttons user__buttons">
            <button class="user__button user__button--subscription button button--main" type="button">Подписаться</button>
            <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
