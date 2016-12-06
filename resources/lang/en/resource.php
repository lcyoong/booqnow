<?php

return [
  // 'type' => 'Room',
  'list' => ':type',
  'new' => 'New :type',
  'edit' => 'Edit :type',
  'maintenance' => ':type Maintenance',
  'unit' => 'Unit',
  'rs_name' => 'Name',
  'rs_description' => 'Description',
  'rs_price' => sprintf('Base Price (%s)', config('myapp.base_currency')),
  'rs_status' => 'Status',
  'rooms' => 'Rooms',
  'itineraries' => 'Tours',
  'fnb' => 'F&B',

  'rm_from' => 'From date',
  'rm_to' => 'To date',
  'rm_resource' => 'Resource',
  'rm_description' => 'Description',
  'rm_status' => 'Status',
  'period' => 'Period',
  'maintenance_diff_units' => 'days',
];
