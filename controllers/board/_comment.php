<?php

$current_user = $comment->user->id === $this->user->id ? 'current-user' : '';



?>

<div class="comment <?= $current_user ?>" id="comment-<?= $comment->id ?>">
    <div class="comment-header">
        <img class="comment-avatar"
            src="<?= $comment->user->getAvatarThumb($size=32) ?>"
            width="32"
            height="32"
            alt="<?= $comment->user->first_name ?>"
        />

        <span class="comment-author"><?= $comment->user->first_name ?></span>

        <?= Lang::get('webvpf.todoboard::lang.card.commented') ?>

        <?= Backend::dateTime($comment->created_at, ['formatAlias' => 'dateTimeLongMin']) ?>

        <div class="dropdown">
            <span class="icon-ellipsis-h" data-toggle="dropdown"></span>

            <ul class="dropdown-menu" role="menu">
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#" class="wn-icon-pencil comment-edit" data-comment-id="<?= $comment->id ?>">
                        <?= Lang::get('webvpf.todoboard::lang.card.edit') ?>
                    </a>
                </li>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#" class="wn-icon-trash comment-delete" data-comment-id="<?= $comment->id ?>">
                        <?= Lang::get('backend::lang.form.delete') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="comment-content">
        <?= Markdown::parse($comment->content) ?>
    </div>
</div>
