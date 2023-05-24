<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use JeffGreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property-read mixed $has_confirmed_two_factor
 * @property-read mixed $has_enabled_two_factor
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Ideal aqui seria aplicar ACL usando o gate e as policies
        'organization_id', // Ideal aqui seria relacionamento polimorfico (um usuario pode fazer parte de N orgs)
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Get the organization that owns the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    /**
     * function userNumbers
     *
     * @param array $rawQueryToAppend
     * @param int $ttl
     * @param bool $clearCache
     *
     * @return User
     */
    public static function userNumbers(
        array $rawQueryToAppend = [],
        int $ttl = 120,
        bool $clearCache = false
    ): User {
        $rawQueryToAppend = \array_filter(\array_values($rawQueryToAppend), 'is_string');

        $query = [
            'count(*) as total',
            \sprintf(
                'SUM(CASE WHEN email_verified_at is null THEN 1 ELSE 0 END) as %s',
                'not_verified',
            ),
            \sprintf(
                'SUM(CASE WHEN email_verified_at is null THEN 0 ELSE 1 END) as %s',
                'total_verified',
            ),
            ...$rawQueryToAppend,
        ];

        // Campos NÃO nulos
        // select SUM(CASE WHEN email_verified_at is null THEN 0 ELSE 1 END) as not_verified from users;

        // Campos nulos
        // SUM(CASE WHEN email_verified_at is null THEN 1 ELSE 0 END) as not_verified

        $cacheKey = serialize($query);

        if ($clearCache) {
            Cache::forget($cacheKey);
        }

        return Cache::remember(
            $cacheKey,
            $ttl,
            fn () => User::select(
                \Illuminate\Support\Facades\DB::raw(\implode(',', $query))
            )->first()
        );
    }
}
