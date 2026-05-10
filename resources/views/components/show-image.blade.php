<img src="{{ $src }}"
    alt="{{ $alt ?? 'Image' }}"
    class="{{ $class ?? '' }}"
    width="{{ $width ?? '' }}"
    height="{{ $height ?? '' }}"
    style="object-fit:cover; cursor:pointer; {{ $style ?? '' }}"
    data-bs-toggle="modal"
    data-bs-target="#imageModal"
    onclick="showImage(this.src)"
    loading="lazy">

@push('modals')

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Preview">
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        function showImage(url) {
            document.getElementById('modalImage').src = url;
        }
    </script>
@endpush