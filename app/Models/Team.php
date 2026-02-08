<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\TeamObserver;
use App\Policies\TeamPolicy;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string $ulid
 * @property string|null $avatar
 * @property bool $personal_team
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $owner
 * @property-read Collection<int, TeamInvitation> $teamInvitations
 * @property-read int|null $team_invitations_count
 * @property-read Membership|null $membership
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team wherePersonalTeam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy(TeamObserver::class)]
#[UsePolicy(TeamPolicy::class)]
final class Team extends Model implements HasAvatar
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'personal_team',
        'ulid',
        'avatar',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hasUser($user): bool
    {
        return $this->users->contains($user) || $user->ownsTeam($this);
    }

    public function hasUserWithEmail(string $email): bool
    {
        return $this->allUsers()->contains(fn ($user): bool => $user->email === $email);
    }

    public function allUsers(): Collection
    {
        return $this->users->merge([$this->owner]);
    }

    public function teamInvitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }

    public function removeUser(User $user): void
    {
        if ($user->current_team_id === $this->id) {
            $user->forceFill(['current_team_id' => null])->save();
        }

        $this->users()->detach($user);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'membership')
            ->using(Membership::class)
            ->withTimestamps()
            ->as('membership');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->avatar)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($this->avatar);
        }

        return null;
    }

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            if (empty($model->ulid)) {
                $model->ulid = (string) \Illuminate\Support\Str::ulid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }
}
