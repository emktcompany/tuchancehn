<?php

namespace App\Http\Requests\Admin;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StatsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api') && $this->user('api')->hasAnyRole([
            'admin', 'bidder',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from.year'  => ['required', 'digits:4'],
            'from.month' => ['required', 'numeric', 'between:1,12'],
            'to.year'    => ['required', 'digits:4'],
            'to.month'   => ['required', 'numeric', 'between:1,12'],
        ];
    }

    /**
     * Push errors in case validation fails
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        // code...
    }

    /**
     * Steps
     * @return \Illuminate\Support\Collection
     */
    public function steps()
    {
        $step_count = $this->end()->diffInMonths($this->start());
        $steps      = [];
        $start      = $this->start();

        for ($i = 0; $i <= $step_count; $i++) {
            $end = $start->copy()->endOfMonth();
            array_push($steps, compact('start', 'end'));
            $start = $start->copy()->addMonth();
        }

        return collect($steps);
    }

    /**
     * Start of period
     * @return \Carbon\Carbon
     */
    public function start()
    {
        $from = $this->get('from');
        $then = Carbon::createFromDate($from['year'], $from['month'], 1);
        $then->setTime(0, 0, 0);
        return $then;
    }

    /**
     * End of period
     * @return \Carbon\Carbon
     */
    public function end()
    {
        $to   = $this->get('to');
        $then = Carbon::createFromDate($to['year'], $to['month'], 1);
        $then->lastOfMonth();
        return $then;
    }
}
