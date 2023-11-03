<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'number',
        'owner_name',
        'balance',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'balance' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function pixKeys(): HasMany
    {
        return $this->hasMany(PixKey::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'bank_account_from_id', 'id');
    }
}
