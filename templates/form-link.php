<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
    <div class="form__input-section <?= $linkError ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="photo-url" type="text" name="link" placeholder="Введите ссылку">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div style="display: <?= $linkError ? 'block' : 'none' ?>  " class="form__error-text">
            <h3 class="form__error-title">Ошибка добавления ссылки.</h3>
            <p class="form__error-desc">
                <?= $linkError; ?>
            </p>
        </div>
    </div>
</div>
