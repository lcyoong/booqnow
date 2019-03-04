<?php

namespace Repositories;

use Illuminate\Http\Request;
use Filters\RoomOccupancyFilter;
use DB;

class RoomOccupancyRepository extends BaseRepository
{

  /**
   * Create a new repository instance.
   */
    public function __construct()
    {
        parent::__construct('App\RoomOccupancy');

        $this->filter = new RoomOccupancyFilter();
    }

    public function byDayOfMonth($year)
    {
        $this->ofBookStatus(['checkedin', 'checkedout', 'confirmed'])->ofYear($year);

        return $this->repo->select(DB::raw("month(ro_date) as mth, day(ro_date) as day, count(*) as counter"))
                ->filter($this->filter)
                ->groupBy(DB::raw("month(ro_date), day(ro_date)"))->get();
    }

    public function byNational($year)
    {
        $this->ofBookStatus(['checkedin', 'checkedout', 'confirmed'])->ofYear($year);

        $this->filter->addJoins('joinBookings');
        $this->filter->addJoins('joinCustomers');

        return $this->repo->select(DB::raw("month(ro_date) as mth, cus_country as country, count(*) as counter"))
                ->filter($this->filter)
                ->groupBy(DB::raw("month(ro_date), cus_country"))->get();
    }

    public function byMonth($year)
    {
        $this->ofBookStatus(['checkedin', 'checkedout'])->ofYear($year);

        return $this->repo->select(DB::raw("month(ro_date) as mth, count(*) as counter"))
                ->filter($this->filter)
                ->groupBy(DB::raw("month(ro_date)"))->get();
    }
}
