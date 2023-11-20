<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use App\UseCases\FindDailyQuoteUseCase;

class QuoteController extends Controller
{
    public function index(Request $request, FindDailyQuoteUseCase $dailyQuoteUseCase): array
    {
        $page = $request->input('page');
        $date =  Session::get('date', Carbon::now());

        if (empty($page)) {
            $date = Carbon::now();
        }

        if ($page === 'next') {
            $date = $date->addDay();
        }

        if ($page === 'previous') {
            $date = $date->subDay();
        }

        Session::put('date', $date);

        $quote = $dailyQuoteUseCase->execute($date);

        return [
            'topic' => $quote->topic,
            'content' => $quote->content
        ];
    }
}
