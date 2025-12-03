<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        @include('partial.account.change-ward-password')
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script>
        function hideSuccessAlert() {
            // your custom javascript
            const alert = document.getElementById('success-alert');
            if (alert){
                alert.style.display = 'none';
            }
        }

        function initPageScripts() {

            setTimeout(hideSuccessAlert, 3000);

        }
        document.addEventListener('DOMContentLoaded', initPageScripts);


        // Ẩn thông báo lỗi của một input cụ thể
        // function hideValidationError(event) {
        //     const formGroup = event.target.closest('.form-group');
        //     if (formGroup) {
        //         const errorSpan = formGroup.querySelector('span.text-danger');
        //         if (errorSpan) {
        //             errorSpan.style.display = 'none';
        //         }
        //     }
        // }

        function hideValidationError(event) {
            let errorSpan = event.target.parentNode.querySelector('span.text-danger');

            if (errorSpan) {
                errorSpan.style.display = 'none'; // hoặc visibility: hidden
            }
        }


        function setupValidationClearEvents() {
            const fields = document.querySelectorAll('input, select');

            fields.forEach(function (field) {
                // Ẩn lỗi khi input thay đổi hoặc focus
                if (field.tagName.toLowerCase() === 'select') {
                    field.addEventListener('change', hideValidationError);
                    field.addEventListener('focus', hideValidationError);  // thêm focus
                } else {
                    field.addEventListener('input', hideValidationError);
                    field.addEventListener('focus', hideValidationError);  // thêm focus
                }
            });
        }

        document.addEventListener('DOMContentLoaded', setupValidationClearEvents);

        function enableRadioUncheck(radioSelector) {
            document.querySelectorAll(radioSelector).forEach(function(radio) {
                radio.addEventListener('mousedown', function(e) {
                    if (radio.checked) {
                        radio.wasChecked = true;
                    } else {
                        radio.wasChecked = false;
                    }
                });

                radio.addEventListener('click', function(e) {
                    if (radio.wasChecked) {
                        radio.checked = false;
                        radio.wasChecked = false;
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
	        enableRadioUncheck('input[name="gender"]');
        });
    </script>

</body>

</html>