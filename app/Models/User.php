<?php

declare(strict_types=1);

namespace App\Models;

use Adultdate\Wirechat\Contracts\WirechatUser;
use Adultdate\Wirechat\Panel as WirechatStandalonePanel;
use Adultdate\Wirechat\Traits\InteractsWithWirechat;
use App\Observers\UserObserver;
use Exception;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Zap\Models\Concerns\HasSchedules;
use Laravel\Passport\Contracts\OAuthenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;  // Add this import
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Contracts\ScopeAuthorizable;

/**
 * @property int $id
 * @property string $ulid
 * @property bool $status
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $avatar_url
 * @property array<array-key, mixed>|null $custom_fields
 * @property string|null $locale
 * @property string|null $theme_color
 * @property int|null $current_team_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Team|null $currentTeam
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read Membership|null $membership
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Team> $teams
 * @property-read int|null $teams_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUlid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCustomFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereThemeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy(UserObserver::class)]
final class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, FilamentUser, HasAvatar, HasDefaultTenant, HasTenants, MustVerifyEmailContract, WirechatUser, OAuthenticatable
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use HasFactory;
    use HasRoles;
    use HasSchedules;
    use InteractsWithWirechat;
    use MustVerifyEmail;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $accessToken;

    protected $fillable = [
        'status',
        'ulid',
        'name',
        'email',
        'password',
        'avatar_url',
        'custom_fields',
        'locale',
        'theme_color',
        'current_team_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @throws Exception
     */
    public function canAccessPanel(Panel $panel): bool
    {
        //    $currentUser = Auth::user();
        //    if ($panel->getId() === 'admin' && $currentUser->role !== 'admin' && $currentUser->role !== 'super') {
        //        return false;
        //    }

        return true;
    }

    public function canImpersonate(): bool
    {
        $role = $this->role ?? null;
        if (in_array($role, ['admin', 'super', 'super_admin', 'superadmin'], true)) {
            return true;
        }
        return false;
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    public function currentTeam(): BelongsTo
    {
        if (is_null($this->current_team_id) && $this->id) {
            $this->switchTeam($this->personalTeam());
        }

        return $this->belongsTo(Team::class, 'current_team_id');
    }

    public function switchTeam($team): bool
    {
        if (! $this->belongsToTeam($team)) {
            return false;
        }

        $this->forceFill([
            'current_team_id' => $team->id,
        ])->save();

        $this->setRelation('currentTeam', $team);

        return true;
    }

    public function belongsToTeam($team): bool
    {
        return $this->ownsTeam($team) || $this->teams->contains(fn ($t) => $t->id === $team->id);
    }

    public function ownsTeam($team): bool
    {
        if (is_null($team)) {
            return false;
        }

        return $this->id === $team->user_id;
    }

    public function personalTeam(): ?Team
    {
        return $this->ownedTeams->where('personal_team', true)->first();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->belongsToTeam($tenant);
    }

    public function getTenants(Panel $panel): array|Collection
    {
        return $this->ownedTeams->merge($this->teams)->sortBy('name');
    }

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, Membership::class)
            ->withTimestamps()
            ->as('membership');
    }

    public function phone_queues(): HasMany
    {
        return $this->hasMany(\AdultDate\FilamentDialer\Models\PhoneQueue::class);
    }

    public function getDefaultTenant(Panel $panel): ?Model
    {
        return $this->currentTeam;
    }

    /**
     * Determine if the user can create new groups.
     */
    public function canCreateGroups(): bool
    {
        // By default, allow all authenticated users to create groups
        // You can customize this logic based on your requirements
        return true;
    }

    /**
     * Determine if the user can create new chats with other users.
     */
    public function canCreateChats(): bool
    {
        // By default, allow all authenticated users to create chats
        // You can customize this logic based on your requirements
        return true;
    }

    /**
     * Return the user's role.
     */
    public function hasRole(): ?string
    {
        return $this->role ?? null;
    }

    public function isAdmin(): bool
    {
        $role = $this->role ?? null;

        return in_array($role, ['admin', 'super', 'super_admin', 'superadmin'], true);
    }

    /**
     * Determine if the user can access wirechat panel.
     * Accepts both Filament Panel (for Filament routes) and Wirechat Panel (for standalone routes).
     */
    public function canAccessWirechatPanel(Panel|WirechatStandalonePanel $panel): bool
    {
        // By default, allow all authenticated users to access the panel
        // You can customize this logic based on your requirements
        return true;
    }

    /**
     * Override belongsToConversation to accept both Filament and standalone Conversation types.
     * This method works with both Filament wirechat routes and standalone wirechat routes.
     */
    public function belongsToConversation(\AdultDate\FilamentWirechat\Models\Conversation $conversation, bool $withoutGlobalScopes = false): bool
    {
        // Check if participants are already loaded
        if ($conversation->relationLoaded('participants')) {
            // If loaded, simply check the existing collection
            $participants = $conversation->participants;

            if ($withoutGlobalScopes) {
                $participants->withoutGlobalScopes();
            }

            return $participants->contains(function ($participant) {
                return $participant->participantable_id === $this->getKey() &&
                    $participant->participantable_type === $this->getMorphClass();
            });
        }

        $participants = $conversation->participants();

        if ($withoutGlobalScopes) {
            $participants->withoutGlobalScopes();
        }

        // Perform the query to check if user is a participant
        return $participants->where('participantable_id', $this->getKey())
            ->where('participantable_type', $this->getMorphClass())
            ->exists();
    }

public function oauthApps(): MorphMany  // Change return type from HasMany to MorphMany
{
    return $this->morphMany(\Laravel\Passport\Client::class, 'owner');  // Change from hasMany to morphMany with 'owner' as the morph name
}

public function tokens(): HasMany
{
    return $this->hasMany(\Laravel\Passport\Token::class);
}

public function tokenCan(string $scope): bool
{
    return $this->accessToken && $this->accessToken->can($scope);
}

public function tokenCant(string $scope): bool
{
    return ! $this->tokenCan($scope);
}

public function createToken(string $name, array $scopes = []): \Laravel\Passport\PersonalAccessTokenResult
{
    $token = $this->tokens()->create([
        'name' => $name,
        'scopes' => $scopes,
        'revoked' => false,
    ]);

    $plainTextToken = unpack('C*', \Illuminate\Support\Str::random(40));

    return new \Laravel\Passport\PersonalAccessTokenResult($plainTextToken, $token);
}

public function currentAccessToken(): ?ScopeAuthorizable
{
    return $this->accessToken;
}

public function withAccessToken(?ScopeAuthorizable $accessToken): static
{
    $this->accessToken = $accessToken;

    return $this;
}

    public function getProviderName(): string
    {
        return 'users';
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
            'custom_fields' => 'array',
        ];
    }

    protected function canManageTeam(): bool
    {
        return false;
    }

    protected function canRegisterTeam(): bool
    {
        return false;
    }

    public function canBeImpersonated(): bool
    {
        return auth()->user()->role === 'super';
    }
}
