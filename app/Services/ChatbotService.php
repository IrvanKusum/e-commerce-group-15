<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class ChatbotService
{
    /**
     * Process user message and return AI response with product recommendations
     */
    public function processMessage(string $message): array
    {
        $message = strtolower($message);
        
        // Analyze user intent and extract keywords
        $intent = $this->analyzeIntent($message);
        $keywords = $this->extractKeywords($message);
        
        // Get product recommendations based on keywords
        $products = $this->findMatchingProducts($keywords, $intent);
        
        // Generate conversational response
        $response = $this->generateResponse($message, $products, $intent);
        
        return [
            'message' => $response,
            'products' => $products->take(3)->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->productImages->first()->image ?? null,
                    'slug' => $product->slug,
                    'category' => $product->productCategory->name ?? 'Unknown',
                    'description' => $product->description,
                ];
            })
        ];
    }
    
    /**
     * Analyze user intent from message
     */
    private function analyzeIntent(string $message): string
    {
        // Protection/Safety related
        if (preg_match('/(protect|safe|ankle|injury|support|stability)/i', $message)) {
            return 'protection';
        }
        
        // Performance related
        if (preg_match('/(fast|speed|run|marathon|lightweight)/i', $message)) {
            return 'performance';
        }
        
        // Training/Gym related
        if (preg_match('/(gym|workout|training|fitness|exercise|strength)/i', $message)) {
            return 'training';
        }
        
        // Sports specific
        if (preg_match('/(basketball|soccer|tennis|badminton|football)/i', $message)) {
            return 'sports';
        }
        
        return 'general';
    }
    
    /**
     * Extract relevant keywords from message
     */
    private function extractKeywords(string $message): array
    {
        $keywords = [];
        
        // Product categories - Indonesian and English
        if (preg_match('/(shoe|sepatu|footwear)/i', $message)) {
            $keywords[] = 'footwear';
            $keywords[] = 'sepatu';
        }
        if (preg_match('/(jersey|shirt|jacket|apparel|baju|clothing|pakaian|kaos)/i', $message)) {
            $keywords[] = 'apparel';
            $keywords[] = 'pakaian';
        }
        if (preg_match('/(racket|raket)/i', $message)) {
            $keywords[] = 'racket';
            $keywords[] = 'raket';
        }
        if (preg_match('/(dumbbell|bench|resistance|band|weights|gym|fitness|alat\s*gym)/i', $message)) {
            $keywords[] = 'gym';
            $keywords[] = 'fitness';
        }
        
        // Specific features - Indonesian and English
        if (preg_match('/(ankle|protect|support|high.?top|mata\s*kaki)/i', $message)) {
            $keywords[] = 'ankle-support';
            $keywords[] = 'high-top';
            $keywords[] = 'basketball';
        }
        if (preg_match('/(run|running|marathon|jog|lari)/i', $message)) {
            $keywords[] = 'running';
            $keywords[] = 'lari';
        }
        if (preg_match('/(basketball|basket)/i', $message)) {
            $keywords[] = 'basketball';
            $keywords[] = 'basket';
        }
        if (preg_match('/(soccer|football|futsal|sepak\s*bola)/i', $message)) {
            $keywords[] = 'soccer';
            $keywords[] = 'football';
        }
        if (preg_match('/(tennis|tenis)/i', $message)) {
            $keywords[] = 'tennis';
            $keywords[] = 'tenis';
        }
        if (preg_match('/(badminton|bulutangkis)/i', $message)) {
            $keywords[] = 'badminton';
            $keywords[] = 'bulutangkis';
        }
        if (preg_match('/(gym|fitness|strength|kuat|latihan)/i', $message)) {
            $keywords[] = 'gym';
            $keywords[] = 'strength';
            $keywords[] = 'fitness';
        }
        
        return array_unique($keywords);
    }
    
    /**
     * Find products matching keywords and intent
     */
    private function findMatchingProducts(array $keywords, string $intent): Collection
    {
        $query = Product::with(['productImages', 'productCategory']);
        
        if (!empty($keywords)) {
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('name', 'LIKE', "%{$keyword}%")
                      ->orWhere('description', 'LIKE', "%{$keyword}%")
                      // Also search in category name
                      ->orWhereHas('productCategory', function($catQuery) use ($keyword) {
                          $catQuery->where('name', 'LIKE', "%{$keyword}%");
                      });
                }
            });
        }
        
        // Intent-based filtering
        if ($intent === 'protection') {
            $query->where(function($q) {
                $q->where('description', 'LIKE', '%ankle%')
                  ->orWhere('description', 'LIKE', '%support%')
                  ->orWhere('description', 'LIKE', '%protection%')
                  ->orWhere('name', 'LIKE', '%basketball%')
                  ->orWhere('name', 'LIKE', '%striker%');
            });
        } elseif ($intent === 'performance') {
            $query->where(function($q) {
                $q->where('description', 'LIKE', '%lightweight%')
                  ->orWhere('description', 'LIKE', '%run%')
                  ->orWhere('description', 'LIKE', '%speed%');
            });
        } elseif ($intent === 'training') {
            $query->whereHas('productCategory', function($q) {
                $q->where('name', 'LIKE', '%Gym%')
                  ->orWhere('name', 'LIKE', '%Apparel%');
            });
        }
        
        $products = $query->limit(5)->get();
        
        // If no results, return popular products
        if ($products->isEmpty()) {
            $products = Product::with(['productImages', 'productCategory'])
                ->inRandomOrder()
                ->limit(3)
                ->get();
        }
        
        return $products;
    }
    
    /**
     * Generate conversational AI response
     */
    private function generateResponse(string $message, Collection $products, string $intent): string
    {
        $responses = [
            'protection' => [
                "Saya mengerti Anda mencari produk yang aman dan melindungi ankle Anda! Saya punya beberapa rekomendasi sepatu dengan ankle support yang excellent:",
                "Perfect! Untuk perlindungan ankle yang optimal, saya rekomendasikan sepatu-sepatu berikut:",
                "Ankle protection sangat penting! Berikut sepatu yang punya high-top design dan ankle support terbaik:",
            ],
            'performance' => [
                "Untuk performa maksimal, saya rekomendasikan produk-produk lightweight ini:",
                "Kalau cari yang cepat dan ringan, ini pilihan terbaik untuk Anda:",
                "Performance-oriented products yang cocok untuk Anda:",
            ],
            'training' => [
                "Untuk training dan workout, saya punya rekomendasi equipment terbaik:",
                "Perfect untuk gym session Anda! Cek produk-produk ini:",
                "Training gear yang cocok untuk kebutuhan fitness Anda:",
            ],
            'sports' => [
                "Untuk olahraga yang Anda mainkan, ini rekomendasi terbaik:",
                "Sports equipment yang sesuai dengan kebutuhan Anda:",
            ],
            'general' => [
                "Berdasarkan pencarian Anda, saya menemukan beberapa produk yang mungkin cocok:",
                "Berikut beberapa rekomendasi produk untuk Anda:",
                "Saya punya beberapa produk bagus yang sesuai:",
            ]
        ];
        
        if ($products->isEmpty()) {
            return "Maaf, saya tidak menemukan produk yang spesifik untuk kebutuhan Anda. Tapi saya punya beberapa produk populer yang mungkin Anda suka!";
        }
        
        $responseArray = $responses[$intent] ?? $responses['general'];
        return $responseArray[array_rand($responseArray)];
    }
}
