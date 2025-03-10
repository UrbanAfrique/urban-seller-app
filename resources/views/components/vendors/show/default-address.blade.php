
<div class="@if($type=='app')card mb-2 @else w3-card-4 @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>{{ trans('general.default_address') }}</strong></h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding @endif">
        <table class="@if($type=='app') table table-bordered mb-0 @else w3-table @endif">
            @if($vendor->country)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.country')}}</th>
                    <td>{{ $vendor->country }}</td>
                </tr>
            @endif
            @if($vendor->province)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.province')}}</th>
                    <td>{{ $vendor->province }}</td>
                </tr>
            @endif
            @if($vendor->city)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.city')}}</th>
                    <td>{{ $vendor->city }}</td>
                </tr>
            @endif
            @if($vendor->address1)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.address1')}}</th>
                    <td>{{ $vendor->address1 }}</td>
                </tr>
            @endif
            @if($vendor->address2)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.address2')}}</th>
                    <td>{{ $vendor->address2 }}</td>
                </tr>
            @endif
        </table>
    </div>
</div>
