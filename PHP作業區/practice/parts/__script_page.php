<script src="./jquery-3.5.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.js"></script>
<script>
    function checkCheckBox() {
        document.querySelectorAll('[name=skill\\[\\]]').forEach((item) => {
            console.log(item.value, item.checked);
        })
    }
</script>