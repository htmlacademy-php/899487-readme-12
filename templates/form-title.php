<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="-heading">
        Заголовок
        <span class="form__input-required">*</span>
    </label>
    <div class="form__input-section <?= $titleError ? 'form__input-section--error' : '' ?>">
        <input class="adding-post__input form__input" id="-heading" type="text" name="title" placeholder="Введите заголовок">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div style="display: <?= $titleError ? 'block' : 'none' ?>  " class="form__error-text">
            <h3 class="form__error-title">Ошибка добавления заголовка.</h3>
            <p class="form__error-desc">
                <?= $titleError; ?>
            </p>
        </div>
    </div>
</div>
