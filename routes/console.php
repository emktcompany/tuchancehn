<?php
use App\Imports\ImportCandidates;
use App\Imports\ImportOpportunities;

Artisan::command('tuchance:import:excel:candidates', function () {
    $job = new ImportCandidates;
    $job->import('candidatos.xlsx');

    if ($job->wasSuccessful()) {
        $this->info($job->getResult());
    } else {
        $this->error($job->getResult());
    }
});
Artisan::command('tuchance:import:excel:opportunities', function () {
    $job = new ImportOpportunities;
    $job->import('oportunidades.xlsx');

    if ($job->wasSuccessful()) {
        $this->info($job->getResult());
    } else {
        $this->error($job->getResult());
    }
});
