<?php

namespace Modules\Comptabilite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaccountClass extends Model
{
    protected $guarded = [];
    use HasFactory, SoftDeletes;
}
