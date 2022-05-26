<?php namespace WebVPF\TodoBoard\Models;

use Model;

class Comment extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    public $table = 'webvpf_todoboard_comments';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'card' => ['WebVPF\TodoBoard\Models\Card'],
        'user' => ['Backend\Models\User'],
    ];

    public $attachMany = [
        'images' => 'System\Models\File'
    ];

    public function afterCreate()
    {
        $card = \WebVPF\TodoBoard\Models\Card::find($this->card_id);

        $card->timestamps = false;
        $card->increment('count_comments');
        $card->timestamps = true;
    }

    public function afterDelete()
    {
        $card = \WebVPF\TodoBoard\Models\Card::find($this->card_id);

        $card->timestamps = false;
        $card->decrement('count_comments');
        $card->timestamps = true;
    }

}
