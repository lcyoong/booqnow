<?php

use Carbon\Carbon;

function urlTenant($path)
{
  if (config('myapp.multi_tenant')) {
    return url(session('merchant')->mer_id . '/' . $path);
  }

  return url($path);
}

function showDate($date)
{
  return Carbon::parse($date)->format('d, M Y');
}

function today()
{
  return date(config('myapp.php_date_format'));
}

function dayDiff($from, $to)
{
  return Carbon::parse($from)->diffInDays(Carbon::parse($to), false);
}

function showMoney($value, $withCurrency = false)
{
  $decimal = config('myapp.hide_cent') ? 0 : 2;

  return ($withCurrency ? config('myapp.base_currency') . ' ' : '') . number_format($value, $decimal);
}

function appendCurrency($value)
{
  return sprintf("$value (%s)", config('myapp.base_currency'));
}

function calcTax($gross)
{
  return $gross * config('myapp.tax_percent')/100;
}


// function country($id)
// {
//   $countries = countries();
//
//   return array_get($countries, $id, 'N/A');
// }
//
// function countries()
// {
//   return Cache::remember('countries', 90, function()
//   {
//     return Country::toDropDown('coun_code', 'coun_name');
//   });
//
// }
