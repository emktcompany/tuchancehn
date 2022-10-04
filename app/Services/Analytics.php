<?php

namespace App\Services;

use Google_Service_Analytics;
use Illuminate\Contracts\Cache\Repository;

class Analytics
{
    /**
     * Analytics service
     * @var /Google_Service_Analytics
     */
    protected $analytics;

    /**
     * Cache repository
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * @param /Google_Service_Analytics $analytics
     */
    public function __construct(
        Google_Service_Analytics $analytics,
        Repository $cache
    ) {
        $this->analytics = $analytics;
        $this->cache     = $cache;
    }

    /**
     * Get metric for a period of time
     * @param  string $metric
     * @param  string $from
     * @param  string $dimension
     * @return \Illuminate\Support\Collection
     */
    public function get(array $metrics, $from, $dimension = 'day')
    {
        $metric  = 'ga:' . implode(',ga:', $metrics);
        $key     = "ga:{$metric},{$from},{$dimension}";

        $data = $this->cache
            ->remember($key, 60, function () use ($metric, $from, $dimension) {
                $profile = 'ga:' . env('ANALYTICS_PROFILE');

                return $this->analytics->data_ga
                    ->get($profile, $from, date('Y-m-d'), $metric, [
                        'dimensions' => "ga:{$dimension}",
                    ]);
            });

        return collect($data->getRows())
            ->map(function ($row) use ($metrics) {
                return [
                    head($row), array_combine($metrics, array_slice($row, 1)),
                ];
            })
            ->pluck(1, 0);
    }
}
