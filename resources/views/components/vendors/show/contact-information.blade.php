
<div class="@if($type=='app')card mb-2 @else w3-card-4 @endif">
    <div class="@if($type=='app') card-header bg-white @else w3-border-bottom w3-padding-left @endif">
        <h6 class="@if($type=='app') mb-0 @endif"><strong>{{ trans('general.contact_information') }}</strong></h6>
    </div>
    <div class="@if($type=='app') card-body @else w3-padding @endif">
        <table class="@if($type=='app') table table-bordered mb-0 @else w3-table @endif">
            @if($vendor->name)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.name')}}</th>
                    <td>{{ $vendor->name }}</td>
                </tr>
            @endif
            @if($vendor->email)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.email')}}</th>
                    <td>{{ $vendor->email }}</td>
                </tr>
            @endif
            @if($vendor->phone)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.phone')}}</th>
                    <td>{{ $vendor->phone }}</td>
                </tr>
            @endif
            @if($vendor->domain)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.domain')}}</th>
                    <td>{{ $vendor->domain }}</td>
                </tr>
            @endif
            @if($vendor->company)
                <tr>
                    <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.company')}}</th>
                    <td>{{ $vendor->company }}</td>
                </tr>
            @endif
            <tr>
                <th class="@if($type=='app') fw-bold @else  w3-fw-bold @endif">{{trans('general.status')}}</th>
                <td>
                    @if($vendor->approved)
                        {{ trans('general.approved') }}
                    @else
                        {{ trans('general.pending_approval') }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
