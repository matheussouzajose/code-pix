<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'owner_name',
        'number',
        'bank_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
        'bank_id' => 'string',
        'created_at' => 'datetime',
        'update_at' => 'datetime',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function pixKeys(): HasMany
    {
        return $this->hasMany(PixKey::class);
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class);
    }
}
