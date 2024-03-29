<?php

namespace Filters;

class BillFilter extends QueryFilter
{
    /**
     * Customer name filter
     * @param  string $value
     * @return Builder
     */
    public function customer_name($value = '')
    {
        if (!empty($value)) {
            return $this->builder->where('bil_customer_name', 'like', "%$value%");
        }
    }

    /**
     * Customer email filter
     * @param  string $value
     * @return Builder
     */
    public function customer_email($value = '')
    {
        if (!empty($value)) {
            $this->joins[] = 'joinCustomers';

            return $this->builder->where('cus_email', 'like', "%$value%");
        }
    }

    /**
     * Booking filter
     * @param  string $value
     * @return Builder
     */
    public function booking($value = '')
    {
        if (!empty($value)) {
            return $this->builder->where("bil_booking", '=', $value);
        }
    }

    /**
     * Bill id filter
     * @param  string $value
     * @return Builder
     */
    public function id($value = '')
    {
        if (!empty($value)) {
            return $this->builder->where("bil_id", '=', $value);
        }
    }

    /**
     * Bill status filter
     * @param  string $value
     * @return Builder
     */
    public function status($value = 'active')
    {
        if (!empty($value)) {
            return $this->builder->where("bil_status", '=', $value);
        }
    }

    /**
     * Bill date start filter
     * @param  string $value
     * @return Builder
     */
    public function start($value = '')
    {
        if (!empty($value)) {
            return $this->builder->where("bil_date", '>=', date('Y-m-d', strtotime($value)));
        }
    }

    /**
     * Bill date end filter
     * @param  string $value
     * @return Builder
     */
    public function end($value = '')
    {
        if (!empty($value)) {
            return $this->builder->where("bil_date", '<=', date('Y-m-d', strtotime($value)));
        }
    }

    public function ofBookStatus($value)
    {
        if (!empty($value)) {
            $this->joins[] = 'joinBookings';

            return $this->builder->whereIn('book_status', $value);
        }
    }

    public function bookCheckOutFrom($value)
    {
        if (!empty($value)) {
            $this->joins[] = 'joinBookings';

            return $this->builder->where("book_to", '>=', date('Y-m-d', strtotime($value)));
        }
    }

    public function bookCheckOutTo($value)
    {
        if (!empty($value)) {
            $this->joins[] = 'joinBookings';

            return $this->builder->where("book_to", '<=', date('Y-m-d', strtotime($value)));
        }
    }

    public function ofYear($value)
    {
        if (!empty($value)) {
            return $this->builder->whereYear('bil_date', $value);
        }
    }

    /**
     * Walk-in filter
     * @param  string $value
     * @return Builder
     */
    public function walkin($value = null)
    {
        if (!empty($value)) {
            return $this->builder->whereNull("bil_booking");
        }
    }

    public function withoutResourceLabel($value)
    {
        if (!empty($value)) {
            $this->joins[] = 'joinBookings';
            $this->joins[] = 'joinResources';

            return $this->builder->whereNotIn('rs_label', $value);
        }
    }


    /**
     * Join customers to query
     * @return Builder
     */
    public function joinCustomers()
    {
        $this->builder->join('customers', 'cus_id', 'bil_customer');
    }

    /**
     * Join resources to query
     * @return Builder
     */
    public function joinBookings()
    {
        $this->builder->join('bookings', 'book_id', '=', 'bil_booking');
    }

    /**
     * Join resources to query
     * @return Builder
     */
    public function joinResources()
    {
        $this->builder->join('resources', 'rs_id', 'book_resource');
    }
}
