<?php

namespace Webkul\ElasticSearch\Console\Command;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Helper\ProgressBar;
use Webkul\Category\Models\Category;
use Webkul\Core\Facades\ElasticSearch;

class CategoryIndexer extends Command
{
    protected $signature = 'category:index';

    protected $description = 'Index all categories into Elasticsearch';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (config('elasticsearch.connection')) {
            $indexPrefix = config('elasticsearch.prefix');

            $start = microtime(true);

            $categories = DB::table('categories')->get();

            $categoryIndex = strtolower($indexPrefix.'_categories');

            if ($categories->isNotEmpty()) {
                $elasticCategory = [];

                try {
                    $elasticCategory = collect(Elasticsearch::search([
                        'index' => $categoryIndex,
                        'body'  => [
                            '_source' => ['updated_at'],
                            'query'   => [
                                'match_all' => new \stdClass,
                            ],
                            'size' => 1000000000,
                        ],
                    ])['hits']['hits'])->mapWithKeys(function ($hit) {
                        return [(int) $hit['_id'] => $hit['_source']['updated_at']];
                    })->toArray();
                } catch (\Exception $e) {
                    if (str_contains($e->getMessage(), 'index_not_found_exception')) {
                        $this->info('No data found. Initiating fresh indexing');

                        Log::channel('elasticsearch')->info('No data found. Initiating fresh indexing');
                    } else {
                        Log::channel('elasticsearch')->error('Exception while fetching '.$categoryIndex.' index: ', [
                            'error' => $e->getMessage(),
                        ]);

                        throw $e;
                    }
                }

                $this->info('Indexing categories into Elasticsearch...');
                $dbCategoryIds = $categories->pluck('id')->toArray();

                $progressBar = new ProgressBar($this->output, count($categories));
                $progressBar->start();

                foreach ($categories as $categoryDB) {
                    $category = new Category;

                    $category->forceFill((array) $categoryDB);
                    $category->syncOriginal();

                    if (
                        (
                            isset($elasticCategory[$category->id])
                            && $elasticCategory[$category->id] != Carbon::parse($category->updated_at)->setTimezone('UTC')->format('Y-m-d\TH:i:s.u\Z')
                        )
                        || ! isset($elasticCategory[$category->id])
                    ) {
                        Elasticsearch::index([
                            'index' => $categoryIndex,
                            'id'    => $category->id,
                            'body'  => $category->toArray(),
                        ]);
                    }
                    $progressBar->advance();
                }

                $progressBar->finish();
                $this->newLine();
                $this->info('Category indexing completed.');

                Log::channel('elasticsearch')->info('Category indexing completed.');

                $this->info('Checking for stale categories to delete...');

                $elasticCategoryIds = collect(Elasticsearch::search([
                    'index' => $categoryIndex,
                    'body'  => [
                        '_source' => false,
                        'query'   => [
                            'match_all' => new \stdClass,
                        ],
                        'size' => 1000000000,
                    ],
                ])['hits']['hits'])->pluck('_id')->map(fn ($id) => (int) $id)->toArray();

                $categoriesToDelete = array_diff($elasticCategoryIds, $dbCategoryIds);

                if (! empty($categoriesToDelete)) {
                    $this->info('Deleting stale categories from Elasticsearch...');
                    $deleteProgressBar = new ProgressBar($this->output, count($categoriesToDelete));
                    $deleteProgressBar->start();

                    foreach ($categoriesToDelete as $categoryId) {
                        Elasticsearch::delete([
                            'index' => $categoryIndex,
                            'id'    => $categoryId,
                        ]);
                        $deleteProgressBar->advance();
                    }

                    $deleteProgressBar->finish();
                    $this->newLine();
                    $this->info('Stale categories deleted successfully.');

                    Log::channel('elasticsearch')->info('Stale categories deleted successfully.');
                } else {
                    $this->info('No stale categories to delete.');

                    Log::channel('elasticsearch')->info('No stale categories to delete.');
                }
            } else {
                $this->info('No category found in the database. Attempting to delete the index if it exists:-');
                Log::channel('elasticsearch')->info('No category found in the database. Attempting to delete the index if it exists:-');

                try {
                    Elasticsearch::indices()->delete(['index' => $categoryIndex]);
                    $this->info($categoryIndex.' index deleted successfully.');

                    Log::channel('elasticsearch')->info($categoryIndex.' index deleted successfully.');
                } catch (\Exception $e) {
                    if (str_contains($e->getMessage(), 'index_not_found_exception')) {
                        $this->warn('Index not found: '.$categoryIndex);

                        Log::channel('elasticsearch')->warning($categoryIndex.'index not found: ', [
                            'warning' => $e->getMessage(),
                        ]);
                    } else {
                        Log::channel('elasticsearch')->error('Exception while clearing '.$categoryIndex.' index: ', [
                            'error' => $e->getMessage(),
                        ]);

                        throw $e;
                    }
                }
            }

            $end = microtime(true);

            $this->info('The operation took '.round($end - $start, 4).' seconds to complete.');
        } else {
            $this->warn('ELASTICSEARCH IS NOT ENABLED.');

            Log::channel('elasticsearch')->warning('ELASTICSEARCH IS NOT ENABLE.');
        }
    }
}
