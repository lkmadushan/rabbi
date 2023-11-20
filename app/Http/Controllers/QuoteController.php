<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\UseCases\FindDailyQuoteUseCase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class QuoteController extends Controller
{
    public function index(Request $request, FindDailyQuoteUseCase $dailyQuoteUseCase): Quote
    {
        $page = $request->input('page');
        $date =  Session::get('date', Carbon::now());

        if ($page === 'next') {
            $date = $date->addDay();
        }

        if ($page === 'previous') {
            $date = $date->subDay();
        }

        Session::put('date', $date);
        return $dailyQuoteUseCase->execute($date);
    }
}
