<?php

namespace App\Scoping;

use App\Scoping\Contract\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Scoper
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder, array $scopes)
    {
        foreach ($this->limitScopes($scopes) as $key => $scope) {
            if (!$scope instanceof Scope) {
                continue;
            }
            $scope->apply($builder, $this->request->get($key));
        }

        return $builder;
    }

    protected function limitScopes(array $scopes)
    {
        return Arr::only(
            $scopes,
            array_keys($this->request->all())
        );
    }
}