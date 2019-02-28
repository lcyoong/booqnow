<?php

namespace Repositories;

use Illuminate\Http\Request;
// use App\Customer;
use Filters\AddonFilter;
use DB;
use Carbon\Carbon;

class AddonRepository extends BaseRepository
{

  /**
   * Create a new repository instance.
   */
    public function __construct()
    {
        parent::__construct('App\Addon');

        $this->filter = new AddonFilter();

        $this->rules = [
      'add_booking' => 'sometimes|exists:bookings,book_id',
      'add_resource' => 'required|exists:resources,rs_id',
      // 'add_bill' => 'required|exists:bills,bil_id',
      'add_customer' => 'sometimes|exists:customers,cus_id',
      'add_customer_name' => 'required',
      'add_date' => 'required|date',
      'add_pax' => 'required|min:1|numeric',
      'add_unit' => 'required|min:1|numeric',
      'add_reference' => 'max:255',
      'add_tracking' => 'max:255',
      'add_agent' => 'sometimes|exists:agents,ag_id'
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
        $this->filter->add(['onDate' => Carbon::parse($date)->format('Y-m-d')]);

        $this->notInStatus(['cancelled']);

        return $this;
    }

    public function soldByMonth($year)
    {
        $this->ofYear($year)->masterType();

        return $this->repo->select(DB::raw("month(add_date) as mth, add_resource as resource, sum(add_pax) as counter"))
                ->filter($this->filter)
                ->groupBy(DB::raw("month(add_date), add_resource"))->get();
    }
}
