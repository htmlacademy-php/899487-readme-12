<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-tags">Теги</label>
    <div class="form__input-section <?= $tagsError ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="photo-tags" type="text" name="tags" placeholder="Введите теги">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div style="display: <?= $tagsError ? 'block' : 'none' ?>  " class="form__error-text">
            <h3 class="form__error-title">Ошибка добавления хэш-тегов.</h3>
            <p class="form__error-desc">
                <?= $tagsError; ?>
            </p>
        </div>
    </div>
</div>
