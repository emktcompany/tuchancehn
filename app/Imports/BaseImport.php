<?php

namespace App\Imports;

use App\Exceptions\UserExistsException;
use App\TuChance\Contracts\Locateable;
use App\TuChance\Models\City;
use App\TuChance\Models\Country;
use App\TuChance\Models\State;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

abstract class BaseImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * Wheter the import was successful
     * @var boolean
     */
    protected $error = true;

    /**
     * Arbitraty message
     * @var string|null
     */
    protected $result;

    /**
     * Determine if an error occurred during import
     * @return boolean
     */
    public function wasSuccessful()
    {
        return !$this->error;
    }

    /**
     * Get the result message for the import
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param \Illuminate\Support\Collection $collection
     */
    public function collection(Collection $collection)
    {
        $db = app('db');

        $db->beginTransaction();
        $done = false;

        try {
            $collection = $collection
                ->filter(function ($row) {
                    return count(array_filter($row->all()));
                })
                ->each(function ($row, $index) {
                    $this->onRow($row, $index);
                });

            $done = true;
            $this->error = false;
            $db->commit();
            $this->result = "Imported {$collection->count()} records";
        } catch (UserExistsException $e) {
            $this->error  = true;
            $this->result = $e->getMessage();
            $db->rollback();
        }

        if (!$done) {
            $this->error = true;
            $db->rollback();
        }
    }

    /**
     * Callback for each row
     * @param  \Illuminate\Support\Collection  $row
     * @param  int                             $index
     * @return void
     */
    abstract protected function onRow($row, $index);

    /**
     * Guess the country from a given name
     * @param  string $country
     * @return \App\TuChance\Models\Country|null
     */
    protected function getCountry($country)
    {
        return (new Country)->where('name', $country, 'like')
            ->first();
    }

    /**
     * Guess the state from a given name
     * @param  string                             $state
     * @param  \App\TuChance\Models\Country|null  $country
     * @return \App\TuChance\Models\State|null
     */
    protected function getState($state, Country $country = null)
    {
        return (new State)->where('name', $state, 'like')
            ->where('country_id', $country->id ?? 0)
            ->first();
    }

    /**
     * Guess the city from a given name
     * @param  string                           $city
     * @param  \App\TuChance\Models\State|null  $state
     * @return \App\TuChance\Models\City|null
     */
    protected function getCity($city, State $state = null)
    {
        return (new City)->where('name', $city, 'like')
            ->where('state_id', $state->id ?? 0)
            ->first();
    }

    /**
     * Set all location related attributes on a given model
     * @param  \App\TuChance\Contracts\Locateable $model
     * @param  \App\TuChance\Models\Country|null  $country
     * @param  \App\TuChance\Models\State|null    $state
     * @param  \App\TuChance\Models\City|null     $city
     * @return void
     */
    protected function setLocation(Locateable $model, $country, $state, $city)
    {
        $model->country()->associate($country);
        $model->state()->associate($state);
        $model->city()->associate($city);
    }
}
