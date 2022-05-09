<?php

declare(strict_types=1);

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Modules\Shop\Models\Review
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_recommended
 * @property int $rating
 * @property string|null $title
 * @property string|null $content
 * @property bool $approved
 * @property string $reviewrateable_type
 * @property int $reviewrateable_id
 * @property string $author_type
 * @property int $author_id
 * @property-read Model|\Eloquent $author
 * @property-read Model|\Eloquent $reviewrateable
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereAuthorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIsRecommended($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewrateableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereReviewrateableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Model {
    protected $fillable=['id','created_at','updated_at','is_recommended','rating','title','content','approved','reviewrateable_type','reviewrateable_id','author_type','author_id'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_recommended' => 'boolean',
        'approved' => 'boolean',
    ];

    /**
     * Get the table associated with the model.
     */
    public function getTable(): string {
        //return shopper_table('reviews');
        return 'reviews';
    }

    public function reviewrateable(): MorphTo {
        return $this->morphTo();
    }

    public function author(): BelongsTo {
        return $this->morphTo('author');
    }

    public function createRating(Model $reviewrateable, array $data, Model $author): self {
        $rating = new static();
        $rating->fill(array_merge($data, [
            'author_id' => $author->id,
            'author_type' => $author->getMorphClass(),
        ]));

        $reviewrateable->ratings()->save($rating);

        return $rating;
    }

    public function updateRating(int $id, array $data): self {
        $rating = static::find($id);
        $rating->update($data);

        return $rating;
    }

    public function getAllRatings(int $id, string $sort = 'desc'): Collection {
        return $this->newQuery()->select('*')
            ->where('reviewrateable_id', $id)
            ->orderBy('created_at', $sort)
            ->get();
    }

    public function getApprovedRatings(int $id, string $sort = 'desc'): Collection {
        return $this->newQuery()->select('*')
            ->where('reviewrateable_id', $id)
            ->where('approved', true)
            ->orderBy('created_at', $sort)
            ->get();
    }

    public function getNotApprovedRatings(int $id, string $sort = 'desc'): Collection {
        return $this->newQuery()->select('*')
            ->where('reviewrateable_id', $id)
            ->where('approved', false)
            ->orderBy('created_at', $sort)
            ->get();
    }

    public function getRecentRatings(int $id, int $limit = 5, string $sort = 'desc'): Collection {
        return $this->newQuery()->select('*')
            ->where('reviewrateable_id', $id)
            ->where('approved', true)
            ->orderBy('created_at', $sort)
            ->limit($limit)
            ->get();
    }

    public function getRecentUserRatings(int $id, int $limit = 5, bool $approved = true, string $sort = 'desc'): Collection {
        return $this->newQuery()->select('*')
            ->where('author_id', $id)
            ->where('approved', $approved)
            ->orderBy('created_at', $sort)
            ->limit($limit)
            ->get();
    }

    public function deleteRating(int $id): ?bool {
        return static::query()->find($id)->delete();
    }
}