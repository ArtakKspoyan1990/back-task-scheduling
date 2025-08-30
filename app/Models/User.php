<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_available'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasksAssigned() { return $this->hasMany(Task::class, 'assigned_user_id'); }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasksCreated() { return $this->hasMany(Task::class, 'created_by'); }


    /**
     * @return mixed
     */
    public function getJWTIdentifier(){ return $this->getKey(); }


    /**
     * @return array
     */
    public function getJWTCustomClaims(){ return ['role'=>$this->role]; }


    /**
     * @return bool
     */
    public function isManager(): bool { return $this->role === 'manager'; }
}
