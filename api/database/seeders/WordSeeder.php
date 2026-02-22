<?php

namespace Database\Seeders;

use App\Models\Definition;
use App\Models\Meaning;
use App\Models\Word;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entries = [
            [
                'word' => 'architecture',
                'phonetic' => '/ˈɑːkɪtɛktʃə/',
                'language' => 'en',
                'category' => 'general',
                'source_urls' => [],
                'meanings' => [
                    [
                        'part_of_speech' => 'noun',
                        'definitions' => [
                            ['definition' => 'The art or practice of designing and constructing buildings.', 'example' => 'The architecture of the cathedral is stunning.'],
                            ['definition' => 'The style in which a building is designed and built.', 'example' => 'Gothic architecture features pointed arches.'],
                        ],
                        'synonyms' => ['design', 'structure', 'construction'],
                    ],
                ],
            ],
            [
                'word' => 'beam',
                'phonetic' => '/biːm/',
                'language' => 'en',
                'category' => 'construction',
                'meanings' => [
                    [
                        'part_of_speech' => 'noun',
                        'definitions' => [
                            ['definition' => 'A long, sturdy piece of squared timber or metal used in construction to support weight.', 'example' => 'The steel beams support the roof.'],
                            ['definition' => 'A horizontal structural member that carries loads.', 'example' => 'The beam spans 20 meters across the hall.'],
                        ],
                        'synonyms' => ['girder', 'joist', 'rafter'],
                    ],
                ],
            ],
            [
                'word' => 'foundation',
                'phonetic' => '/faʊnˈdeɪʃən/',
                'language' => 'en',
                'category' => 'construction',
                'meanings' => [
                    [
                        'part_of_speech' => 'noun',
                        'definitions' => [
                            ['definition' => 'The lowest load-bearing part of a building, typically below ground level.', 'example' => 'The foundation must be poured on stable soil.'],
                            ['definition' => 'The base on which something stands or is built.', 'example' => 'A strong foundation is essential for tall buildings.'],
                        ],
                        'synonyms' => ['base', 'footing', 'substructure'],
                    ],
                ],
            ],
            [
                'word' => 'hello',
                'phonetic' => '/həˈloʊ/',
                'language' => 'en',
                'category' => 'general',
                'meanings' => [
                    [
                        'part_of_speech' => 'interjection',
                        'definitions' => [
                            ['definition' => 'Used as a greeting or to begin a phone conversation.', 'example' => 'Hello! How are you today?'],
                        ],
                        'synonyms' => ['hi', 'hey', 'greetings'],
                    ],
                ],
            ],
            [
                'word' => 'facade',
                'phonetic' => '/fəˈsɑːd/',
                'language' => 'en',
                'category' => 'architecture',
                'meanings' => [
                    [
                        'part_of_speech' => 'noun',
                        'definitions' => [
                            ['definition' => 'The principal front of a building facing a street or open space.', 'example' => 'The facade was restored in the 19th century.'],
                        ],
                        'synonyms' => ['front', 'elevation', 'face'],
                    ],
                ],
            ],
        ];

        foreach ($entries as $entry) {
            $word = Word::create([
                'word' => $entry['word'],
                'phonetic' => $entry['phonetic'] ?? null,
                'language' => $entry['language'] ?? 'en',
                'category' => $entry['category'] ?? 'general',
                'source_urls' => $entry['source_urls'] ?? [],
            ]);

            foreach ($entry['meanings'] as $m) {
                $meaning = $word->meanings()->create([
                    'part_of_speech' => $m['part_of_speech'],
                    'synonyms' => $m['synonyms'] ?? [],
                ]);
                foreach ($m['definitions'] as $d) {
                    $meaning->definitions()->create($d);
                }
            }
        }
    }
}
