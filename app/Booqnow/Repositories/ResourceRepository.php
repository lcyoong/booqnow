<?php

namespace Repositories;

use Filters\ResourceFilter;
use DB;

class ResourceRepository extends BaseRepository
{

  /**
   * Create new repository instance
   */
    public function __construct()
    {
        parent::__construct('App\Resource');

        $this->filter = new ResourceFilter();

        $this->rules = [
      'rs_type' => 'required|exists:resource_types,rty_id',
      'rs_name' => 'required|max:255',
      'rs_price' => 'required|numeric',
    ];

        $this->alt_rules[0] = [
      'rs_type' => '',
    ];
    }

    /**
     * Add resource status filter to query
     * @param  string $value
     * @return Repository
     */
    public function ofStatus($value)
    {
        $this->filter->add(['status' => $value]);

        return $this;
    }

    /**
     * Add resource label filter to query
     * @param  string $value
     * @return Repository
     */
    public function ofLabel($value)
    {
        $this->filter->add(['label' => $value]);

        return $this;
    }

    /**
     * Add resource type filter to query
     * @param  string $value
     * @return Repository
     */
    public function ofType($value)
    {
        $this->filter->add(['type' => $value]);

        return $this;
    }

    public function occupancyByRoom($year)
    {
        return $this->repo->select(DB::raw("rs_name, month(ro_date) as mth, count(*) as counter"))
                ->leftJoin('room_occupancies', 'ro_room', '=', 'rs_id')
                ->join('bookingss', 'book_id', '=', 'ro_booking')
                // ->join('resource_types', 'rty_id', '=', 'rs_type')
                ->whereNotIn('rs_label', ['tent', 'bed', 'free'])
                ->where('rs_type', '=', 1)->whereRaw("year(ro_date) = $year")
                ->whereIn('book_status', ['checkedin', 'checkedout','confirmed'])
                ->groupBy(DB::raw("rs_name, month(ro_date)"))->get();
    }

    public function countByType($value = [])
    {
        return $this->repo->whereIn('rs_type', $value)->where('rs_status', '=', 'active')->count();
    }
}
