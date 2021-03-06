<?= Form::model($card, ['model' => $card, 'files' => true]) ?>

    <?= $widget->render() ?>

    <button
        class="btn btn-default"
        data-stripe-load-indicator
        data-request="onSaveCardDesc"
        data-request-data="card_id: <?= $card->id ?>"
        data-request-update="card-desc: '.card-desc'"
        data-request-success="highlightCode('.card-desc');"
    >
        <?= Lang::get('backend::lang.form.save') ?>
    </button>

    <a
        class="btn btn-default"
        href="javascript:;"
        data-stripe-load-indicator
        data-request="onReloadCardDesc"
        data-request-data="card_id: <?= $card->id ?>"
        data-request-update="card-desc: '.card-desc'"
        data-request-success="highlightCode('.card-desc');"
    >
        <?= Lang::get('backend::lang.form.cancel') ?>
    </a>

<?= Form::close() ?>
