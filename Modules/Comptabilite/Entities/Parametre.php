<?php

namespace Modules\Comptabilite\Entities;

use Modules\Acl\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parametre extends Model
{
    protected $guarded = [];
    use HasFactory, SoftDeletes;

    public function exercice()
    {
        return $this->belongsTo(Exercice::class, 'exercice_id');
    }

    public function devise()
    {
        return $this->belongsTo(Mouvement::class, 'devise_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
