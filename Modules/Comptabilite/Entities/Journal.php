<?php

namespace Modules\Comptabilite\Entities;

use Modules\Acl\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Journal extends Model
{
    protected $table = 'journaux';
    protected $guarded = [];
    use HasFactory, SoftDeletes;
    
    public function ecritures(){
        return $this->hasMany(Ecriture::class)->orderby('created_at', 'DESC');
    }

    public function compte_debit()
    {
        return $this->belongsTo(Saccount::class, 'compte_debit_id');
    }

    public function compte_credit()
    {
        return $this->belongsTo(Saccount::class, 'compte_credit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
