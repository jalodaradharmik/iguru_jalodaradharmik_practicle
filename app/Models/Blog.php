<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App;
use Closure;
use GoogleTranslate;


class Blog extends Model
{
    use HasFactory;

    protected $guarded = [];  
    
    protected function name(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  GoogleTranslate::trans($value, app()->getLocale()),
        );
    }

    protected function description(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  GoogleTranslate::trans($value, app()->getLocale()),
        );
    }


}
