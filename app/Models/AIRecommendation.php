<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIRecommendation extends Model
{
      use HasFactory;

    protected $fillable = [
        'user_id',
        'user_input',
        'recommendations',
        'session_id',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'recommendations' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add active scope
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->orWhere('is_active', true)
                    ->orWhere('status', 1);
    }

    // // Or if you have different status field, use this:
    // public function scopeActive($query)
    // {
    //     return $query->where('status', 'published')
    //                 ->orWhere('is_available', true);
    // }

    // Helper Methods
    public function getRecommendationSummary()
    {
        return $this->recommendations['best_for'] ?? 'No summary available';
    }

    public function getBudgetRange()
    {
        return $this->recommendations['budget_range'] ?? 'Not specified';
    }
}
