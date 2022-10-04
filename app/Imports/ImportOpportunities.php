<?php

namespace App\Imports;

use App\TuChance\Models\Bidder;
use App\TuChance\Models\Category;
use App\TuChance\Models\Opportunity;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportOpportunities extends BaseImport
{
    /**
     * Bidder associated to the opportunity
     * @var \App\TuChance\Models\Bidder
     */
    protected $bidder;

    /**
     * @param  array  $row
     * @param  int    $index
     * @return void
     */
    protected function onRow($row, $index)
    {
        $country = $this->getCountry($row['pais']);
        $state   = $this->getState($row['departamento'], $country);
        $city    = $this->getCity($row['municipio'], $state);

        $opportunity                  = new Opportunity;
        $opportunity->is_active       = true;
        $opportunity->name            = $row['nombre'];
        $opportunity->allow_apply     = in_array($row['permitir'], [
            'Sí', 'Si', 'si', 'Sí', 1,
        ]);
        $opportunity->begin_at        = Date::excelToDateTimeObject($row['desde']);
        $opportunity->finish_at       = Date::excelToDateTimeObject($row['hasta']);
        $opportunity->summary         = $row['resumen'];
        $opportunity->description     = $row['descripcion'];
        $opportunity->requirements    = $row['requisitos'];
        $opportunity->characteristics = $row['caracteristicas'];

        $this->setLocation($opportunity, $country, $state, $city);

        $opportunity->bidder()
            ->associate($this->getBidder($row['oferente']));

        $opportunity->category()
            ->associate($this->getCategory($row['categoria']));

        $opportunity->save();
    }

    /**
     * Get the category
     * @param  string $name
     * @return \App\TuChance\Models\Category
     */
    public function getCategory($name)
    {
        return (new Category)->where('name', $name, 'like')
            ->first();
    }

    /**
     * Set the Bidder associated with the opportunities
     * @param  \App\TuChance\Models\Bidder               $bidder
     * @return \App\Console\Commands\ImportOpportunities
     */
    public function setBidder(Bidder $bidder)
    {
        $this->bidder = $bidder;
        return $this;
    }

    /**
     * Get the bidder associated with the opportunity
     * @param  string|null  $name
     * @return \App\TuChance\Models\Bidder
     */
    protected function getBidder($name = null)
    {
        if ($this->bidder) {
            return $this->bidder;
        }

        if (is_null($name) || (is_string($name) && trim($name) == '')) {
            return null;
        }

        return (new Bidder)->where('name', $name, 'like')
            ->first();
    }
}
