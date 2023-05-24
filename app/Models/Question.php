<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_title',
        'title_langs',
        'questions',
    ];

    protected $casts = [
        'title_langs' => AsCollection::class,
        'questions' => AsCollection::class,
    ];

    protected $appends = [
        'title'
    ];

    public function getTitleAttribute()
    {
        $title = \collect()->put('default', $this->default_title);

        return \collect($this->title_langs)->merge($title);
    }

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
     * function stats
     *
     * @param array $rawQueryToAppend
     * @param int $ttl
     * @param bool $clearCache
     *
     * @return Question
     */
    public static function stats(
        array $rawQueryToAppend = [],
        int $ttl = 120,
        bool $clearCache = false
    ): Question {
        $rawQueryToAppend = \array_filter(\array_values($rawQueryToAppend), 'is_string');

        $query = [
            'count(*) as total',
            ...$rawQueryToAppend,
        ];

        $cacheKey = serialize($query);

        if ($clearCache) {
            Cache::forget($cacheKey);
        }

        return Cache::remember(
            $cacheKey,
            $ttl,
            fn () => Question::select(
                \Illuminate\Support\Facades\DB::raw(\implode(',', $query))
            )->first()
        );
    }
}
