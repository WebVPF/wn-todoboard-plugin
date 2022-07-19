<div class="board-wrap">
    <div class="board" id="todo-board">
        <?php foreach ($boardColumns as $column): ?>
            <?= $this->makePartial('column', ['column' => $column]) ?>
        <?php endforeach; ?>
    </div>

    <?= $this->makePartial('create-column') ?>
</div>
