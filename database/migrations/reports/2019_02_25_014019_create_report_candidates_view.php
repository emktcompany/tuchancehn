<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportCandidatesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        app('db')->statement("create view report_candidates as (
            select
                c.period,
                year(c.period) as year,
                month(c.period) as month,
                day(c.period) as day,
                c.total,
                if(c.gender, 'Masculino', 'Femenino') as gender,
                c.age_range,
                c.country,
                c.country_id,
                c.state,
                c.state_id,
                c.city,
                c.city_id
            from (
                select
                    date(date_format(candidates.created_at, '%Y-%m-%d')) as period,
                    candidates.country_id,
                    countries.name as country,
                    candidates.state_id,
                    states.name as state,
                    candidates.city_id,
                    cities.name as city,
                    candidates.gender,
                    candidates.age_range,
                    count(candidates.id) as total
                from candidates
                    inner join countries on countries.id = candidates.country_id
                    left join states on states.id = candidates.state_id
                    left join cities on cities.id = candidates.city_id
                where
                    candidates.deleted_at is null
                group by
                    period, country_id, state_id, city_id, gender, age_range
                order by
                    period desc
            ) as c
        )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        app('db')->statement('drop view if exists report_candidates');
    }
}
