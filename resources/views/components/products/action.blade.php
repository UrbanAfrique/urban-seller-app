@php
    $productId = $product->id;
    $sellerDomain = \App\Services\SellerService::getSellerDomain();
    $listType = $listType?? 'proxy';
    $editClass = ($listType == 'proxy') ? 'w3-btn w3-blue w3-tiny' : 'btn btn-sm btn-info';
    $showClass = ($listType == 'proxy') ? 'w3-btn w3-green w3-tiny' : 'btn btn-sm btn-success';
    $dangerClass = ($listType == 'proxy') ? 'w3-btn w3-red w3-tiny' : 'btn btn-sm btn-danger';
    // Using the ternary operator to conditionally set editAction and showAction
    $editAction = ($listType == 'proxy') ? '/a/seller/products/' . $productId."/edit" : route('app.products.edit', [$productId, 'shop' => $sellerDomain,'timestamp'=>time()]);
    $showAction = ($listType == 'proxy') ? '/a/seller/products/' . $productId : route('app.products.show', [$productId, 'shop' => $sellerDomain,'timestamp'=>time()]);
@endphp
<a
    @if($listType=='app')
        data-bs-toggle="tooltip" title="Show Product"
    @endif
    class="{{ $showClass }}"
    href="{{ $showAction }}">
    <i class="fa fa-eye"></i>
</a>
<a
    @if($listType=='app')
        data-bs-toggle="tooltip" title="Edit Product"
    @endif
    class="{{ $editClass }}"
    href="{{ $editAction }}">
    <i class="fa fa-edit"></i>
</a>
@if($listType == 'app' AND  $product->approved==\App\Enum\ApprovedStatusEnum::PENDING)
    <a class="{{$showClass}}"
       onclick="productGenerator.manageProductApproval(this,'{{route('approve.product',['shop'=>\App\Services\SellerService::getSellerDomain()])}}','{{$productId}}','{{\App\Enum\ApprovedStatusEnum::APPROVED}}');"
       data-bs-toggle="tooltip"
       title="{{ \App\Enum\ApprovedStatusEnum::getTranslationKeyBy(\App\Enum\ApprovedStatusEnum::APPROVED) }}">
        <i class="fa fa-check"></i>
    </a>
    <a class="{{$dangerClass}}"
       onclick="productGenerator.manageProductApproval(this,'{{route('approve.product',['shop'=>\App\Services\SellerService::getSellerDomain()])}}','{{$productId}}','{{\App\Enum\ApprovedStatusEnum::REJECTED}}');"
       data-bs-toggle="tooltip"
       title="{{ \App\Enum\ApprovedStatusEnum::getTranslationKeyBy(\App\Enum\ApprovedStatusEnum::REJECTED) }}">
        <i class="fa fa-times"></i>
    </a>
@endif
{{--<a @if($listType=='app') data-bs-toggle="tooltip" title="Delete Product" @endif class="{{ $dangerClass }}"
   onclick="productGenerator.deleteProduct(this, '{{ route('products.delete',$productId) }}');">
    <i class="fa fa-trash"></i>
</a>--}}
