<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BaseExport implements FromView
{
    /**
     * Items
     * @var array
     */
    protected $items;
    protected $view_name;

    /**
     * @param array $items
     * @param array $view_name
     */
    public function __construct(array $items, string $view_name)
    {
        $this->items = $items;
        $this->view_name = $view_name;
    }

    /**
     * Get the view to render
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        return view($this->view_name, [
            'items' => $this->items
        ]);
    }

}
