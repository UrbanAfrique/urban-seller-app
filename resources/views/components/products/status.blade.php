@if($product->approved=='1')
    <a class='btn btn-sm btn-success'>{{ trans('general.approved') }}</a>
@else
    <a class='btn btn-sm btn-warning'>{{ trans('general.pending_approval') }}</a>
@endif
