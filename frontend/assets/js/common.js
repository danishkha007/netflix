$(function(){
    let path=window.location.href;
    $('.sidebar-menu li a').each(function(){
        if(this.href===path){
            $(this).parent().addClass('active');
        }
    })
})
$(function () {
    $('#myTable').DataTable()
});
$(function () {
    $('#entityTable').DataTable({
        "order":[[0,"asc"]]
    })
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
