{{ Form::open(['url' => 'reports/profitloss', 'v-ajax']) }}
<div class="row">
  {{ Form::bsYear('year', trans('report.pnl_year'), array_get($filter, 'year'), ['placeholder' => trans('report.pnl_year')]) }}
</div>
{{ Form::submit(trans('form.filter'), ['class' => 'btn btn-primary']) }}

<redirect-btn label="@lang('form.clear')" redirect="{{ urlTenant('reports/profitloss') }}"></redirect-btn>
{{ Form::close() }}
