<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Carbon;

class QuotesException extends Exception
{
    public static function quotesNotFound(Carbon $date): QuotesException
    {
        return new self('Quotes not found for '.$date->toDateString());
    }
}
