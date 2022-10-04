<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportBiddersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        app('db')->statement("create view report_bidders as (
            select
                c.period,
                year(c.period) as year,
                month(c.period) as month,
                day(c.period) as day,
                c.total,
                if(c.is_active, 'Aprobado', 'Sin aprobar') as active,
                c.is_active,
                c.country,
                c.country_id,
                c.category,
                c.category_id,
                c.interest,
                c.interest_id,
                c.state,
                c.state_id,
                c.city,
                c.city_id
            from (
                select
                    date(date_format(bidders.created_at, '%Y-%m-%d')) as period,
                    bidders.is_active,
                    bidders.country_id,
                    countries.name as country,
                    bidders.category_id,
                    categories.name as category,
                    bidders.interest_id,
                    interests.name as interest,
                    bidders.state_id,
                    states.name as state,
                    bidders.city_id,
                    cities.name as city,
                    count(bidders.id) as total
                from bidders
                    inner join countries on countries.id = bidders.country_id
                    left join states on states.id = bidders.state_id
                    left join cities on cities.id = bidders.city_id
                    left join categories on categories.id = bidders.category_id
                    left join interests on interests.id = bidders.interest_id
                where
                    bidders.deleted_at is null
                group by
                    period, country_id, state_id, city_id, category_id, is_active, interest_id
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
        app('db')->statement('drop view if exists report_bidders');
    }
}
