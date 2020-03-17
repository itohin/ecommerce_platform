<?php

namespace App\Scoping\Contract;

use Illuminate\Database\Eloquent\Builder;

interface Scope
{
    public function apply(Builder $builder, array $scopes);
}