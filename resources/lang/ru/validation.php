<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'confirmed' => 'Пароль не подтвержден.',
    'max' => [
        'string' => 'Значение поля :attribute должно быть не более :max символов',
    ],
    'min' => [
        'string' => 'Значение поля :attribute должно состоять минимум из :min символов.',
    ],
    'required' => 'Обязательное поле.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'taskStatusStoreName' => [
            'unique' => 'Статус с таким именем уже существует.',
        ],
        'taskStatusUpdateName' => [
            'unique' => 'Статус с таким именем уже существует.',
        ],
        'taskStoreName' => [
            'unique' => 'Задача с таким именем уже существует.',
        ],
        'taskUpdateName' => [
            'unique' => 'Задача с таким именем уже существует.',
        ],
        'labelStoreName' => [
            'unique' => 'Метка с таким именем уже существует.',
        ],
        'labelUpdateName' => [
            'unique' => 'Метка с таким именем уже существует.',
        ],
        'email' => [
            'unique' => 'Пользователь с такой почтой уже существует.'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
];
