<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Generate the account number and encrypt it before saving
            $user->account_number = self::encryptAccountNumber(self::generateAccountNumber());
        });
    }

    // Generate a unique account number
    public static function generateAccountNumber()
    {
        $accountNumber = mt_rand(1000000000, 9999999999); // 10-digit random number

        // Ensure uniqueness
        while (self::where('account_number', self::encryptAccountNumber($accountNumber))->exists()) {
            $accountNumber = mt_rand(1000000000, 9999999999);
        }

        return $accountNumber;
    }

    // Encrypt the account number before storing
    public static function encryptAccountNumber($accountNumber)
    {
        return Crypt::encryptString($accountNumber);
    }

    // Decrypt the account number when retrieving
    public function getDecryptedAccountNumber()
    {
        return Crypt::decryptString($this->account_number);
    }
}
