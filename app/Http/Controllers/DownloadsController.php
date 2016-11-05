<?php

namespace App\Http\Controllers;

use app\Helpers\PoringaDownloader;
use app\Helpers\RusasDownloader;
use Illuminate\Http\Request;



class DownloadsController extends Controller
{
    public function poringa()
    {

        $poringa = \App\StatusDownlaoder::where('script','poringa')->first();

        $p = new PoringaDownloader();
        $p->setPicFolder(storage_path());
        $p->setStart($poringa->start);
        $p->setPages($poringa->pages);
        $p->startDownload();

        $lastPage = $poringa->start + $poringa->pages;
        $poringa->lastPage = $lastPage;
        $poringa->save();
    }

    public function rusas($log = false)
    {
        $rusas = \App\StatusDownlaoder::where('script','rusas')->first();
        $r = new RusasDownloader();
        $r->setPicFolder(storage_path().'/app/public/rusas');
        $start = ($rusas->start == 0)? $rusas->lastPage : $rusas->start;

        $r->setShowLog($log);
        $r->setStart($start);
        $r->setStep($rusas->pages);
        $r->setPagina(1);
        $r->startDownload();

        $lastPage = $start + $rusas->pages;
        $rusas->lastPage = $lastPage;
        $rusas->save();

    }
}
