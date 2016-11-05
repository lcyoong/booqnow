<div class="row">
  {{ Form::showField($bill->bil_booking, trans('bill.bil_booking')) }}
  {{ Form::showField(showDate($bill->bil_date), trans('bill.bil_date')) }}
  {{ Form::showField(showMoney($bill->bil_gross + $bill->bil_tax, true), trans('bill.total')) }}
  {{ Form::showField(showMoney($bill->bil_paid, true), trans('bill.bil_paid')) }}
</div>
