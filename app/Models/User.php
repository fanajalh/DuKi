<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'pairing_code', 'partner_id', 'gender', 'is_single_mode'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function pockets()
    {
        // A user sees pockets they created OR their partner created
        return Pocket::where('creator_id', $this->id)
            ->orWhere('creator_id', $this->partner_id);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
