<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AIRecommendation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIRecommendationController extends Controller
{
    public function showChat()
    {
        return view('frontend.ai.ai');
    }

    public function getRecommendations(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string'
        ]);

        $sessionId = $request->session_id ?? uniqid('ai_');

        try {
            // Generate AI recommendation
            $recommendation = $this->generateAIRecommendation($request->message);

            // Save to database
            AIRecommendation::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'user_input' => $request->message,
                'recommendations' => $recommendation,
                'session_id' => $sessionId,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $sessionId,
                'recommendation' => $recommendation,
                'products' => [], // Empty products array
                'user_type' => auth()->check() ? 'authenticated' : 'guest',
                'ai_used' => $recommendation['ai_source'] ?? 'mock'
            ]);

        } catch (\Exception $e) {
            Log::error('AI Recommendation Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'AI service temporarily unavailable. Please try again.'
            ], 500);
        }
    }

    private function generateAIRecommendation($userMessage)
    {
        // Directly use enhanced mock data (skip Hugging Face)
        $mockResponse = $this->getEnhancedMockResponse($userMessage);
        $mockResponse['ai_source'] = 'enhanced_mock';
        
        return $mockResponse;
    }

    private function getEnhancedMockResponse($userMessage)
    {
        $budget = $this->extractBudgetFromMessage($userMessage);
        $keywords = strtolower($userMessage);

        $enhancedResponses = [
            'gaming_camera_35k' => [
                'budget_range' => '28,000-42,000 BDT',
                'recommended_brands' => ['Poco', 'Realme', 'Xiaomi', 'Infinix'],
                'key_features' => ['Gaming Processor', '120Hz Display', 'Multiple Cameras', 'Fast Charging', 'Cooling System'],
                'best_for' => 'Gaming and Photography',
                'reasoning' => 'Perfect for gaming with smooth display and good cameras. Poco X6 Pro, Realme Narzo 60 Pro are excellent choices.'
            ],
            'gaming' => [
                'budget_range' => $budget ?: '25,000-40,000 BDT',
                'recommended_brands' => ['Poco', 'Realme', 'Xiaomi', 'Infinix'],
                'key_features' => ['High Refresh Rate', 'Gaming Processor', 'Good Cooling', 'Fast Display', 'Large RAM'],
                'best_for' => 'Gaming and Heavy Performance',
                'reasoning' => 'Excellent for gaming with powerful processors and smooth high refresh rate displays.'
            ],
            'camera_under_35k' => [
                'budget_range' => '28,000-42,000 BDT',
                'recommended_brands' => ['Xiaomi', 'Realme', 'Samsung', 'Oppo'],
                'key_features' => ['64MP+ Camera', 'Night Mode', 'Portrait Mode', 'Ultra-wide Lens', 'Stable Video'],
                'best_for' => 'Photography and Videography',
                'reasoning' => 'Great camera phones with multiple lenses and advanced features for photography enthusiasts.'
            ],
            'battery' => [
                'budget_range' => $budget ?: '18,000-32,000 BDT',
                'recommended_brands' => ['Xiaomi', 'Realme', 'Tecno', 'Samsung'],
                'key_features' => ['5000mAh+ Battery', 'Fast Charging', 'Power Saving', 'Long Backup', 'Efficient Processor'],
                'best_for' => 'Long Battery Life',
                'reasoning' => 'Exceptional battery life and fast charging capabilities for all-day usage.'
            ],
            'premium' => [
                'budget_range' => $budget ?: '80,000-150,000 BDT',
                'recommended_brands' => ['Samsung', 'Apple', 'OnePlus', 'Google'],
                'key_features' => ['Premium Build', 'Best Camera', 'Flagship Processor', 'Premium Display', '5G'],
                'best_for' => 'Premium and Flagship Experience',
                'reasoning' => 'Top-tier phones with the best features, build quality, and performance.'
            ],
            'default_35k' => [
                'budget_range' => '28,000-42,000 BDT',
                'recommended_brands' => ['Xiaomi', 'Realme', 'Samsung', 'Oppo'],
                'key_features' => ['Balanced Performance', 'Good Camera', 'Long Battery', 'AMOLED Display', 'Fast Charging'],
                'best_for' => 'Daily Use and Multitasking',
                'reasoning' => 'Well-rounded phones with excellent features for everyday use and good resale value.'
            ]
        ];

        // Specific case for "Gaming phone with good camera under 35,000 BDT"
        if ($this->containsAny($keywords, ['game', 'gaming']) && 
            $this->containsAny($keywords, ['camera', 'photo']) && 
            $this->containsAny($keywords, ['35', '35000', '35k'])) {
            return $enhancedResponses['gaming_camera_35k'];
        }
        elseif ($this->containsAny($keywords, ['camera', 'photo']) && 
                $this->containsAny($keywords, ['35', '35000', '35k'])) {
            return $enhancedResponses['camera_under_35k'];
        }
        elseif ($this->containsAny($keywords, ['game', 'gaming', 'pubg', 'cod', 'freefire'])) {
            return $enhancedResponses['gaming'];
        }
        elseif ($this->containsAny($keywords, ['camera', 'photo', 'picture', 'selfie', 'video'])) {
            return $enhancedResponses['camera_under_35k'];
        }
        elseif ($this->containsAny($keywords, ['battery', 'charge', 'power', 'backup', 'lasting'])) {
            return $enhancedResponses['battery'];
        }
        elseif ($budget && $this->extractMaxBudget($budget) > 70000) {
            return $enhancedResponses['premium'];
        }
        else {
            return $enhancedResponses['default_35k'];
        }
    }

    /**
     * Helper function to check if string contains any of the needles
     */
    private function containsAny($haystack, $needles)
    {
        foreach ($needles as $needle) {
            if (str_contains($haystack, $needle)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Extract budget from user message
     */
    private function extractBudgetFromMessage($message)
    {
        preg_match('/(\d+[,\d]*)\s*(taka|tk|bdt|৳|k| thousand|k tk)/i', $message, $matches);
        
        if (isset($matches[1])) {
            $budget = (float) str_replace([',', 'k'], '', $matches[1]);
            
            if (str_contains(strtolower($message), 'k') && $budget < 1000) {
                $budget = $budget * 1000;
            }
            
            $min = max(15000, $budget * 0.7);
            $max = min(200000, $budget * 1.3);
            
            if ($max <= $min) {
                $max = $min + 10000;
            }
            
            return number_format($min) . '-' . number_format($max) . ' BDT';
        }
        
        return null;
    }

    /**
     * Extract maximum budget from budget range string
     */
    private function extractMaxBudget($budgetRange)
    {
        preg_match('/(\d+[,\d]*)\s*-\s*(\d+[,\d]*)/', $budgetRange, $matches);
        if (count($matches) === 3) {
            return (float) str_replace(',', '', $matches[2]);
        }
        return 0;
    }

    /**
     * Get AI usage statistics
     */
    public function getStatistics()
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        $stats = [
            'totalRequests' => AIRecommendation::count(),
            'guestRequests' => AIRecommendation::whereNull('user_id')->count(),
            'userRequests' => AIRecommendation::whereNotNull('user_id')->count(),
            'todayRequests' => AIRecommendation::whereDate('created_at', today())->count(),
            'mockRequests' => AIRecommendation::whereRaw('JSON_EXTRACT(recommendations, "$.ai_source") = ?', ['enhanced_mock'])->count(),
            'popularSessions' => AIRecommendation::select('session_id')
                ->selectRaw('COUNT(*) as request_count')
                ->groupBy('session_id')
                ->orderBy('request_count', 'desc')
                ->limit(10)
                ->get()
        ];

        return view('admin.ai-statistics', $stats);
    }
}