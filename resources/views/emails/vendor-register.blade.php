@include('emails.components.mail-header',['mailHeading'=>'Register as seller'])
<main style="padding: 10px;">
    <p>Thanks for registering as a vendor.
        @if($vendor->approved==\App\Enum\ApprovedStatusEnum::PENDING)
            we will let you know while approved your account
        @endif
    </p>
    <h2>Detail of Vendor</h2>
    <table style="width: 100%; border-collapse: collapse;border: 1px solid lightgray;">
        <tr>
            <th style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ trans('general.name') }}</th>
            <td style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ $vendor->name }}</td>
        </tr>
        <tr>
            <th style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ trans('general.company') }}</th>
            <td style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ $vendor->company }}</td>
        </tr>
        <tr>
            <th style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ trans('general.phone') }}</th>
            <td style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ $vendor->phone }}</td>
        </tr>
        <tr>
            <th style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ trans('general.email') }}</th>
            <td style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ $vendor->email }}</td>
        </tr>
        <tr>
            <th style="border:1px solid lightgray;text-align: left;padding: 10px;">{{ trans('general.address') }}</th>
            <td style="border:1px solid lightgray;text-align: left;padding: 10px;">
                @if($vendor->city)
                    {{ ucwords($vendor->city) }},
                @endif
                @if($vendor->province)
                    {{ ucwords($vendor->province) }},
                @endif
                @if($vendor->country)
                    {{ ucwords($vendor->country) }}
                @endif
            </td>
        </tr>
    </table>
</main>
@include('emails.components.mail-footer')
