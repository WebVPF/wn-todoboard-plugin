<?php namespace WebVPF\TodoBoard\Models;

use Model;

class Card extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    public $table = 'webvpf_todoboard_cards';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasMany = [
        'comments' => ['WebVPF\TodoBoard\Models\Comment', 'softDelete' => true],
    ];

    public $belongsTo = [
        'column' => ['WebVPF\TodoBoard\Models\Column'],
        'user' => ['Backend\Models\User'],
    ];

    /**
     * Обложка карточки
     */
    public $attachOne = [
        'cover' => ['System\Models\File', 'softDelete' => true],
    ];

    /**
     * Прикреплые файлы к Описанию карточки (полю desc)
     */
    public $attachMany = [
        'images' => 'System\Models\File'
    ];

    public function afterCreate()
    {
        $column = \WebVPF\TodoBoard\Models\Column::find($this->column_id);

        $column->timestamps = false;
        $column->increment('count_cards');
        $column->timestamps = true;
    }
    
    public function afterDelete()
    {
        $column = \WebVPF\TodoBoard\Models\Column::find($this->column_id);

        $column->timestamps = false;
        $column->decrement('count_cards');
        $column->timestamps = true;
    }

    // public function getComments()
    // {
    //     $comments = \WebVPF\TodoBoard\Models\Comment::where('card_id', $this->id)->get();
    // }

    /**
     * Изменить колонку к которой относится карточка
     * 
     * @param int $column_id - ID-новой колонки
     */
    public function setNewColumn($column_id)
    {
        $column_old = \WebVPF\TodoBoard\Models\Column::find($this->column_id);
        $column_old->setCountCardsMinus();

        $this->timestamps = false;
        $this->column_id = $column_id;
        $this->save();
        $this->timestamps = true;
        
        $column_new = \WebVPF\TodoBoard\Models\Column::find($column_id);
        $column_new->setCountCardsPlus();
    }
}
