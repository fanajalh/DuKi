<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pocket extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'target_amount', 'deadline', 'creator_id'];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function totalSaved()
    {
        $deposits = $this->transactions()->where('type', 'deposit')->where('status', 'completed')->sum('amount');
        $withdrawals = $this->transactions()->where('type', 'withdrawal')->where('status', 'completed')->sum('amount');
        return $deposits - $withdrawals;
    }
}
