<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'external_id',
        'bank_account_from_id',
        'pix_key_key',
        'pix_key_kind',
        'amount',
        'description',
        'status',
        'operation',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'external_id' => 'string',
        'bank_account_from_id' => 'string',
        'amount' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_from_id', 'id');
    }

    public function pixKey(): BelongsTo
    {
        return $this->belongsTo(PixKey::class, 'pix_key_key', 'key');
    }
}
