<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/boxicons.min.css" rel="stylesheet">
    <link href="/css/register.css" rel="stylesheet">
</head>
<body class="register-page">
<div class="container register-container bg-dark-50">

    <form id="registerUserForm" class="needs-validation" action="/register/store" method="POST" enctype="multipart/form-data" novalidate>

    <div class="row mb-1">
            <div class="p-3 border rounded bg-white">
            <a href="/login" class="btn btn-primary">Back</a> 
                <div class="row p-3">
                    <div class="col-md-12">
                        <div class="section-title mb-2">User Information</div>
                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstname" required>
                                <div class="invalid-feedback">Please enter a valid first name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastname" required>
                                <div class="invalid-feedback">Please enter a valid last name.</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Please provide a valid email.</div>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required minlength="6">
                                    <div class="invalid-feedback">Password must be at least 6 characters long.</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact" name="contact" pattern="\d{10,11}" required>
                                <div class="invalid-feedback">Please provide a valid contact number (10-11 digits).</div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row p-3">
                    <div class="section-title">Address Information</div>
                    <div class="col-md-4">
                        <label for="region" class="form-label">Region</label>
                        <input type="text" class="form-control" id="region" name="reg" required>
                        <div class="invalid-feedback">Please enter your region.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="province" class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" name="prov" required>
                        <div class="invalid-feedback">Please enter your province.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="municipality" class="form-label">Municipality</label>
                        <input type="text" class="form-control" id="municipality" name="citymun" required>
                        <div class="invalid-feedback">Please enter your municipality.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="barangay" class="form-label">Barangay</label>
                        <input type="text" class="form-control" id="barangay" name="brgy" required>
                        <div class="invalid-feedback">Please enter your barangay.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="zipcode" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" pattern="\d{4}" required>
                        <div class="invalid-feedback">Please enter a valid 4-digit zip code.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="placeDescription" class="form-label">Place Description</label>
                        <textarea class="form-control" id="placeDescription" name="place_desc" rows="2"></textarea>
                        <div class="invalid-feedback">Please enter a place description</div>
                    </div>
                </div>
                <div class="d-flex justify-content-end md-3">
                    <button type="submit" class="btn btn-success"><i class="bx bx-save"></i> Register User</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
</body>
</html>
