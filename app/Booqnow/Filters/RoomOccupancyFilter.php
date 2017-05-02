<?php

namespace Filters;

class RoomOccupancyFilter extends QueryFilter
{
  /**
   * Resource type filter
   * @param  string $value
   * @return Builder
   */
  public function withoutLabel($value)
  {
    if (!empty($value)) {

      $this->joins[] = 'joinBookings';
      $this->joins[] = 'joinResources';

      return $this->builder->whereNotIn('rs_label', $value);
    }
  }

  public function ofBookStatus($value)
  {
    if (!empty($value)) {

      $this->joins[] = 'joinBookings';

      return $this->builder->whereIn('book_status', $value);
    }
  }

  public function ofYear($value)
  {
    if (!empty($value)) {

      return $this->builder->whereYear('ro_date', $value);
    }
  }

  /**
   * Join resources to query
   * @return Builder
   */
  public function joinResources()
  {
    $this->builder->join('resources', 'rs_id', '=', 'book_resource');
  }

  /**
   * Join resources to query
   * @return Builder
   */
  public function joinBookings()
  {
    $this->builder->join('bookings', 'book_id', '=', 'ro_booking');
  }

  /**
   * Join resources to query
   * @return Builder
   */
  public function joinCustomers()
  {
    $this->builder->join('customers', 'cus_id', '=', 'book_customer');
  }

}
