<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Item
 *
 * @property int $id
 * @property string $item_name
 * @property string $image
 * @property int $price
 * @property int|null $favorite
 * @property string|null $comment_id
 * @property string $item_description
 * @property int|null $category_id
 * @property int $condition_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Purchase> $purchases
 * @property-read int|null $purchases_count
 * @method static \Illuminate\Database\Eloquent\Builder|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereFavorite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereItemDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Item whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'image',
        'price',
        'is_sold',
        'favorite',
        'comment',
        'item_description',
        'category_id',
        'condition_id'
    ];
    protected $casts = [
        'category_ids' => 'array'
    ];

    // リレーション
    public function likes() {
        return $this->hasMany(Like::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function purchases() {
        return $this->hasOne(Purchase::class);
    }
    public function condition() {
        return $this->belongsTo(Condition::class);
    }
    public function categories() {
        return $this->belongsToMany(Category::class, 'category_sale');
    }

    //アクセサ
    public function getIsSoldAttribute($value) {
        return (bool) $value;
    }

    // ローカルスコープ
    public function scopeKeywordSearch($query, $keyword) {
        if(!empty($keyword)) {
            $query->where('item_name', 'like', '%'.$keyword.'%');
        }
    }
}
