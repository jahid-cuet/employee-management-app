<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * Mass assignment allow korar jonno fillable fields.
     */
    protected $fillable = [
        'article_id',
        'user_id',
        'gateway',
        'amount',
        'status',
    ];

    /**
     * Data casting: Amount-ke shob shomoy double/float hishebe pabe.
     */
    protected $casts = [
        'amount' => 'double',
    ];

    // --- Relationships ---

    /**
     * Payment kon user-er ta janar jonno relationship.
     * Use: $payment->user->name
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Payment kon article-er jonno hoyeche.
     * Use: $payment->article->title
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
