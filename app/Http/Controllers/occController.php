<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class occController extends Controller
{
    public function previewOrder(){
        $data['nav'] = "preview";
        return view('pages/occ/preview-order', $data);
    }

    public function onprogressTable(){
        $data['nav'] = "history-occ";
        return view('pages/occ/on-progress', $data);
    }

    public function completedTable(){
        $data['nav'] = "history-occ";
        return view('pages/occ/completed', $data);
    }

    public function canceledTable(){
        $data['nav'] = "history-occ";
        return view('pages/occ/canceled', $data);
    }

    public function allTable(){
        $data['nav'] = "history-occ";
        return view('pages/occ/all-order', $data);
    }
}
