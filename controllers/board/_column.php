<div class="board-column" id="column-<?= $column->id ?>">

    <div class="column-head" data-column-id="<?= $column->id ?>">
        <div class="column-name"><?= html_entity_decode( $column['name'] ) ?></div>
    </div>

    <div class="column-cards" id="cards-column-<?= $column->id ?>">
        <?php foreach ($column->getCards() as $card): ?>
            <?= $this->makePartial('column-card', ['card' => $card]) ?>
        <?php endforeach; ?>
    </div>

    <div class="column-footer">
        <button class="btn-open-form-add-card wn-icon-plus">
            <?= Lang::get('webvpf.todoboard::lang.board.add_card') ?>
        </button>

        <div class="form-add-card">
            <textarea
                name="title"
                maxlength="512"
                placeholder="<?= Lang::get('webvpf.todoboard::lang.board.placeholder_card_title') ?>"
            ></textarea>

            <div class="card-add-controls">
                <button class="btn-add-card btn btn-primary" data-column-id="<?= $column->id ?>">
                    <?= Lang::get('webvpf.todoboard::lang.board.add_card') ?>
                </button>
                <icon
                    class="btn-close-form-add-card icon-close icon-lg"
                    data-toggle="tooltip"
                    data-placement="top"
                    data-delay="100"
                    title="<?= Lang::get('webvpf.todoboard::lang.board.cancel') ?>">
                </icon>
            </div>
        </div>
    </div>

</div>
