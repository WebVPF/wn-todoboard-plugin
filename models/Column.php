<?php namespace WebVPF\TodoBoard\Models;

use Model;

class Column extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    public $table = 'webvpf_todoboard_columns';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasMany = [
        'cards' => [
            \WebVPF\TodoBoard\Models\Card::class,
            'softDelete' => true
        ],
    ];

    // public function beforeSave() {

    // }

    public function getCards() {
        $cards = \WebVPF\TodoBoard\Models\Card::where('column_id', $this->id)
            ->orderBy('sort_order', 'asc')
            ->get()
        ;

        return $cards;
    }

    public function setCountCardsPlus()
    {
        $this->timestamps = false;
        $this->increment('count_cards');
        $this->timestamps = true;
    }

    public function setCountCardsMinus()
    {
        $this->timestamps = false;
        $this->decrement('count_cards');
        $this->timestamps = true;
    }

}
