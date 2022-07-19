<div class="column-card"
    id="card-<?= $card->id ?>"
    tabindex="0"
    data-control="popup"
    data-size="giant"
    data-adaptive-height="false"
    data-handler="onGetCard"
    data-request-data="id: <?= $card->id ?>"
    data-keyboard="false"
    data-request-complete="cardInit()"
>
    <div class="column-card-title"><?= $card->title ?></div>

    <div class="column-card-info">
        <?php if ($card->desc): ?>
            <icon
                class="wn-icon-align-left"
                title="<?= Lang::get('webvpf.todoboard::lang.board.card_with_desc') ?>"
            >
            </icon>
        <?php endif ?>

        <?php if ($card->count_comments): ?>
            <span
                class="wn-icon-comments count-comments"
                title="<?= Lang::get('webvpf.todoboard::lang.board.comments') ?>"
            >
                <?= $card->count_comments ?>
            </span>
        <?php endif ?>
    </div>
</div>
