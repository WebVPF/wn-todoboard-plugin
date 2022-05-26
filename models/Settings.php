<?php namespace WebVPF\TodoBoard\Models;

use Model;

class Settings extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var array Behaviors implemented by this model.
     */
    public $implement = ['System.Behaviors.SettingsModel'];

    /**
     * @var string Unique code
     */
    public $settingsCode = 'webvpf_todoboard_settings';

    /**
     * @var mixed Settings form field definitions
     */
    public $settingsFields = 'fields.yaml';

    /**
     * @var array Validation rules
     */
    public $rules = [];
}
