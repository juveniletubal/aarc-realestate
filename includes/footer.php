<?php $assets->renderJS(); ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            timeOut: "3000"
        };
    });
</script>

</body>

</html>