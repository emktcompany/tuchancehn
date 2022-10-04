<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TuChance\Models\Candidate;

class UpdateProjovenStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tuchance:projoven:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Candidate::whereNotNull('id_number')
            ->get()
            ->each(function ($candidate) {
                $id_number = preg_replace(
                    '/[^0-9A-Za-z]/',
                    '',
                    $candidate->id_number
                );

                $this->info($id_number);

                $participante = app('db')->connection('projoven')
                    ->table('participante')
                    ->where(app('db')->raw('REPLACE(identidad, \'-\', \'\')'), $id_number)
                    ->first();

                if ($participante) {
                    $candidate->projoven_centro = $participante->nombre_centro;
                    $candidate->projoven_curso = $participante->nombre_curso;
                    $candidate->projoven_estatus = $participante->estatus;
                    $candidate->timestamps = false;
                    $candidate->save();
                }
            });
    }
}
