<?php

namespace Modules\Comptabilite\Entities;

use Modules\Acl\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Document\Entities\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autorisation extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function exercice()
    {
        return $this->belongsTo(Exercice::class, 'exercice_id');
    }
    public function corps()
    {
        return $this->belongsTo(Corps::class, 'corps_id');
    }
    // public function devise()
    // {
    //     return $this->belongsTo(Mouvement::class, 'devise_id');
    // }

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
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
        return $this->belongsTo(User::class, 'user_id');
    }
}
