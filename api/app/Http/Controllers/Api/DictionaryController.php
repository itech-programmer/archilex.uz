<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Dictionary API - Compatible with Android app format
 * Response structure matches api.dictionaryapi.dev for seamless integration
 */
class DictionaryController extends Controller
{
    /**
     * Get word definition by language, word and optional category.
     * Category: general (British/American), architecture, construction.
     * Returns array format compatible with Android WordResultDto (List<WordItemDto>).
     *
     * GET /api/v2/entries/{lang}/{word}?category=general|architecture|construction
     */
    public function show(Request $request, string $lang, string $word): JsonResponse
    {
        $category = $request->query('category', 'general');
        $allowedCategories = ['general', 'architecture', 'construction'];
        if (!in_array($category, $allowedCategories)) {
            $category = 'general';
        }

        $query = Word::with(['meanings.definitions'])
            ->where('word', strtolower($word))
            ->where('language', $lang)
            ->where('category', $category);

        $wordModel = $query->first();

        if (!$wordModel) {
            return response()->json([
                'title' => 'No Definitions Found',
                'message' => "Sorry pal, we couldn't find definitions for the word you were looking for.",
                'resolution' => 'You can try the search again at later time or head to the web instead.',
            ], 404);
        }

        // Format response to match Android WordItemDto structure
        $wordItem = [
            'word' => $wordModel->word,
            'phonetic' => $wordModel->phonetic,
            'sourceUrls' => $wordModel->source_urls ?? [],
            'meanings' => $wordModel->meanings->map(fn ($meaning) => [
                'partOfSpeech' => $meaning->part_of_speech,
                'definitions' => $meaning->definitions->map(fn ($def) => [
                    'definition' => $def->definition,
                    'example' => $def->example,
                ])->toArray(),
                'synonyms' => $meaning->synonyms ?? [],
            ])->toArray(),
        ];

        // Android expects array of WordItemDto (like the original API)
        return response()->json([$wordItem]);
    }
}
