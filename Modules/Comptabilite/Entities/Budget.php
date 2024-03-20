<?php

namespace Modules\Comptabilite\Entities;

use Modules\Acl\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    protected $guarded = [];
    use HasFactory, SoftDeletes;

    public function lignes()
    {
        return $this->hasMany(Ligne::class, 'budget_id')->orderby('created_at', 'DESC');
    }

    public function ecritures() {
        return $this->hasManyThrough(Ecriture::class, Ligne::class)->orderby('created_at', 'DESC');
    }

    public function exercice()
    {
        return $this->belongsTo(Exercice::class, 'exercice_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
