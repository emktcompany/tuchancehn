<?php

namespace App\Http\Controllers\Admin\Stats;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BiddersController extends BaseController
{
    public function index()
    {
        $dates = $this->dates();
        $categories = $this->categories();

        return new JsonResponse(compact('dates', 'categories'));
    }

    public function categories()
    {
        $query = $this->countQuery(
            'report_bidders',
            ['category', 'active'],
            ['category', 'active'],
            'category'
        );

        $this->filterQuery($query);

        $data   = $query->get();
        $labels = $data->pluck('category')->unique()->values();

        $datasets = collect([
            'Oferentes' => 'Oferentes',
            'Aprobados' => 'Aprobado',
            'Sin Aprobar' => 'Sin aprobar',
        ])
            ->map(function ($active) use ($data) {
                if ($active == 'Oferentes') {
                    return $data->groupBy('category')
                        ->map(function ($data, $category) {
                            $count = $data->sum('count');
                            $row   = new \stdClass;
                            $row->category = $category ?: 'Sin Categoría';
                            $row->count    = $count;
                            return $row;
                        })
                        ->values();
                } else {
                    return $data->where('active', $active)
                        ->values();
                }
            });

        $datasets = $datasets->map(function ($data) use ($labels) {
            return $labels->map(function ($step) use ($data) {
                return $data->where('category', $step)
                    ->sum('count');
            })->values();
        });

        return compact('datasets', 'labels');
    }

    /**
     * Dashboard
     * @return array
     */
    public function dates()
    {
        $datasets = collect([
            'Oferentes' => 'report_bidders',
            // 'active'  => null
        ])
            ->map(function ($table) {
                if (!$table) {
                    return null;
                }

                $query = $this->countQuery(
                    $table,
                    ['period'],
                    ['period'],
                    'period'
                );

                $this->filterQuery($query);

                return $query->get();
            });

        $query = $this->countQuery(
            'report_bidders',
            ['period', 'active'],
            ['period', 'active'],
            'period'
        );

        $this->filterQuery($query);

        $data = $query->get();

        $datasets = collect([
            'Oferentes' => 'Oferentes',
            'Aprobados' => 'Aprobado',
            'Sin Aprobar' => 'Sin aprobar',
        ])
            ->map(function ($active) use ($data) {
                if ($active == 'Oferentes') {
                    return $data->groupBy('period')
                        ->map(function ($data, $period) {
                            $count = $data->sum('count');
                            $row   = new \stdClass;
                            $row->period = $period;
                            $row->count  = $count;
                            return $row;
                        })
                        ->values();
                } else {
                    return $data->where('active', $active)
                        ->values();
                }
            });

        $begin = $this->earliestDateInCollection($datasets->first());
        $steps = $this->steps($begin);

        $labels = $steps->keys();

        $datasets = $datasets->map(function ($data) use ($steps) {
            return $steps->map(function ($step, $label) use ($data) {

                if ($step) {
                    return $data->filter(function ($row) use ($step) {
                        $time = strtotime($row->period);
                        $then = Carbon::createFromTimestamp($time);
                        return $then->between($step['begin'], $step['end']);
                    })->sum('count');
                }

                return $data ? $data->where('period', null)->sum('count') : 0;
            })->values();
        });

        return compact('datasets', 'labels');
    }
}
