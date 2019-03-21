<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;

class PortfolioController extends Controller
{
    //
    public function execute()
    {
        if(view()->exists('admin.portfolios'))
        {
            $portfolios = Portfolio::all();
            $data = [
                'title'         =>  'Портфолио',
                'portfolios'    =>  $portfolios
            ];
            return view('admin.portfolios', $data);
        }
        abort(404);
    }
}
