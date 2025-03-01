<body class="reg-body">
<div class="container-fluid container-sm register-container bg-dark-50">

    <form id="registerUserForm" class="needs-validation" action="/register/store" method="POST" enctype="multipart/form-data" novalidate>
    <div class="row mb-1">
            <div class="p-3 border rounded bg-white mx-2 my-2">
                <a href="/login" class="btn btn-primary btn-sm">Back</a> 
                <div class="row p-3">
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="section-title mb-2">User Information</div>
                        <div class="row mt-2">
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstname" required>
                                <div class="invalid-feedback">Please enter a valid first name.</div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastname" required>
                                <div class="invalid-feedback">Please enter a valid last name.</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <!-- Email -->
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Please provide a valid email.</div>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required minlength="6">
                                    <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact" name="contact" pattern="\d{10,11}" required>
                                <div class="invalid-feedback">Please provide a valid contact number (10-11 digits).</div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row p-3">
                    <div class="section-title">Address Information</div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <label for="region" class="form-label">Region</label>
                        <select class="form-control" id="region" name="region_id" required>
                            <option value="" selected disabled hidden>Select a Region</option>
                            <?php foreach ($refRegion as $region): ?>
                                <option value="<?= $region['regCode'] ?>"><?= $region['regDesc'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please enter your region.</div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <label for="province" class="form-label">Province</label>
                        <select class="form-control" id="province" name="province">
                            <option value="">Select a province</option>
                        </select>
                        <div class="invalid-feedback">Please enter your province.</div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <label for="municipality" class="form-label">Municipality</label>
                        <select class="form-control" id="citymun" name="citymun">
                            <option value="">Select a City/Municipality</option>
                        </select>
                        <div class="invalid-feedback">Please enter your municipality.</div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <label for="barangay" class="form-label">Barangay</label>
                        <select class="form-control" id="brgy" name="brgy">
                            <option value="">Select a Barangay</option>
                        </select>
                        <div class="invalid-feedback">Please enter your barangay.</div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <label for="zipcode" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" pattern="\d{4}" required>
                        <div class="invalid-feedback">Please enter a valid 4-digit zip code.</div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4">
                        <label for="placeDescription" class="form-label">Place Description</label>
                        <textarea class="form-control" id="placeDescription" name="place_desc" rows="2"></textarea>
                        <div class="invalid-feedback">Please enter a place description</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end md-3">
                    <button type="submit" class="btn btn-success btn-sm"><i class="bx bx-save"></i> Register User</button>
                </div>
            </div>
        </div>
    </form>
</div>
</body>


<script>
    $(document).ready(function() {
        $('#region').change(function() {
            var regionId = $(this).val();
            if (regionId !== '') {
                $.ajax({
                    type: 'POST',
                    url: '/get-provinces',
                    data: { region_id: regionId },
                    dataType: 'json',
                    success: function(response) {
                        $('#province').html('<option value="">Select a province</option>');
                        $.each(response, function(index, province) {
                            $('#province').append('<option value="'+ province.provCode +'">'+ province.provDesc +'</option>');
                        });
                    }
                });
            } else {
                $('#province').html('<option value="">Select a province</option>');
            }
        });
    });
   
    $(document).ready(function() {
        $('#province').change(function() {
            var provId = $(this).val();
            if (provId !== '') {
                $.ajax({
                    type: 'POST',
                    url: '/get-citymun',
                    data: { prov_id: provId },
                    dataType: 'json',
                    success: function(response) {
                        $('#citymun').html('<option value="">Select a City/Municipality</option>');
                        $.each(response, function(index, citymun) {
                            $('#citymun').append('<option value="'+ citymun.citymunCode +'">'+ citymun.citymunDesc +'</option>');
                        });
                    }
                });
            } else {
                $('#province').html('<option value="">Select a province</option>');
            }
        });
    });
    
    $(document).ready(function() {
        $('#citymun').change(function() {
            var citymunId = $(this).val();
            if (citymunId !== '') {
                $.ajax({
                    type: 'POST',
                    url: '/get-brgy',
                    data: { citymun_Id: citymunId },
                    dataType: 'json',
                    success: function(response) {
                        $('#brgy').html('<option value="">Select a Barangay</option>');
                        $.each(response, function(index, brgy) {
                            $('#brgy').append('<option value="'+ brgy.brgyCode +'">'+ brgy.brgyDesc +'</option>');
                        });
                    }
                });
            } else {
                $('#brgy').html('<option value="">Select a Barangay</option>');
            }
        });
    });

(function () {
  'use strict';
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
