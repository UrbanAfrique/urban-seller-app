
@if($vendor->approved==\App\Enum\ApprovedStatusEnum::APPROVED)
    <a class="btn btn-sm btn-info"
       href="{{ route('app.vendors.show',[$vendor->id,'shop'=>\App\Services\SellerService::getSellerDomain(),'timestamp'=>time()]) }}">
        <i class="fa fa-eye"></i>
    </a>
@else
    <a class="btn btn-sm btn-success"
       onclick="productGenerator.manageVendorApproval(this,'{{route('approve.vendor',['shop'=>\App\Services\SellerService::getSellerDomain()])}}','{{$vendor->id}}','{{\App\Enum\ApprovedStatusEnum::APPROVED}}');"
       data-bs-toggle="tooltip"
       title="{{ \App\Enum\ApprovedStatusEnum::getTranslationKeyBy(\App\Enum\ApprovedStatusEnum::APPROVED) }}">
        <i class="fa fa-check"></i>
    </a>
    <a class="btn btn-sm btn-danger"
       onclick="productGenerator.manageVendorApproval(this,'{{route('approve.vendor',['shop'=>\App\Services\SellerService::getSellerDomain()])}}','{{$vendor->id}}','{{\App\Enum\ApprovedStatusEnum::REJECTED}}');"
       data-bs-toggle="tooltip"
       title="{{ \App\Enum\ApprovedStatusEnum::getTranslationKeyBy(\App\Enum\ApprovedStatusEnum::REJECTED) }}">
        <i class="fa fa-times"></i>
    </a>
@endif

@if(!empty($vendor->approved))
    <a class="btn p-0 mx-2" onclick="productGenerator.deleteVendor(this, '{{ route('app.vendors.destroy', [$vendor->id,'shop'=>\App\Services\SellerService::getSellerDomain(),'timestamp'=>time()]) }}');">
        <i class="fa fa-trash"></i>
    </a>
@endif
