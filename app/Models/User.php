<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 *
 * @property BelongsToMany|Task $taskUser
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    const COLUMN_USERNAME = 'username';
    const COLUMN_PASSWORD = 'password';
    const COLUMN_ROLE = 'role';

    /**
     * Role Values
     */
    const ROLE_MEMBER = 'member';
    const ROLE_ADMIN = 'admin';

    /**
     * @param string $value
     * @return $this
     */
    public function setUsername(string $value):self
    {
        $this->{self::COLUMN_USERNAME} = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setPassword(string $value):self
    {
        $this->{self::COLUMN_PASSWORD} = bcrypt($value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setRole(string $value): self
    {
        $this->{self::COLUMN_ROLE} = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->{self::COLUMN_USERNAME};
    }

    /**
     * @return string
     */
    public function getRole():string
    {
        return $this->{self::COLUMN_ROLE};
    }

    /**
     * @return BelongsToMany
     */
    public function taskUser(): BelongsToMany
    {
        return $this->belongsToMany(Task::class,UserTask::class,'user_id','task_id');
    }

    /**
     * @return BelongsToMany
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class,'user_task');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
