<?php

namespace App\Http\Controllers\Admin\Stats;

use App\Services\Analytics;
use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * Database connection
     * @var \App\Services\Analytics
     */
    protected $analytics;

    /**
     * New controller instance
     * @param \Illuminate\Database\Connection $db
     * @param \Illuminate\Http\Request        $request
     * @param \App\Services\Analytics         $analytics
     */
    public function __construct(
        Connection $db,
        Request $request,
        Analytics $analytics
    ) {
        parent::__construct($db, $request);
        $this->analytics = $analytics;
    }

    /**
     * Dashboard
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $opportunity_count = $this->count('report_opportunities')->sum('count');
        $bidder_count      = $this->count('report_bidders')->sum('count');
        $enrollment_count  = $this->count('report_enrollments')->sum('count');
        $candidate_count   = $this->count('report_candidates')->sum('count');

        $top_categories    = $this->topCategories();
        $top_bidders       = $this->topBidders();
        $top_opportunities = $this->topOpportunities();
        $pageviews         = $this->pageViews();

        return new JsonResponse(compact(
            'pageviews', 'top_bidders', 'top_opportunities', 'top_categories',
            'opportunity_count', 'enrollment_count', 'bidder_count',
            'candidate_count'
        ));
    }

    /**
     * Get pageviews
     * @return \Illuminate\Support\Collection
     */
    public function pageViews()
    {
        $metrics = ['sessions', 'pageviews'];
        $from    = ($this->parseSinceDate() ??
            Carbon::createFromTimestamp(strtotime('7 days ago'))
        )->format('Y-m-d');

        $data = $this->analytics
            ->get($metrics, $from)
            ->map(function ($row) {
                return array_map('intval', $row);
            });

        $labels   = $data->keys();
        $datasets = collect($metrics)
            ->flip()
            ->map(function ($i, $metric) use ($data) {
                return $data->pluck($metric);
            });

        return collect(compact('labels', 'datasets'));
    }

    /**
     * Get top bidders with the most opportunities
     * @return \Illuminate\Support\Collection
     */
    public function topBidders()
    {
        return $this->countQuery(
            'report_opportunities',
            ['bidder'],
            ['bidder_id']
        )->whereNotNull('bidder')->take(5)->get();
    }

    /**
     * Get opportunities with the most enrollments
     * @return \Illuminate\Support\Collection
     */
    public function topOpportunities()
    {
        return $this->count(
            'report_enrollments',
            ['opportunity'],
            ['opportunity_id'],
            'count',
            5
        );
    }

    /**
     * Get opportunities with the most enrollments
     * @return \Illuminate\Support\Collection
     */
    public function topCategories()
    {
        return $this->count(
            'report_opportunities',
            ['category'],
            ['category_id'],
            'count',
            5
        );
    }
}
