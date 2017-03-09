
var pusher = new Pusher('f076e90cb0d62f9ccf4b', {
    encrypted: true
});

var channel = pusher.subscribe('order-updates');

pusher.connection.bind('connected', function() {
    $.ajaxSetup({
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-Socket-ID', pusher.connection.socket_id);
        }
    });
});

channel.bind('order-created', function(data) {
    if((filters = getActiveFilters()).length == 0 || filters.indexOf(data.status) !== -1){
        refreshOrderList();
    }
});

channel.bind('order-updated', function(data) {
    var view_order_modal = $("#view-order-modal");

    if((filters = getActiveFilters()).length == 0 || filters.indexOf(data.old_status) !== -1 || filters.indexOf(data.new_status) !== -1){
        refreshOrderList();
    }
    if(view_order_modal.data('bs.modal').isShown && view_order_modal.find("input[name=id]").val() == data.id){
        view_order_modal.find(".modal-header span.user-updated").text(data.user);
        view_order_modal.find(".modal-header").addClass("updated");
    }
});
