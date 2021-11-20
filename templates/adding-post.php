<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?php foreach ($contentTypes as $contentType): ?>
                            <li class="adding-post__tabs-item filters__item">
                                <?php if ($contentType['icon_class'] === 'photo'): ?>
                                <a class="adding-post__tabs-link filters__button filters__button--photo filters__button--active tabs__item tabs__item--active button">
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#icon-filter-text"></use>
                                    </svg>
                                <?php else: ?>
                                <a class="adding-post__tabs-link filters__button filters__button--<?= $contentType['icon_class'] ?> tabs__item">
                                    <svg class="filters__icon" width="22" height="18">
                                        <use xlink:href="#icon-filter-<?= $contentType['icon_class'] ?>"></use>
                                    </svg>
                                <?php endif; ?>
                                    <span><?= $contentType['name'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="adding-post__tab-content">
                    <?php foreach ($contentTypes as $contentType): ?>
                        <section class="adding-post__<?= $contentType['icon_class'] ?> tabs__content
                            <?php if ($contentType['icon_class'] === 'photo') : ?>
                                <?= 'tabs__content--active' ?>
                            <? endif; ?>
                        ">
                        <h2 class="visually-hidden">Форма добавления <?= $contentType['name'] ?></h2>
                        <form class="adding-post__form form" action="add.php" method="post" enctype="multipart/form-data">
                            <?php if ($contentType['icon_class'] === 'photo'): ?>
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $formTitle ?>
                                    <?= $formLink ?>
                                    <?= $formTags ?>
                                </div>
                                <?= $formError ?>
                            </div>
                            <div class="adding-post__input-file-container form__input-container form__input-container--file">
                                <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                                    <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                                        <input class="adding-post__input-file form__input-file" id="userpic-file-photo" type="file" name="userpic-file-photo" title=" ">
                                        <div class="form__file-zone-text">
                                            <span>Перетащите фото сюда</span>
                                        </div>
                                    </div>
                                    <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                                        <span>Выбрать фото</span>
                                        <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                                            <use xlink:href="#icon-attach"></use>
                                        </svg>
                                    </button>
                                </div>
                                <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

                                </div>
                            </div>
                            <?= $submitButton ?>

                            <?php elseif ($contentType['icon_class'] === 'video'): ?>
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $formTitle ?>
                                    <?= $formLink ?>
                                    <?= $formTags ?>
                                </div>
                                <?= $formError ?>
                            </div>
                            <?= $submitButton ?>

                            <?php elseif ($contentType['icon_class'] === 'text'): ?>
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $formTitle ?>
                                    <div class="adding-post__textarea-wrapper form__textarea-wrapper">
                                        <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= $contentError ? 'form__input-section--error' : '' ?>">
                                            <textarea class="adding-post__textarea form__textarea form__input" id="content" name="content" placeholder="Введите текст публикации"></textarea>
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div style="display: <?= $contentError ? 'block' : 'none' ?>  " class="form__error-text">
                                                <h3 class="form__error-title">Ошибка добавления текста.</h3>
                                                <p class="form__error-desc">
                                                    <?= $contentError ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $formTags ?>
                                </div>
                                <?= $formError ?>
                            </div>
                            <?= $submitButton ?>
                            <?php elseif ($contentType['icon_class'] === 'quote'): ?>
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__textarea-wrapper">
                                        <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= $quoteError ? 'form__input-section--error' : '' ?>">
                                            <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="content" name="cite-text" placeholder="Текст цитаты"></textarea>
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div style="display: <?= $quoteError ? 'block' : 'none' ?>  " class="form__error-text">
                                                <h3 class="form__error-title">Ошибка добавления цитаты.</h3>
                                                <p class="form__error-desc">
                                                    <?= $quoteError ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="adding-post__textarea-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= $quoteAuthorError ? 'form__input-section--error' : '' ?>">
                                            <input class="adding-post__input form__input" id="quote-author" type="text" name="quote_author">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div style="display: <?= $quoteAuthorError ? 'block' : 'none' ?>  " class="form__error-text">
                                                <h3 class="form__error-title">Ошибка добавления автора.</h3>
                                                <p class="form__error-desc">
                                                    <?= $quoteAuthorError ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= $formTags ?>
                                </div>
                                <?= $formError ?>
                            </div>
                            <?= $submitButton ?>

                            <?php elseif ($contentType['icon_class'] === 'link'): ?>
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <?= $formTitle ?>
                                    <?= $formLink ?>
                                    <?= $formTags ?>
                                    </div>
                                <?= $formError ?>
                            </div>
                            <?= $submitButton ?>

                            <? endif; ?>
                        </form>
                    </section>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal modal--adding">
    <div class="modal__wrapper">
        <button class="modal__close-button button" type="button">
            <svg class="modal__close-icon" width="18" height="18">
                <use xlink:href="#icon-close"></use>
            </svg>
            <span class="visually-hidden">Закрыть модальное окно</span></button>
        <div class="modal__content">
            <h1 class="modal__title">Пост добавлен</h1>
            <p class="modal__desc">
                Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сефтью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий.
            </p>
            <div class="modal__buttons">
                <a class="modal__button button button--main" href="#">Синяя кнопка</a>
                <a class="modal__button button button--gray" href="#">Серая кнопка</a>
            </div>
        </div>
    </div>
</div>
