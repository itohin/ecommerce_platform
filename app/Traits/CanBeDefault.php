<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CanBeDefault
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->default) {
                $model->newQuery()->where('user_id', $model->user_id)->update([
                    'default' => false
                ]);
            }
        });
    }

    public function setDefaultAttribute($value)
    {
        $this->attributes['default'] = ($value === 'true' || $value ? true : false);
    }
}