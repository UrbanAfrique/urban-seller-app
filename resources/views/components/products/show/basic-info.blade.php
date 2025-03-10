<section>
    <article>
        <h1 class="@if($type=='app') mb-0 fw-bold @else w3-fw-bold @endif">
            {!! ucfirst($product->title) !!}
        </h1>
        {!! \App\Services\ProductService::getStatusBtn($product,$type) !!}
    </article>
    @include('components.products.show.status-type',['type'=>$type])
    <article style="margin-top:20px;margin-bottom:20px;">
        {!! $product->body_html !!}
    </article>
</section>
