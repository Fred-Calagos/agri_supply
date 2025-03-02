<div class="container-fluid container-sm register-container bg-dark-50">
    <div class="row mb-1">
        <div class="p-3 border rounded bg-white mx-2 my-2">
            <div class="row p-3">
                <div class="col-12 col-sm-12 col-md-12">
                    <div class="section-title mb-2">Account Information</div>
                    <div class="row mt-2">
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstname" value="<?= htmlspecialchars($userAccount['firstname'])?>" readonly>
                                
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastname" value="<?= htmlspecialchars($userAccount['lastname'])?>" readonly>
                                
                                </div>
                    </div>
                    <div class="row mt-2">
                                <!-- Email -->
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userAccount['email'])?>" readonly>
                                    
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-phone'></i> <!-- Boxicon contact icon -->
                                        </span>
                                        <input type="text" class="form-control" id="contact" name="contact" pattern="\d{10,11}" value="<?= htmlspecialchars($userAccount['contact'])?>" readonly>
                                    </div>
                                </div>
                    </div>

                </div>
            </div>
            <div class="row p-3">
                <div class="section-title">Address Information</div>

                <div class="col-12 col-sm-12 col-md-4">
                    <label for="region" class="form-label">Region</label>
                    <input type="text" class="form-control" id="region" name="region_id" value="<?= htmlspecialchars($userAccount['regDesc'])?>" readonly>
                </div>

                <div class="col-12 col-sm-12 col-md-4">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province" value="<?= htmlspecialchars($userAccount['provDesc'])?>"  readonly>
               
                </div>

                <div class="col-12 col-sm-12 col-md-4">
                    <label for="citymun" class="form-label">Municipality</label>
                    <input type="text" class="form-control" id="citymun" name="citymun" value="<?= htmlspecialchars($userAccount['citymunDesc'])?>" readonly>
   
                </div>

                <div class="col-12 col-sm-12 col-md-4">
                    <label for="brgy" class="form-label">Barangay</label>
                    <input type="text" class="form-control" id="brgy" name="brgy" value="<?= htmlspecialchars($userAccount['brgyDesc'])?>" readonly>
         
                </div>

                <div class="col-12 col-sm-12 col-md-4">
                    <label for="zipcode" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" id="zipcode" name="zipcode" pattern="\d{4}" value="<?= htmlspecialchars($userAccount['zipcode'])?>" readonly>
           
                </div>

                <div class="col-12 col-sm-12 col-md-4">
                    <label for="placeDescription" class="form-label">Place Description</label>
                    <textarea class="form-control" id="placeDescription" name="place_desc" rows="2" readonly><?= htmlspecialchars($userAccount['place_desc'])?></textarea>
   
                </div>
            </div>

        </div>
    </div>

</div>