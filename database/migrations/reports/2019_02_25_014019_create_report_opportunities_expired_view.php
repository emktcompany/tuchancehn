<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportOpportunitiesExpiredView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        app('db')->statement("create view report_opportunities_expired as (
            select
                c.period,
                year(c.period) as year,
                month(c.period) as month,
                day(c.period) as day,
                c.total,
                c.bidder_id,
                c.bidder,
                c.category,
                c.category_id,
                c.country,
                c.country_id,
                c.state,
                c.state_id,
                c.city,
                c.city_id
            from (
                select
                    date(date_format(opportunities.finish_at, '%Y-%m-%d')) as period,
                    opportunities.bidder_id,
                    bidders.name as bidder,
                    opportunities.category_id,
                    categories.name as category,
                    opportunities.country_id,
                    countries.name as country,
                    opportunities.state_id,
                    states.name as state,
                    opportunities.city_id,
                    cities.name as city,
                    count(opportunities.id) as total
                from opportunities
                    inner join bidders on bidders.id = opportunities.bidder_id
                    inner join categories on categories.id = opportunities.category_id
                    left join countries on countries.id = opportunities.country_id
                    left join states on states.id = opportunities.state_id
                    left join cities on cities.id = opportunities.city_id
                where
                    opportunities.deleted_at is null
                group by
                    bidder_id, period, category_id, country_id, state_id, city_id
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
        app('db')->statement('drop view if exists report_opportunities_expired');
    }
}
