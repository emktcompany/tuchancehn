<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportEnrollmentsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        app('db')->statement("create view report_enrollments as (
            select
                c.period,
                year(c.period) as year,
                month(c.period) as month,
                day(c.period) as day,
                if(c.gender, 'Masculino', 'Femenino') as gender,
                c.age_range,
                c.total,
                c.country,
                c.country_id,
                c.state,
                c.state_id,
                c.city,
                c.city_id,
                c.opportunity,
                c.opportunity_id,
                c.bidder,
                c.bidder_id,
                c.accepted,
                c.fullfilled
            from (
                select
                    date(date_format(enrollments.created_at, '%Y-%m-%d')) as period,
                    enrollments.opportunity_id,
                    opportunities.name as opportunity,
                    opportunities.bidder_id,
                    bidders.name as bidder,
                    candidates.country_id,
                    countries.name as country,
                    candidates.state_id,
                    states.name as state,
                    candidates.city_id,
                    cities.name as city,
                    candidates.gender,
                    candidates.age_range,
                    enrollments.is_accepted as accepted,
                    enrollments.is_fullfilled as fullfilled,
                    count(enrollments.id) as total
                from enrollments
                    inner join candidates on candidates.id = enrollments.candidate_id
                    inner join opportunities on opportunities.id = enrollments.opportunity_id
                    inner join countries on countries.id = candidates.country_id
                    left join states on states.id = candidates.state_id
                    left join cities on cities.id = candidates.city_id
                    left join bidders on bidders.id = opportunities.bidder_id
                where
                    enrollments.deleted_at is null
                group by
                    period, country_id, state_id, city_id, opportunity_id, bidder_id, is_accepted, is_fullfilled, gender, age_range
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
        app('db')->statement('drop view if exists report_enrollments');
    }
}
