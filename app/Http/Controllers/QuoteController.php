<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exceptions\QuotesException;
use Illuminate\Support\Facades\Session;
use App\UseCases\FindDailyQuoteUseCase;

class QuoteController extends Controller
{
    /**
     * @throws Exception
     */
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

        try {
            $quote = $dailyQuoteUseCase->execute($date);

            return [
                'date' => $date,
                'topic' => $quote->topic,
                'content' => $quote->content,
            ];
        } catch (QuotesException $e) {
            return [
                'message' => $e->getMessage()
            ];
        }
    }
}
