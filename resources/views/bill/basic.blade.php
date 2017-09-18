<div class="row">
  {{ Form::showField($bill->display_id, trans('bill.bil_id')) }}
  {{ Form::showField(showDate($bill->bil_date), trans('bill.bil_date')) }}
  {{ Form::showField(showMoney($bill->total_amount), trans('bill.total')) }}
  {{ Form::showField(showMoney($bill->bil_paid), trans('bill.bil_paid')) }}
</div>
