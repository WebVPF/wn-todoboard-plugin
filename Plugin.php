<?php namespace WebVPF\TodoBoard;

use System\Classes\PluginBase;
use Backend;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'webvpf.todoboard::lang.plugin.name',
            'description' => 'webvpf.todoboard::lang.plugin.description',
            'author'      => 'WebVPF',
            'icon'        => 'icon-list-check',
            'homepage'    => 'https://github.com/WebVPF/wn-todoboard-plugin',
        ];
    }

    public function registerNavigation()
    {
        return [
            'todoboard' => [
                'label'       => 'ToDo',
                'url'         => Backend::url('webvpf/todoboard/board'),
                'icon'        => 'icon-list-check',
                'permissions' => ['webvpf.todoboard.*'],
                'order'       => 900,
            ]
        ];
    }

}
