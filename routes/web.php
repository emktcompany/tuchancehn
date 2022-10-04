<?php

$router->view('cv', 'site.cv')
    ->middleware('auth:api', 'role:candidate')
    ->name('cv');

$router->get('cv/download', function () {
    $pdf = app('snappy.pdf.wrapper');
    $pdf->loadView('site.cv')
        ->setOption('margin-top', 0)
        ->setOption('margin-left', 0)
        ->setOption('margin-right', 0)
        ->setOption('margin-bottom', 0);
    return $pdf->download('cv.pdf');
})
    ->middleware('auth:api', 'role:candidate')
    ->name('cv.download');

$router->view('/{p1?}/{p2?}/{p3?}/{p4?}/{p5?}/{p6?}', 'site.index')
    ->name('site.index')
    ->middleware('under-construction');
