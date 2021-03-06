<div class="column-form-create">
    <button id="open_form_add_column" type="button" class="btn btn-default icon-plus">
        <?= Lang::get('webvpf.todoboard::lang.board.create_new_list') ?>
    </button>

    <div id="form_add_column">
        <input
            class="form-control"
            type="text"
            name="name"
            autocomplete="off"
            maxlength="512"
            placeholder="<?= Lang::get('webvpf.todoboard::lang.board.placeholder_column_name') ?>"
        >

        <div class="column-add-controls">

            <input
                id="btn_add_colunm"
                class="btn btn-default"
                value="<?= Lang::get('webvpf.todoboard::lang.board.add_list') ?>"
            >

            <icon
                id="close_form_add_column"
                class="icon-close icon-lg"
                data-toggle="tooltip"
                data-placement="top"
                data-delay="100"
                title="<?= Lang::get('backend::lang.form.cancel') ?>"
            ></icon>

        </div>
    </div>
</div>
