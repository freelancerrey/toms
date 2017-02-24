var attachFormXHR, createOrderXHR;

$(document).ready(function() {

    $('#new-order-modal').on('show.bs.modal', function () {
        var modal_content = $(this).find(".modal-content");
        clearAllCreateField(modal_content);
        modal_content.find("ul.nav-tabs li a:first").tab('show');
    });

    $('#create-order-reference').bootcomplete({
        url :'ajax/payment/autolist'
    });

    $('#create-order-paydate').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm:ss'
    });

    $("ul.form-type-list li").on('click', function(e){
        formtypedisplay = $(this).parents("div.input-group-btn").find('.form-type-display').text($(this).text())[0];
        formtypedisplay.dataset.entryprefix = this.dataset.prefix;
    });

    $("button.attach-form-button").on('click',function(e){
        getFormDetai(this);
    });

    $("input.form-id-input").keypress(function(e) {
        if (e.which == "13") {
            getFormDetai($(this).next().find('button.attach-form-button')[0]);
        }
    });

    $("button.remove-attached-form").on('click', function(e){
        tabpane = $(this).parents('div.tab-pane');
        tabpane.find("input[name]").val("");
        tabpane.find('table tr:not(:eq(5)) td').text("");
    });

    $("#create-order-button").on('click', function(e){

        var modal_content = $(this).parents(".modal-content");
        var request_data = {'_token': window.Laravel.csrfToken };
        var thisbutton = this;

        modal_content.find("[name]").each(function(index) {
            request_data[this.name] = (this.type === 'checkbox')? ((this.checked)? 1:0):$(this).val();
            this.disabled = true;
        });

        clearAllErrors(modal_content);
        $(thisbutton).parent().find('button').prop('disabled', true);
        $("#create-order button, #create-order input").prop('disabled', true);

        createOrderXHR = $.ajax({
            url: "ajax/order/create",
            dataType: "json",
            accepts: "application/json; charset=utf-8",
            type : "POST",
            data : request_data,
            success : function(data) {
                if(data.hasOwnProperty('id')){
                    $('#new-order-modal').modal('hide');
                    displayAlertMessage('success', 'Success!', "Order has been created");
                } else {
                    displayAlertMessage('danger', 'Error!', "Something's not right");
                }
            },
            complete : function(response){
                modal_content.find("[name]").prop('disabled', false);
                $("#create-order button, #create-order input").prop('disabled', false);
                $(thisbutton).parent().find('button').prop('disabled', false);
            },
            statusCode: {
                400: function(response) {
                    for(fieldname in response.responseJSON){
                        var error_element = modal_content.find("[data-errorfor="+fieldname.replace('.','-')+"]");
                        error_element.addClass('has-error');
                        error_element.tooltip({'title': response.responseJSON[fieldname][0].replace('.',' '), 'placement': 'left'});
                    }
                    modal_content.find("[data-errorfor]:visible").tooltip('show');
                    modal_content.find("div.tab-content div.tab-pane:has(.has-error:not(.attach-form-btngroup))").each(function(index){
                        modal_content.find("ul.nav-tabs li:has(a[aria-controls="+this.id+"])").addClass("hilight-error");
                    });
                },
                500: function(response) {
                    displayAlertMessage('danger', 'Error!', "Something's not right");
                }
            }
        });

    });

    $("#create-clear-button").on('click', function(e){
        var modal_content = $(this).parents(".modal-content");
        clearAllCreateField(modal_content);
    });

    $("div.pagination-wrapper button.pag-first-btn").on('click', function(e){
        loadOrderList($(this).siblings("select.show-pages-select").find("option:first").val());
    });

    $("div.pagination-wrapper button.pag-prev-btn").on('click', function(e){
        loadOrderList($(this).siblings("select.show-pages-select").find("option:selected").prev().val());
    });

    $("div.pagination-wrapper button.pag-next-btn").on('click', function(e){
        loadOrderList($(this).siblings("select.show-pages-select").find("option:selected").next().val());
    });

    $("div.pagination-wrapper button.pag-last-btn").on('click', function(e){
        loadOrderList($(this).siblings("select.show-pages-select").find("option:last").val());
    });

    $("div.pagination-wrapper select.show-pages-select").on('change', function(e){
        loadOrderList($(this).find("option:selected").val());
    });

    document.querySelector("div.mytable-wrapper thead tr").onclick = function(e){

        if ($("div.mytable-wrapper").is(":not(.empty,.initializing)")) {

            var originalElement = e.srcElement || e.originalTarget,
                columnTh = $(originalElement).closest('th');

            if (columnTh.is(".sorter")) {
                if (columnTh.is('[data-direction=asc]')) {
                    columnTh[0].dataset.direction = 'desc';
                } else {
                    columnTh.removeClass('sorter').removeAttr('data-direction');
                }
            } else {
                $("div.mytable-wrapper thead tr th").removeClass('sorter').removeAttr('data-direction');
                columnTh.addClass('sorter')[0].dataset.direction = 'asc';
            }

            loadOrderList();

        }

    };

    $(".update-filter-btn").on('click', function(e){
        filterOrderList();
    });

    $(".clear-filter-btn").on('click', function(e){
        var filterCheckBoxes = document.querySelectorAll("#collapseFilters .well input");
        for (i in filterCheckBoxes) {
            filterCheckBoxes[i].checked = false;
        }
        filterOrderList();
    });

    document.querySelector("#collapseFilters .well").onchange = function(e){
        var originalElement = e.srcElement || e.originalTarget;
            jSourceElement = $(originalElement),
            parentDiv = jSourceElement.closest('div');

        if (jSourceElement.is('input[value]')) {
            parentDiv[0].querySelector('label.status-head input').checked = parentDiv.find('input[value]').length == parentDiv.find('input[value]:checked').length;
        } else {
            var filterCheckBoxes = parentDiv[0].querySelectorAll('input[value]');
            for (i in filterCheckBoxes) {
                filterCheckBoxes[i].checked = originalElement.checked;
            }
        }

    };

    $("#collapseFilters .well").keypress(function(e) {
        if (e.which == "13") {
            $(".update-filter-btn").click();
        }
    });

    loadOrderList();

});


function getFormDetai(caller){

    tabpane = $(caller).parents('div.tab-pane');

    requestdata = {
        "code": tabpane.find('button.form-type-display')[0].dataset.entryprefix,
        "id": tabpane.find('input.form-id-input').val().trim()
    }

    tabpane.addClass('loading');
    tabpane.find('button').prop('disabled', true);
    tabpane.find('input').prop('disabled', true);
    tabpane.find('div.attach-form-btngroup').removeClass('has-error').removeAttr('data-toggle title data-original-title').tooltip('destroy');

    attachFormXHR = $.ajax({
        url: "ajax/form/apicallurl",
        dataType: "json",
        accepts: "application/json; charset=utf-8",
        type : "GET",
        data : requestdata,
        success : function(data) {
            if (data.hasOwnProperty('form_id') && formsMappings.hasOwnProperty(data.form_id)){

                var entryTable = tabpane.find('table');

                var entryId = requestdata.code+data.id;
                tabpane.find("input[name=order\\[entry\\]]").val(entryId);
                entryTable.find('tr:eq(0) td').text(entryId);

                tabpane.find("input[name=order\\[type\\]]").val(formsMappings[data.form_id][0]);
                entryTable.find('tr:eq(1) td').text(orderTypes[formsMappings[data.form_id][0]]);

                var name = data[formsMappings[data.form_id][1][0]]+" "+data[formsMappings[data.form_id][1][1]];
                tabpane.find("input[name=order\\[name\\]]").val(name);
                entryTable.find('tr:eq(2) td').text(name);

                var email = data[formsMappings[data.form_id][1][2]];
                tabpane.find("input[name=order\\[email\\]]").val(email);
                entryTable.find('tr:eq(3) td').text(email);

                var paypal_name = data[formsMappings[data.form_id][1][3]];
                tabpane.find("input[name=order\\[paypal_name\\]]").val(paypal_name);
                entryTable.find('tr:eq(4) td').text(paypal_name);

                tabpane.find("input[name=order\\[clicks\\]]").val(parseInt(data[formsMappings[data.form_id][1][4]]));

                tabpane.find("input[name=order\\[date_submitted\\]]").val(data.date_created);
                entryTable.find('tr:eq(6) td').text(data.date_created);

                removeLoadingAndEnableFields();

            } else {
                renderFormAttachError('Entry/Form ID Invalid or Not Found!');
            }
        },
        complete : function(response){
            if(response.status != 200){
                removeLoadingAndEnableFields();
            }
        },
        statusCode: {
            500: function(response) {
                renderFormAttachError('Ooops! Server Error, Something went wrong!');
                console.log(response.responseJSON);
            },
            400: function(response) {
                renderFormAttachError(response.responseJSON.id[0]);
                console.log(response.responseJSON);
            }
        }

    });

    function renderFormAttachError(message){
        var errorbtngroup = tabpane.find('div.attach-form-btngroup');
        errorbtngroup.addClass('has-error');
        errorbtngroup.tooltip({'title': message});
        errorbtngroup.tooltip('show');
    }

    function removeLoadingAndEnableFields(){
        tabpane.removeClass('loading');
        tabpane.find('button').prop('disabled', false);
        tabpane.find('input').prop('disabled', false);
    }

}

function clearAllErrors(modal_content){
    modal_content.find("ul.nav-tabs li").removeClass("hilight-error");
    modal_content.find("[data-errorfor],.attach-form-btngroup").removeClass('has-error').removeAttr('data-toggle title data-original-title').tooltip('destroy');
}

function clearAllCreateField(modal_content){
    modal_content.find("[name],.form-id-input").each(function(index) {
        if(this.nodeName === "INPUT"){
            if(this.type === "checkbox"){
                this.checked = false;
            } else {
                this.value = "";
            }
        } else if (this.nodeName === "TEXTAREA") {
            this.value = "";
        } else if (this.nodeName === "SELECT") {
            $(this).find("option:eq(0)").prop("selected", true);
        }
    });
    modal_content.find('button.remove-attached-form').click();
    clearAllErrors(modal_content);
}

function displayAlertMessage(type, status, message){
    var alert = $("#alert-message");

    alert.find('.alert').removeClass("alert-success alert-info alert-warning alert-danger").addClass("alert-"+type);
    alert.find("strong.status").text(status);
    alert.find("span.message").text(message);

    alert.fadeIn(600);
    setTimeout(function(){ alert.fadeOut(600); }, 5000);
}

function refreshOrderList(){
    loadOrderList($("div.pagination-wrapper select option:selected").val());
}

function loadOrderList(page = 1) {
    $("div.pagination-wrapper").find("select,button").prop('disabled', true);
    $("div.mytable-wrapper").addClass("loading");
    // disable upper button here, don't forget please

    request_data = { 'page': page };

    sorterTh = $("div.mytable-wrapper thead th.sorter");
    if (sorterTh.length) {
        request_data['sort[index]'] = sorterTh.index();
        request_data['sort[direction]'] = sorterTh[0].dataset.direction;
    }

    if((filters = getActiveFilters()).length){
        request_data['filters'] = filters;
    }

    $.ajax({
        url: "ajax/order/list",
        dataType: "json",
        accepts: "application/json; charset=utf-8",
        type : "GET",
        data : request_data,
        success : function(response) {
            renderTableData(response);
        },
        complete : function(data) {
            //enable buttons and fields here, don't forget please
        },
        statusCode: {
            400: function(response) {
                validationResponse = response.responseJSON;
                renderEmptyTable();
                displayAlertMessage('danger', 'Error!', validationResponse[Object.keys(validationResponse)[0]][0]);
            },
            500: function(response) {
                renderEmptyTable();
                displayAlertMessage('danger', 'Error!', "Something's not right");
            }
        }

    });
}

function renderTableData(response){

    tbody_data = generateOrderTrs(response.data);

    $("div.mytable-wrapper").removeClass("empty initializing");
    if(response.data.length == 0){
        $("div.mytable-wrapper").addClass("empty");
    }

    $("div.mytable-wrapper tbody").html(tbody_data);

    $("div.mytable-wrapper").removeClass("loading");
    updatePaginator(response);

}

function generateOrderTrs(orders){

    var ordersHtml = "";

    for(i in orders){
        var order = orders[i];
        badgeHtml = (order.priority > 0)? "<span class='badge'>"+order.priority+"</span>":"";
        ordersHtml += "<tr><th scope='row' class='text-center'>"+order.id+"</th> <td>"+order.payment_name+"</td><td class='text-center'>\
                      "+moment(order.payment_date).format('L')+"</td> <td class='text-center'>"+emptyIfNull(order.type)+"</td>\
                       <td>"+emptyIfNull(order.name)+"</td> <td class='text-center'>"+emptyIfNull(order.clicks)+"</td>\
                       <td class='text-center'>"+dateIfNotNull(order.date_submitted)+"</td><td class='text-center'>"+badgeHtml+"</td>\
                       <td class='status-cell'><span class='order-status "+order.status_category.toLowerCase()+"'>\
                       "+order.status_category.toUpperCase()+" - "+order.status+"</span></td></tr>";
    }

    return ordersHtml;

}


function updatePaginator(pagination_data){

    var page_options = generatePageOptions(pagination_data);

    $("select.show-pages-select").html(page_options);

    if(pagination_data.last_page > 1){
        $("select.show-pages-select").prop('disabled', false);
    }
    if(pagination_data.current_page > 1){
        $("div.pagination-wrapper button.pag-first-btn, div.pagination-wrapper button.pag-prev-btn").prop('disabled', false);
    }
    if(pagination_data.current_page < pagination_data.last_page){
        $("div.pagination-wrapper button.pag-next-btn, div.pagination-wrapper button.pag-last-btn").prop('disabled', false);
    }

}

function generatePageOptions(pagination_data){
    var optionsHtml = "";

    for (var i = 1; i<=pagination_data.last_page; i++ ) {
        var from = ((i-1)*pagination_data.per_page)+1,
              to = (i==pagination_data.last_page)? pagination_data.total:(i*pagination_data.per_page);

        optionsHtml += "<option value='"+i+"' "+((i==pagination_data.current_page)? "selected":"")+">Page "+i+"&nbsp;&nbsp;\
                        |&nbsp;&nbsp;"+from+" to "+to+" of "+pagination_data.total+"</option>";
    }

    return optionsHtml;
}

function renderEmptyTable(){
    var empty_fake_date = {
        data: [],
        last_page: 0,
        current_page: 0
    }
    renderTableData(empty_fake_date);
}

function filterOrderList(){
    updateFilters();
    $("div.mytable-wrapper thead tr th").removeClass('sorter').removeAttr('data-direction');
    loadOrderList();
    /*setTimeout(function(){
        $("#collapseFilters").collapse('hide');
    }, 500);*/
}

function updateFilters(){
    $("#collapseFilters input[data-active]").removeAttr('data-active');
    $("#collapseFilters input[value]:checked").attr('data-active','');
    colorFilterButton();
}

function colorFilterButton(){
    $(".filter-btn").removeClass("btn-danger").addClass("btn-default");
    if($("#collapseFilters input[data-active]").length){
         $(".filter-btn").addClass("btn-danger");
    }
}

function getActiveFilters(){
    var active_filters = [];
    $("#collapseFilters input[data-active]").each(function(index){
        active_filters.push(parseInt(this.value));
    });
    return active_filters;
}


// ========================  HELPERs =====================

function emptyIfNull(data){
    return (data == null)? "":data;
}

function dateIfNotNull(data){
    return (data == null)? "":moment(data).format('L');
}
