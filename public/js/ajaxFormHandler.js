function handleAjaxForm({
    formId,
    messageContainerId,
    postUrl,
    successMessage = 'Successfully submitted!',
    successTimeout = 2000,
    errorTimeout = 3000,
    reloadOnSuccess = true,
    onSuccessCallback = null
}) {
    $(formId).on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: postUrl,
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                $(messageContainerId).html('');

                if (response.status === "success") {
                    var message = $('<div class="alert alert-success">' + successMessage + '</div>');
                    $(messageContainerId).append(message);

                    $(formId)[0].reset();

                    setTimeout(function () {
                        message.fadeOut();
                        if (onSuccessCallback) {
                            onSuccessCallback(response);
                        }
                        if (reloadOnSuccess) {
                            location.reload();
                        }
                    }, successTimeout);
                } else if (response.status === "error") {
                    var message = $('<div class="alert alert-danger">' + response.message + '</div>');
                    $(messageContainerId).append(message);

                    setTimeout(function () {
                        message.fadeOut();
                    }, errorTimeout);
                }
            },
            error: function () {
                var message = $('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                $(messageContainerId).html('').append(message);

                setTimeout(function () {
                    message.fadeOut();
                }, errorTimeout);
            }
        });
    });
}


function handleEditModalForm({
    triggerSelector,
    modalId,
    formId,
    saveButtonId,
    messageContainerId,
    postUrlBase,
    successMessage = 'Successfully updated!',
    successTimeout = 2000,
    errorTimeout = 2000,
    reloadOnSuccess = true,
    onSuccessCallback = null,
    fieldMappings = []
}) {
    // Open modal and populate fields
    $(document).on('click', triggerSelector, function () {
        const data = $(this).data();
        fieldMappings.forEach(mapping => {
            $(`#${mapping.fieldId}`).val(data[mapping.dataKey]);
        });
        $(modalId).modal('show');
    });

    // Handle save button click
    $(saveButtonId).click(function (e) {
        e.preventDefault();

        const itemId = $(`${formId} [name="id"]`).val();
        const postUrl = `${postUrlBase}/${itemId}`;

        $.ajax({
            type: "POST",
            url: postUrl,
            data: $(formId).serialize(),
            dataType: "json",
            success: function (response) {
                $(messageContainerId).html('');

                if (response.status === "success") {
                    var message = $('<div class="alert alert-success">' + successMessage + '</div>');
                    $(messageContainerId).append(message);

                    $(modalId).modal('hide');

                    setTimeout(function () {
                        message.fadeOut();
                        if (onSuccessCallback) {
                            onSuccessCallback(response);
                        }
                        if (reloadOnSuccess) {
                            location.reload();
                        }
                    }, successTimeout);
                } else {
                    var message = $('<div class="alert alert-danger">Error: ' + response.message + '</div>');
                    $(messageContainerId).append(message);

                    setTimeout(function () {
                        message.fadeOut();
                    }, errorTimeout);
                }
            },
            error: function () {
                var message = $('<div class="alert alert-danger">Error updating. Please try again.</div>');
                $(messageContainerId).html('').append(message);

                setTimeout(function () {
                    message.fadeOut();
                }, errorTimeout);
            }
        });
    });
}
