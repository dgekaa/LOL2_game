<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Avior\GameCore\GameDirector;

class PageController extends Controller
{
    public function index()
    {
        $game = (new GameDirector())->build('demo');
        dd($game);
    }
}
