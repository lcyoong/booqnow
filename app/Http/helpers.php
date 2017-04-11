<?php

use Carbon\Carbon;

/**
 * Format URL for multi-tenant mode
 * @param  string $path
 * @return string
 */
function urlTenant($path)
{
  if (config('myapp.multi_tenant')) {
    return url(session('merchant')->mer_id . '/' . $path);
  }

  return url($path);
}

/**
 * Format date
 * @param  string $date - Valid date string
 * @return string
 */
function showDate($date)
{
  return Carbon::parse($date)->format('d, M Y');
}

/**
 * Return today's date
 * @param  string $format - Valid PHP date format
 * @return string
 */
function today($format = null)
{
  return date(!is_null($format) ? $format : config('myapp.php_date_format'));
}

/**
 * Calculate the difference in days for two dates
 * @param  string $from - starting date
 * @param  string $to - ending date
 * @return int
 */
function dayDiff($from, $to)
{
  return Carbon::parse($from)->diffInDays(Carbon::parse($to), false);
}

/**
 * Format money-related value
 * @param  mixed  $value - Money value in numeric
 * @param  boolean $withCurrency - to append default currency or not
 * @return string
 */
function showMoney($value, $withCurrency = false)
{
  $decimal = config('myapp.hide_cent') ? 0 : 2;

  return ($withCurrency ? config('myapp.base_currency') . ' ' : '') . number_format($value, $decimal);
}

/**
 * Append currency to a value
 * @param  mixed $value
 * @return string
 */
function appendCurrency($value)
{
  return sprintf("$value (%s)", config('myapp.base_currency'));
}

/**
 * Calculate the general tax amount for a given value
 * @param  mixed $gross - Amount in numeric
 * @return float;
 */
function calcTax($gross)
{
  return $gross * config('myapp.tax_percent')/100;
}

function datesOverlap($start_one,$end_one,$start_two,$end_two) {

  $start_one = Carbon::parse($start_one);

  $end_one = Carbon::parse($end_one);

  $start_two = Carbon::parse($start_two);

  $end_two = Carbon::parse($end_two);

  // If season crosses years
  if ($start_one->year != $end_one->year) {

    if ($start_two->month >= $start_one->month) {

      $start_one->year = $start_two->year;

    } else {

      $start_one->year = $start_two->year - 1;

    }

    $end_one->year = $start_one->year + 1;

  // If season doesn't cross years
  } else {

    $end_one->year = $start_one->year = $start_two->year;

  }

  if($start_one->lte($end_two) && $end_one->gte($start_two) || $start_two->lte($end_one) && $end_two->gte($start_one)) { //If the dates overlap

    return $end_one->min($end_two)->diffInDays($start_two->max($start_one)); //return how many days overlap

  }

  return 0; //Return 0 if there is no overlap
}
