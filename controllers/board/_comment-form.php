<div class="card-footer">
    <img class="img-circle"
        src="<?= $card->user->getAvatarThumb($size=32) ?>"
        width="32"
        height="32"
        alt="<?= $card->user->first_name ?>"
    />

    <div class="comment-form">
        <textarea id="field_comment" class="" placeholder="<?= Lang::get('webvpf.todoboard::lang.card.placeholder_comment') ?>" name="content"></textarea>

        <!-- Здесь виджет загрузки -->

        <button id="btn_create_comment" data-card-id="<?= $card->id ?>" class="btn btn-default">
            <?= Lang::get('webvpf.todoboard::lang.card.comment') ?>
        </button>
    </div>
</div>
