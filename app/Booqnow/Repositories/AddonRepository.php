<?php

namespace Repositories;

use Illuminate\Http\Request;
// use App\Customer;
use Filters\AddonFilter;
use DB;

class AddonRepository extends BaseRepository {

  /**
   * Create a new repository instance.
   */
  public function __construct()
  {
    parent::__construct('App\Addon');

    $this->filter = new AddonFilter();

    $this->rules = [
      'add_booking' => 'required|exists:bookings,book_id',
      'add_resource' => 'required|exists:resources,rs_id',
      'add_bill' => 'required|exists:bills,bil_id',
      'add_customer' => 'required|exists:customers,cus_id',
      'add_date' => 'required|date',
      'add_pax' => 'required|min:1|numeric',
      'add_unit' => 'required|min:1|numeric',
      'add_reference' => 'max:255',
      'add_tracking' => 'max:255',
    ];
  }

  /**
   * Add addon resource type filter
   * @param  int $type - Resource type id
   * @return Repository
   */
  public function ofType($type)
  {
    $this->filter->add(['resourceType' => $type]);

    return $this;
  }

  /**
   * Add addon date filter
   * @param  string $date - Addon date
   * @return Repository
   */
  public function ofDate($date)
  {
    $this->filter->add(['onDate' => $date]);

    return $this;
  }

}
