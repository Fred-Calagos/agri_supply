<div class="container-fluid mt-4 bg-dark-40">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/brands"><i class='bx bx-store-alt bread-icon'></i> Brands</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Brand</li>
            </ol>
        </nav>
    </div>
    <form id="addBrandForm" action="/brand/store" method="POST" enctype="multipart/form-data">
        <div class="row mb-1">
            <div class="p-3 border rounded bg-white">
                <div class="row p-3">
                    <div class="col-md-3 text-center">
                        <div class="section-title mb-1">Brand Logo</div>
                        <img src="/assets/images/placeholder-image.jpg" 
                             class="img-fluid img-thumbnail mb-1" 
                             id="brandLogoPreview" 
                             alt="Brand Logo"
                             style="width: 200px; height: 200px; object-fit: contain;">
                        <input type="file" class="form-control" id="brandLogo" name="logo" accept="image/*" onchange="previewLogo(event)">
                    </div>
                    <div class="col-md-9">
                        <div class="section-title mb-2">Brand Details</div>
                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label for="brandName" class="form-label">Brand Name</label>
                                <input type="text" class="form-control" id="brandName" name="brand_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="brandTagLine" class="form-label">Tag Line</label>
                                <textarea class="form-control" id="brandTagLine" name="tagline" rows="1" required></textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="brandDescription" class="form-label">About the Brand</label>
                            <textarea class="form-control" id="brandDescription" name="about" rows="2" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row p-3">
                <div class="section-title">Contact Information</div>
                    <div class="col-md-6">
                        <label for="contactNo">Contact no.</label>
                        <input type="number" class="form-control" id="contactNo" name="contact" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="row p-3">
                <div class="section-title">Social Media</div>
                    <div class="col-md-6">
                        <label for="facebook">Facebook</label>
                        <input type="url" class="form-control" id="facebook" name="facebook">
                    </div>
                    <div class="col-md-6">
                        <label for="instagram">Instagram</label>
                        <input type="url" class="form-control" id="instagram" name="instagram">
                    </div>
                    <!-- <div class="col-md-4">
                        <label for="tiktok">Tiktok</label>
                        <input type="url" class="form-control" id="tiktok" name="tiktok">
                    </div> -->
                </div>
                <div class="d-flex justify-content-between md-3">
                    <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="bx bx-save"></i> Save Brand</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewLogo(event) {
        const logoPreview = document.getElementById('brandLogoPreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                logoPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            logoPreview.src = "/assets/images/placeholder-image.jpg";
        }
    }
</script>
