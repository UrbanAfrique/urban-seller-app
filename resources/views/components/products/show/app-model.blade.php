<div class="modal fade" id="show-product-image-{{$modelId}}" data-bs-backdrop="static"
     data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-transparent border-0">
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img src="{{ $modelSrc }}" alt="{{ $modelId }}" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>
