<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;




class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function teams(): BelongsToMany
    {
    return $this->belongsToMany(Team::class, 'team_user');
    }

    public function tasks()
    {
        return $this->belongsToMany(\App\Models\Task::class, 'task_user');
    }

    public function projects()
    {
        return $this->hasManyThrough(
            Project::class,  // Конечная модель (Проекты)
            Team::class,     // Промежуточная модель (Команды)
            'id',            // Связь: teams.id → projects.team_id
            'team_id',       // Связь: projects.team_id → teams.id
            'id',            // Связь: users.id → teams.id (из users_teams)
            'id'             // Связь: teams.id → users_teams.team_id
        );
    }



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
}
