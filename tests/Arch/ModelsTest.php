<?php

declare(strict_types=1);

arch('models')
    ->expect('App\Models')
    ->toHaveMethod('casts')
    ->toExtend('Illuminate\Database\Eloquent\Model');
