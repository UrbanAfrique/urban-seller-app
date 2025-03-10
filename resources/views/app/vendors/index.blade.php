
@extends('layouts.app')
@section('content')

@if (request()->has('deleted'))
    <div class="alert alert-success">
        {{ request('deleted') }}
    </div>
@endif
<div class="card">
        
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ trans('general.name') }}</th>
                <!-- <th>{{ trans('general.company') }}</th> -->
                <th>{{ trans('general.phone') }}</th>
                <th>{{ trans('general.email') }}</th>
                <!-- <th>{{ trans('general.address') }}</th> -->
                <th class="text-center">{{ trans('general.approved') }}</th>
                <th class="text-center">{{ trans('general.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->name ?? '--' }}</td>
                    <!-- <td>{{ $vendor->company ?? '--' }}</td> -->
                    <td>{{ $vendor->phone ?? '--' }}</td>
                    <td>{{ $vendor->email ?? '--' }}</td>
                    <!-- <td>{{ \App\Services\VendorService::generateAddress($vendor) }}</td> -->
                    <td class="text-center" id="approved_holder">{!! \App\Services\VendorService::getApprovedHtml($vendor,'app') !!}</td>
                    <td class="text-center" id="action_holder">
                        @include('components.vendors.action')
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center p-3">
                        {{ trans('general.no_record_found') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('pageScript')
@endsection
