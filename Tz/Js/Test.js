function Close(kick = true) {
    if (kick) {
        if (confirm("آیا میخواهید از آزمون خارج شوید در این صورت امکان برگشت وجود ندارد.")) {
            window.location.href = '../index.php';
        }
        else {

        }
    }
    else{
        window.location.href = '../index.php';
    }

}
function return_report() {
    window.location.href = 'Reports.php';
}