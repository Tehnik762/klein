<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'verify',
        'status',
        'role',
        'phone',
        'phone_auth',
        'phone_verified',
        'phone_verify_token',
        'phone_verify_token_expiry',
    ];

    public const STATUS_WAIT = "1";
    public const STATUS_ACTIVE = "2";
    public const ROLE_USER = "2";
    public const ROLE_ADMIN = "1";
    public const ROLE_MODERATOR = "3";
    public const VERIFY_TIME = 300;


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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified' => 'boolean',
        'phone_verify_token_expire' => 'datetime',
        'phone_auth',
    ];

    public static function register($name, $email, $password)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'status' => self::STATUS_WAIT,
            'verify' => Str::random(10),
        ]);
    }

    public function isWait()
    {
        return $this->status == self::STATUS_WAIT;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function makeVerified()
    {

        if ($this->status == self::STATUS_ACTIVE) {
            return redirect()->route('login')->with('success', __('auth.AlreadyVerified'));
        }

        $this->status = self::STATUS_ACTIVE;
        $this->verify = null;
        $this->save();
    }

    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function isUser()
    {
        return $this->role == self::ROLE_USER;
    }

    public function isModerator()
    {
        return $this->role == self::ROLE_MODERATOR;
    }

    public static function rolesList()
    {
        return [
            self::ROLE_ADMIN => __('admin.admin'),
            self::ROLE_USER => __('admin.user'),
            self::ROLE_MODERATOR => __('admin.moderator'),
        ];
    }

    public function changeRole($newRole)
    {
        if (!array_key_exists($newRole, self::rolesList())) {

            throw new \InvalidArgumentException(__('auth.UndefinedRole') . " " . $newRole);
        }

        $this->role = $newRole;
        $this->save();
    }


    /*
    * Checks if the user has verified phone number
    * 
    */
    public function isPhoneVerified()
    {
        return $this->phone_verified;
    }

    public function unverifyPhone()
    {
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expiry = null;
        $this->save();
    }

    /*
    *   Generate Code for verification, change status
    *   @param  Carbon\Carbon  $time
    */

    public function requestPhoneVerification($time)
    {
        $this->phone_verified = false;

        if (!isset($this->phone)) {
            throw new \DomainException(__('admin.phoneempty'));
        } elseif (!is_null($this->phone_verify_token) && $time->lt($this->phone_verify_token_expiry)) {
            throw new \DomainException(__('admin.already'));
        }
        $this->phone_verify_token = random_int(10000, 99999);
        $this->phone_verify_token_expiry = $time->copy()->addSeconds(self::VERIFY_TIME);
        $this->save();
        return $this->phone_verify_token;
    }

    public function verifyToken($token, $time)
    {
        if ($time->gt($this->phone_verify_token_expiry)) {
            throw new \DomainException(__('admin.expired_token'));
        } elseif ($token != $this->phone_verify_token) {
            throw new \DomainException(__('admin.incorrect_token'));
        } else {
            $this->phone_verified = true;
            $this->phone_verify_token = null;
            $this->phone_verify_token_expiry = null;
            $this->save();
        }
    }

    public function isPhoneAuthActivated()
    {
        return $this->phone_auth;
    }

    public function switchPhoneAuth()
    {
        $this->phone_auth ? $this->phone_auth = false : $this->phone_auth = true;
        $this->save();
    }

    public function hasFilledProfile()
    {
        return (!empty($this->phone) && !empty($this->lastname) && !empty($this->phone_verified));
    }

    public function favorites()
    {
        return $this->belongsToMany(Advert::class, 'favorites_advert', "user_id", "advert_id");
    }


    public function getFavourites()
    {
        return $this->belongsToMany(Advert::class, 'favorites_advert', "user_id", "advert_id")
            ->wherePivot('user_id', $this->id);
    }
}
