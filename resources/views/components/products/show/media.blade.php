<div class="zoom-gallery @if($type=='proxy') w3-row-padding @else row p-2 @endif">
    @if(is_array($product->shopify_images) AND count($product->shopify_images)>0)
        @php
            $firstElement = $product->shopify_images[0];
            $elementsAfterFour = array_slice($product->shopify_images,1);
        @endphp
        {{-- First Element --}}
        @if(count($firstElement)>0)
            <div class="@if($type=='app') col-12 pb-3 @else w3-col s12 @endif">
                <a href="{{ $firstElement['src']??asset('images/no_avatar.png') }}" data-source="{{ $firstElement['src']??asset('images/no_avatar.png') }}"
                   title="{{ $firstElement['id']??'' }}">
                    <img src="{{ $firstElement['src']??asset('images/no_avatar.png') }}" alt="{{ $firstElement['id']??'' }}"
                         style="width: 100%;border-radius: 8px;">
                </a>
            </div>
        @endif
        @if(count($elementsAfterFour)>0)
            @foreach($elementsAfterFour as $elementsAfterF)
                <div class="@if($type=='app') col-3 pb-3 @else w3-col s3 @endif">
                    <a href="{{ $elementsAfterF['src']??asset('images/no_avatar.png') }}" data-source="{{ $elementsAfterF['src']??asset('images/no_avatar.png') }}"
                       title="{{ $elementsAfterF['id']??'' }}">
                        <img src="{{ $elementsAfterF['src']??asset('images/no_avatar.png') }}" alt="{{ $elementsAfterF['id']??'' }}"
                             style="width: 100%;height:100px;border-radius: 8px;">
                    </a>
                </div>
            @endforeach
        @endif
    @endif
</div>
<br>
