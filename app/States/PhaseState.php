<?php

namespace App\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PhaseState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Trial::class)
            ->allowTransition(Trial::class, Active::class)
            ->allowTransition(Active::class, Suspended::class)
            ->allowTransition(Active::class, Canceled::class)
            ->allowTransition(Suspended::class, Active::class)
            ->allowTransition(Suspended::class, Canceled::class)
        ;
    }
}