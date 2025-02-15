<?php namespace WebVPF\TodoBoard\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use WebVPF\TodoBoard\Models\Column;
use WebVPF\TodoBoard\Models\Card;
use WebVPF\TodoBoard\Models\Comment;
use Input;

class Board extends Controller
{
    /**
     * @var array Form field configuration
     */
    public $form = '$/webvpf/todoboard/controllers/board/form-desc-card.yaml';

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('WebVPF.TodoBoard', 'todoboard');
        $this->pageTitle = e('Доска задач');

        $columns = Column::orderBy('sort_order', 'asc')->get();
        $this->vars['boardColumns'] = $columns;
    }

    public function index()
    {
        $this->addCss('/plugins/webvpf/todoboard/assets/css/style.css', 'WebVPF.TodoBoard');
        $this->addCss('/plugins/webvpf/todoboard/assets/css/prism-solarizedlight.css', 'WebVPF.TodoBoard');

        $this->addJs('/plugins/webvpf/todoboard/assets/js/sortable.min.js', 'WebVPF.TodoBoard');
        $this->addJs('/plugins/webvpf/todoboard/assets/js/board.js', 'WebVPF.TodoBoard');
        $this->addJs('/plugins/webvpf/todoboard/assets/js/sorting.js', 'WebVPF.TodoBoard');
        $this->addJs('/plugins/webvpf/todoboard/assets/js/card.js', 'WebVPF.TodoBoard');
        $this->addJs('/plugins/webvpf/todoboard/assets/js/prism.js', 'WebVPF.TodoBoard');
    }

    public function onCreateColumn() {
        if (Input::get('name') !== '') {
            $column = new Column;
            $column->name = e(Input::get('name'));
            $column->user_id = $this->user->id;
            $column->sort_order = Input::get('order');
            $column->save();

            return $this->makePartial('column', ['column' => $column]);
        }
    }

    public function onCreateCard() {
        if (Input::get('title') !== '') {
            $card = new Card;
            $card->title = e(Input::get('title'));
            $card->user_id = $this->user->id;
            $card->column_id = Input::get('column_id');
            $card->save();

            return $this->makePartial('column-card', ['card' => $card]);
        }
    }

    public function onCreateCardDesc() {
        $card = Card::find(Input::get('card_id'));
        $card->timestamps = false;
        $card->desc = Input::get('content');
        $card->save();
        $card->timestamps = true;

        return \Markdown::parse($card->desc);
    }

    // public function onEditCardDesc() {

    // }

    /**
     * Добавление комментария к карточке
     */
    public function onCreateComment() {
        $comment = new Comment;
        $comment->user_id = $this->user->id;
        $comment->card_id = Input::get('card_id');
        $comment->content = Input::get('content');
        $comment->save();

        return $this->makePartial('comment', ['comment' => $comment]);
    }

    /**
     *
     */
    public function onDeleteComment() {
        $comment = Comment::find( Input::get('comment_id') );
        $comment->delete();

        return [
            'card_id' => $comment->card_id,
            'card_count_comments' => $comment->card->count_comments,
        ];
    }

    /**
     * Карточка в модальном окне
     * @return str
     */
    public function onGetCard() {
        return $this->makePartial('card', ['card' => Card::find(Input::get('id'))]);
    }

    public function onLoadFormCardDesc() {
        $card = Card::find(Input::get('id'));

        $config = $this->makeConfig($this->form);
        $config->model = $card;
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);

        $this->vars['card'] = $card; //
        $this->vars['widget'] = $widget;

        // Initialize the Form widget
        // $this->formWidget = $this->makeWidget('Backend\Widgets\Form', $config);
        // $this->formWidget->bindToController();
        // $this->formWidget->previewMode = $this->previewMode;

        // return $this->formWidget;
        // return $this->makePartial('_card-desc-form', $this->vars);
    }

    public function onSaveCardDesc() {
        $card = Card::find(Input::get('card_id'));
        $card->desc = Input::get('desc');
        $card->save();
    }

    public function onReloadCardDesc() {
        $this->vars['card'] = Card::find(Input::get('card_id'));
    }

    /**
     * Сортировка колонок (при перетаскивании)
     */
    public function onSortColumn() {
        $data_sort = Input::get('data_sort');

        $columns = \WebVPF\TodoBoard\Models\Column::get();

        foreach ($columns as $column) {
            $column->timestamps = false;
            $column->sort_order = $data_sort[$column->id];
            $column->save();
            $column->timestamps = true;
        }
    }

    /**
     * Сортировка карточек - перемещение карточки внутри одной колонки
     */
    public function onSortCard() {
        $cards = Card::where('column_id', Input::get('column_id'))->get();

        $data_sort = Input::get('data_sort');

        foreach ($cards as $card) {
            $card->timestamps = false;
            $card->sort_order = $data_sort[$card->id];
            $card->save();
            $card->timestamps = true;
        }
    }

    /**
     * Сортировка карточек - перемещение карточки из одной колонки в другую
     *
     * - изменить родительскую колонку для перемещённой карточки
     * - число карточек минус
     * - число карточек плюс
     * - новая сортировка карточек в обеих колонках
     */
    public function onSortCard2() {
        $card = Card::find( Input::get('card_id') );
        $card->setNewColumn(Input::get('column_id_to')); // id-новой колонки

        $cards1 = Card::where('column_id', Input::get('column_id_from') )->get();
        $data_sort1 = Input::get('data_sort_from');

        foreach ($cards1 as $card) {
            $card->timestamps = false;
            $card->sort_order = $data_sort1[$card->id];
            $card->save();
            $card->timestamps = true;
        }

        $cards2 = Card::where('column_id', Input::get('column_id_to') )->get();
        $data_sort2 = Input::get('data_sort_to');

        foreach ($cards2 as $card) {
            $card->timestamps = false;
            $card->sort_order = $data_sort2[$card->id];
            $card->save();
            $card->timestamps = true;
        }
    }

    /**
     * Редактирование поля name у списка
     */
    public function onEditColumnName() {
        $column = Column::find(Input::get('column_id'));
        $column->name = Input::get('name');
        $column->save();
    }

    public function onEditCardName() {
        $card = Card::find(Input::get('card_id'));
        $card->title = Input::get('title');
        $card->save();
    }
}
