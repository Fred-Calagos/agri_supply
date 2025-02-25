<div class="container">
    <!-- Navigation and Button Container -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/settings"><i class='bx bx-cog bread-icon'></i> Settings</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> Brand Management</li>
            </ol>
        </nav>

        <!-- Add Brand Button -->
        <button type="button" class="btn btn-primary" onclick="window.location.href='/brand/create'">
            <i class="bx bx-plus-circle"></i> Add Brand
        </button>

    </div>

    <!-- Message Container -->
    <div id="message-container"></div>

    <!-- Brand Table -->
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Brand Name</th>
                <th>Tagline</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Social Media</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($brands as $index => $brand): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $brand['brand_name'] ?></td>
                    <td><?= $brand['tagline'] ?></td>
                    <td><?= $brand['contact'] ?></td>
                    <td><?= $brand['email'] ?></td>
                    <td>
                        <a href="<?= $brand['facebook'] ?>" target="_blank">Facebook</a> |
                        <a href="<?= $brand['instagram'] ?>" target="_blank">Instagram</a>
                    </td>
                    <td>    
                        <button class="edit-brand btn btn-warning" href="/settings/brand_edit/<?= $brand['id'] ?>">
                            <i class="bx bxs-edit"></i> Edit
                        </button>
                        <button class="delete-brand btn btn-danger" 
                                data-id="<?= $brand['id'] ?>">
                            <i class="bx bxs-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal for Adding Brand -->
    <div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Increased modal size -->
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="brandModalLabel">Add Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="addBrandForm">
                        <!-- Group 1: Brand Logo -->
                        <div class="border p-3 rounded mb-4">
                            <h5 class="mb-3">Basic Logo</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3 text-center">
                                    <img src="/assets/images/placeholder-image.jpg" 
                                        class="img-fluid img-thumbnail mb-1" 
                                        id="productImagePreview" 
                                        alt="Product Image"
                                        style="width: 200px; height: 120px; object-fit: contain; border-radius: 10%; ">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="file" class="form-control" id="brandLogo" name="image" accept="image/*" onchange="previewImage(event)">
                                </div>
                            </div>
                        </div>
                        <!-- Group 2: Basic Information -->
                        <div class="border p-3 rounded mb-4">
                            <h5 class="mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="brandName" class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" id="brandName" name="brand_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tagline" class="form-label">Tagline</label>
                                    <input type="text" class="form-control" id="tagline" name="tagline">
                                </div>
                                <div class="col-12">
                                    <label for="about" class="form-label">About</label>
                                    <textarea class="form-control" id="about" name="about" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Group 3: Contact Information -->
                        <div class="border p-3 rounded mb-4">
                            <h5 class="mb-3">Contact Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="contact" name="contact">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                        </div>

                        <!-- Group 4: Social Media Links -->
                        <div class="border p-3 rounded">
                            <h5 class="mb-3">Social Media Links</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="url" class="form-control" id="facebook" name="facebook">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="url" class="form-control" id="instagram" name="instagram">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="saveBrand">
                        <i class="bx bx-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    // Save brand on button click
    $("#saveBrand").click(function () {
        saveBrand();
    });

    // Save brand on Enter key press inside the form
    $("#addBrandForm").keypress(function (event) {
        if (event.which === 13) {  // 13 = Enter key
            event.preventDefault(); // Prevent form submission
            saveBrand();
        }
    });

    function saveBrand() {
        $('#brandModal').modal('hide'); // Close modal before submitting

        $.ajax({
            type: "POST",
            url: "/brand/store",
            data: $("#addBrandForm").serialize(),
            success: function (response) {
                var message = $('<div class="alert alert-success">Brand Added Successfully!</div>');

                $('#message-container').html('').append(message);

                setTimeout(function () {
                    message.fadeOut();
                    location.reload();
                }, 2000);
            },
            error: function () {
                var message = $('<div class="alert alert-danger">Error adding Brand. Please try again.</div>');

                $('#message-container').html('').append(message);

                setTimeout(function () {
                    message.fadeOut();
                }, 2000);
            }
        });
    }
});
    // Preview Image
    function previewImage(event) {
        const imagePreview = document.getElementById('productImagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "https://via.placeholder.com/150"; // Reset to default if no file selected
        }
    }
</script>