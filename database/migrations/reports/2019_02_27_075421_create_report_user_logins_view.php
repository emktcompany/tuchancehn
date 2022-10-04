<?php

use App\TuChance\Models\User;
use Illuminate\Database\Migrations\Migration;

class CreateReportUserLoginsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        app('db')->statement("create view report_user_logins as (
            select
                c.period,
                year(c.period) as year,
                month(c.period) as month,
                day(c.period) as day,
                c.total,
                c.user_id,
                c.name,
                roles.name as role,
                bidders.id as bidder_id,
                bidders.name as bidder
            from (
                select
                    date(date_format(logins.created_at, '%Y-%m-%d')) as period,
                    logins.user_id,
                    users.name,
                    count(logins.id) as total
                from logins
                    inner join users on users.id = logins.user_id
                where
                    users.deleted_at is null
                group by
                    period, logins.user_id
                order by
                    period desc
            ) as c
            inner join model_has_roles on (model_id = c.user_id and model_type = 'App\\\\TuChance\\\\Models\\\\User')
            inner join roles on (role_id = roles.id)
            left join bidders on (bidders.user_id = c.user_id)
        )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        app('db')->statement('drop view if exists report_user_logins');
    }
}
