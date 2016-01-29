<?php namespace App\Providers;

use App\Model\Memory;
use Illuminate\Support\ServiceProvider;
use View, Response;

class MemoryServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeHappiness();
        $this->composeMemoryTags();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     *  compose tags variable.
     */
    private function composeMemoryTags()
    {
        View::composer([
            'memory.show',
        ], function ($view) {
            $unique_tags = [];
            $memory_tags = Memory::all()->lists('tags');
            foreach ($memory_tags as $tag_item) {
                if ($tag_item)
                    $unique_tags = array_unique(array_merge($unique_tags, explode(',', $tag_item)));
            }
            $view->with([
                'memory_tags' => Response::json($unique_tags)->getContent()
            ]);
        });
    }

    /**
     *  compose happiness variable.
     */
    private function composeHappiness()
    {
        View::composer([
            'memory.show',
        ], function ($view) {
            for ($i = 0; $i <= 100; $i ++) {
                $happiness[$i] = $i;
            }
            $view->with([
                'happiness' => Response::json($happiness)->getContent()
            ]);
        });
        View::composer([
            'memory.create',
        ], function ($view) {
            for ($i = 100; $i >= 0; $i --) {
                $happiness[$i] = $i;
            }
            $view->with([
                'happiness' => $happiness
            ]);
        });
    }


}