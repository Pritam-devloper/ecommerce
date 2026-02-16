<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    protected $table = 'search_history';
    
    protected $fillable = [
        'user_id',
        'query',
        'ip_address',
        'results_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get popular searches
     */
    public static function getPopularSearches($limit = 10)
    {
        return self::selectRaw('query, COUNT(*) as search_count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('query')
            ->orderByDesc('search_count')
            ->limit($limit)
            ->pluck('query');
    }
    
    /**
     * Get user's recent searches
     */
    public static function getUserRecentSearches($userId, $limit = 5)
    {
        return self::where('user_id', $userId)
            ->distinct('query')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->pluck('query');
    }
}
