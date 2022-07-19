<div class="card-header">
    <button type="button" class="close" data-dismiss="popup">×</button>
    <h2 class="modal-title" data-card-id="<?= $card->id ?>"><?= $card->title ?></h2>

    <div class="card-info card-details">
        <div>
            <?= Lang::get('webvpf.todoboard::lang.card.on_the_list') ?> <strong><?= $card->column->name ?></strong>
        </div>
        <div>
            <?= Lang::get('webvpf.todoboard::lang.card.added') ?> <?= $card->user->first_name ?> <?= Backend::dateTime($card->created_at, ['formatAlias' => 'dateTimeLongMin']) ?>
        </div>
    </div>

    <div class="card-desc">
        <?= $this->makePartial('card-desc', ['card' => $card]) ?>
    </div>
</div>

<div class="card-comments">
    <?php foreach ($card->comments as $comment): ?>
        <?= $this->makePartial('comment', ['comment' => $comment]) ?>
    <?php endforeach ?>
</div>

<?= $this->makePartial('comment-form', ['card' => $card]) ?>
