<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;

class Order extends Model
{

    protected static function boot()
    {

        parent::boot();

        static::created(function($order){
            broadcast(new OrderCreated($order))->toOthers();
        });
        static::updated(function($order){
            broadcast(new OrderUpdated($order))->toOthers();
        });

    }
}
