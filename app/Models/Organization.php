<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Organization
 *
 * @property int $id
 * @property string|null $name
 * @property string $org_ref
 * @property int $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $owner
 * @method static \Database\Factories\OrganizationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereOrgRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'org_ref',
        'owner_id',
    ];

    /**
     * Get the owner that owns the Organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    /**
     * function getByIdAndCache
     *
     * @param ?int $organizationId
     *
     * @return ?object
     */
    public static function getByIdAndCache(?int $organizationId): ?object
    {
        return Cache::remember(
            "org-getByIdAndCache-{$organizationId}",
            300,
            fn () => Organization::whereId($organizationId)->first()
        );
    }

    /**
     * function getByOrgRefAndCache
     *
     * @param ?string $orgRef
     *
     * @return ?object
     */
    public static function getByOrgRefAndCache(?string $orgRef): ?object
    {
        return Cache::remember(
            "org-getByOrgRefAndCache-{$orgRef}",
            300,
            fn () => Organization::whereOrgRef($orgRef)->first()
        );
    }
}
