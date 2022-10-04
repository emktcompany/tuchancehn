<?php

namespace App\Http\Controllers\Admin\Stats;

use App\TuChance\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;

class CandidatesController extends BaseController
{
    public function index()
    {
        $dates = $this->dates();
        $ages  = $this->ages();

        $age_ranges = $this->db
            ->table('report_candidates')
            ->distinct('age_range')
            ->orderBy('age_range')
            ->get(['age_range'])
            ->pluck('age_range');

        $genders = $this->db
            ->table('report_candidates')
            ->distinct('gender')
            ->orderBy('gender')
            ->get(['gender'])
            ->pluck('gender');

        $users       = $this->users();
        $connections = $this->connections();

        return new JsonResponse(compact(
            'users', 'connections', 'dates', 'ages', 'age_ranges', 'genders'
        ));
    }

    public function users()
    {
        $query = $this->countQuery(
            'report_user_logins',
            ['user_id'],
            ['user_id']
        );

        $query->where('role', 'candidate');
        $this->filterQuery($query);

        $data = $query->get();

        $datasets = collect([
            'Heavy'    => [10, null],
            'Mid'      => [4, 9],
            'Low'      => [1, 3],
            'Inactive' => null,
        ])
            ->map(function ($frequency, $group) use ($data) {
                if (!$frequency) {
                    return User::role('candidate')
                        ->whereNotIn('users.id', function ($query) {
                            $query->select('user_id')
                                ->from('report_user_logins');

                            if ($start = $this->parseSinceDate()) {
                                $query->where('period', '>=', $start->format('Y-m-d'));
                            }

                            if ($end = $this->parseUntilDate()) {
                                $query->where('period', '<=', $end->format('Y-m-d'));
                            }
                        })
                        ->selectRaw('count(users.id) as total')
                        ->get()
                        ->map(function ($users) {
                            $row        = new \stdClass;
                            $row->count = $users->total;
                            $row->group = 'Inactive';
                            return $row;
                        });
                }

                return $data
                    ->filter(function ($row) use ($frequency) {
                        return $row->count >= $frequency[0] && ($frequency[1] ? $row->count <= $frequency[1] : true);
                    })
                    ->map(function ($row) use ($group) {
                        $row->group = $group;
                        $row->count = 1;
                        return $row;
                    })
                    ->values();
            });

        // dd($datasets);

        $labels = ['Total'];

        $datasets = $datasets->map(function ($data, $step) use ($labels) {
            return [$data->where('group', $step)->sum('count')];
            // return $labels->map(function ($step) use ($data) {
            // })->values();
        });

        return compact('datasets', 'labels');
    }

    public function connections()
    {
        // $query->countQuery();
    }

    public function ages()
    {
        $query = $this->countQuery(
            'report_candidates',
            ['age_range', 'gender'],
            ['age_range', 'gender'],
            'age_range'
        );

        $this->filterQuery($query);

        $data   = $query->get();
        $labels = $data->pluck('age_range')->unique()->values();

        $datasets = collect([
            'Masculino' => 'Masculino',
            'Femenino'  => 'Femenino',
            'Total'     => 'Total',
        ])
            ->map(function ($gender) use ($data) {
                if ($gender == 'Total') {
                    return $data->groupBy('age_range')
                        ->map(function ($data, $age_range) {
                            $count          = $data->sum('count');
                            $row            = new \stdClass;
                            $row->age_range = $age_range;
                            $row->count     = $count;
                            return $row;
                        })
                        ->values();
                } else {
                    return $data->where('gender', $gender)
                        ->values();
                }
            });

        $datasets = $datasets->map(function ($data) use ($labels) {
            return $labels->map(function ($step) use ($data) {
                return $data->where('age_range', $step)
                    ->sum('count');
            })->values();
        });

        return compact('datasets', 'labels');
    }

    /**
     * Main count
     * @return array
     */
    public function dates()
    {
        $query = $this->countQuery(
            'report_candidates',
            ['period', 'gender'],
            ['period', 'gender'],
            'period'
        );

        $this->filterQuery($query);

        $data = $query->get();

        $datasets = collect([
            'Masculino' => 'Masculino',
            'Femenino'  => 'Femenino',
            'Total'     => 'Total',
        ])
            ->map(function ($gender) use ($data) {
                if ($gender == 'Total') {
                    return $data->groupBy('period')
                        ->map(function ($data, $period) {
                            $count       = $data->sum('count');
                            $row         = new \stdClass;
                            $row->period = $period;
                            $row->count  = $count;
                            return $row;
                        })
                        ->values();
                } else {
                    return $data->where('gender', $gender)
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

    /**
     * Apply common filters to a given query
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function filterQuery(Builder $query)
    {
        if (
            $this->request->has('age_range') &&
            $age_range = $this->request->get('age_range')
        ) {
            $query->where('age_range', $age_range);
        }

        if (
            $this->request->has('gender') &&
            $gender = $this->request->get('gender')
        ) {
            $query->where('gender', $gender);
        }

        parent::filterQuery($query);
        return $query;
    }
}
