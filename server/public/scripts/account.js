$(function () {
    // jQuery validation.
    $("#loginForm").validate(
        {
            rules: {
                identity: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
            },
            errorElement: "div",
            errorClass: 'invalid-feedback'
        }
    );

    window.addEventListener('load', function () {
        var form = document.getElementById('loginForm');
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    }, false);
});