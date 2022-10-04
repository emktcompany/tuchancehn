<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;
use App\TuChance\Models\Asset;

    class BaseSeeder extends Seeder
{
    /**
     * The filesystem instance
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Import rows from json file to table.
     * @return void
     */
    protected function import($table)
    {
        $file = database_path("import/{$table}.json");
        $rows = json_decode($this->container['files']->get($file), true);

        collect($rows)->each(function ($row) use ($table) {
            $exists = false;
            $data   = $this->makeRow($row, $table);

            if (isset($row['id'])) {
                $exists = $this->container['db']->table($table)
                    ->where('id', $row['id'])
                    ->count() > 0;
            }

            if ($exists) {
                $this->container['db']->table($table)
                    ->where('id', $row['id'])
                    ->update($data);
            } else {
                $row['id'] = $this->container['db']->table($table)
                    ->insertGetId($data);

            }

            $this->saveFiles($row, $table);
        });
    }

    /**
     * Parse the input data into a
     * @param  array   $row
     * @param  string  $table
     * @return array
     */
    protected function makeRow(array $row, $table)
    {
        $now = Carbon::now();
        $row = array_merge([
            'created_at' => $now,
            'updated_at' => $now,
        ], $row);

        return collect($row)
            ->filter(function ($value, $column) use ($table) {
                return !(is_array($value) && isset($value['file']));
            })
            ->toArray();
    }

    /**
     * Parse the input data into a
     * @param  array   $row
     * @param  string  $table
     * @return array
     */
    protected function saveFiles(array $row, $table)
    {
        $model = 'App\\TuChance\\Models\\' . studly_case(str_singular($table));

        collect($row)
            ->each(function ($value, $column) use ($model, $table, $row) {
                if (isset($value['file']) && $value['file']) {
                    $files      = $this->getFilesystem();
                    $extension  = $files->extension(base_path($value['path']));
                    $now        = Carbon::now();
                    $directory  = "{$table}/{$now->format('Y-m-d')}";
                    $filename   = str_random(20) . ".{$extension}";
                    $save_value = "{$directory}/" . $filename;
                    $to         = storage_path("app/public/{$save_value}");

                    if (!$files->exists($folder = dirname($to))) {
                        $files->makeDirectory($folder, 0755, true, true);
                    }

                    $files->copy($from = base_path($value['path']), $to);

                    $asset = new Asset;
                    $asset->fill([
                        'original_filename' => basename($value['path']),
                        'extension'         => $extension,
                        'filesize'          => $files->size($from),
                        'mime'              => $files->mimeType($from),
                        'path'              => $save_value,
                    ]);
                    $asset->assetable()->associate($model::find($row['id']));
                    $asset->save();
                }
            });
    }

    /**
     * Get the current filesystem
     * @return \Illuminate\Filesystem\Filesystem
     */
    protected function getFilesystem()
    {
        if (!$this->filesystem) {
            $this->filesystem = app('files');
        }

        return $this->filesystem;
    }
}
