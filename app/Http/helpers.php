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

function dayDiff($from, $to)
{
  return Carbon::parse($from)->diffInDays(Carbon::parse($to), false);
}

function showMoney($value, $withCurrency = false)
{
  return ($withCurrency ? config('myapp.base_currency') . ' ' : '') . number_format($value, 2);
}

function appendCurrency($value)
{
  return sprintf("$value (%s)", config('myapp.base_currency'));
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
