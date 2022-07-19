<?php if ($card->desc): ?>
    <div class="card-desc-details wn-icon-align-left">
        <?= Lang::get('webvpf.todoboard::lang.card.description') ?>

        <button id="btn_edit_desc"
            class="wn-icon-pencil"
            data-card-id="<?= $card->id ?>"
            data-toggle="tooltip"
            data-placement="left"
            title="<?= Lang::get('webvpf.todoboard::lang.card.edit_desc') ?>"

            data-stripe-load-indicator
            data-request="onLoadFormCardDesc"
            data-request-data="id: <?= $card->id ?>"
            data-request-update="card-desc-form: '.card-desc'"
        ></button>
    </div>

    <div class="card-desc-content">
        <?= Markdown::parse($card->desc) ?>

        <?php if ($card->images): ?>
            <div class="card-desc-images">
                <?php foreach ($card->images as $image): ?>
                    <img src="<?= $image->getPath() ?>" width="120">
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>

<?php else: ?>
    <button id="btn_show_form_desc"
        class="btn-tdbd icon-plus"
        style="color: limegreen; cursor: pointer;"
        title="<?= Lang::get('webvpf.todoboard::lang.card.add_desc') ?>"
        role="button"

        data-stripe-load-indicator
        data-request="onLoadFormCardDesc"
        data-request-data="id: <?= $card->id ?>"
        data-request-update="card-desc-form: '.card-desc'"
    >
    </button>
<?php endif; ?>
