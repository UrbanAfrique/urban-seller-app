@if($vendor->approved=='1')
    <a class='btn btn-sm btn-success'>{{ trans('general.approved') }}</a>
@elseif($vendor->approved=='0')
    <a class='btn btn-sm btn-danger'>{{ trans('general.not_approved') }}</a>
@else
    <a class='btn btn-sm btn-warning'>{{ trans('general.pending_approval') }}</a>
@endif
