var attachFormXHR, createOrderXHR, updateOrderXHR;

$(document).ready(function() {

    $('#new-order-modal').on('show.bs.modal', function () {
        var modal_content = $(this).find(".modal-content");
        if(typeof attachFormXHR !== 'undefined'){
            attachFormXHR.abort();
        }
        if(typeof createOrderXHR !== 'undefined'){
            createOrderXHR.abort();
        }
        clearAllCreateField();
        $(this).find(".modal-content ul.nav-tabs li a:first").tab('show');
    });

    $('#create-order-reference').bootcomplete({
        url :'ajax/payment/autolist',
        idFieldName: "payment\\[id\\]"
    });

    $('#view-order-reference').bootcomplete({
        url :'ajax/payment/autolist',
        idFieldName: "payment\\[id\\]"
    });

    $('#create-order-reference, #view-order-reference').on('input', function(){
        $(this).parent().prev().val("");
        restoreIgnoredPaymentField($(this).closest("table"));
    });

    $('input[name=payment\\[id\\]]').on('change', function(e){
        ignorePaymentFields($(this).closest("table"));
    });

    $('#create-order-paydate, #view-edit-order-paydate').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm:ss'
    });

    $("ul.form-type-list li").on('click', function(e){
        formtypedisplay = $(this).parents("div.input-group-btn").find('.form-type-display').text($(this).text())[0];
        formtypedisplay.dataset.entryprefix = this.dataset.prefix;
    });

    $("button.attach-form-button").on('click',function(e){
        getFormDetail(this);
    });

    $("input.form-id-input").keypress(function(e) {
        if (e.which == "13") {
            getFormDetail($(this).next().find('button.attach-form-button')[0]);
        }
    });

    $("button.remove-attached-form").on('click', function(e){
        removeAttachedForm(this);
    });

    $("#create-order-button").on('click', function(e){

        var modal_content = $(this).parents(".modal-content"),
            thisbutton = this;

        clearAllErrors(modal_content);
        modal_content.find(".modal-body").addClass("loading");
        $(thisbutton).parent().find('button').prop('disabled', true);

        createOrderXHR = $.ajax({
            url: "ajax/order/create",
            dataType: "json",
            accepts: "application/json; charset=utf-8",
            type : "POST",
            data : parseRequestData(modal_content),
            success : function(data) {
                if(data.hasOwnProperty('id')){
                    $('#new-order-modal').modal('hide');
                    displayAlertMessage('success', 'Success!', "Order has been created");
                    if ($("#collapseFilters .well input[value="+data.status+"][data-active]").length || isFilterClear()) {
                        refreshOrderList();
                    }
                } else {
                    displayAlertMessage('danger', 'Error!', "Something's not right");
                }
            },
            complete : function(response){
                $(thisbutton).parent().find('button').prop('disabled', false);
                modal_content.find(".modal-body").removeClass("loading");
            },
            statusCode: {
                400: function(response) {
                    modal_content.find(".modal-body").removeClass("loading");
                    showFieldErrors(modal_content, response.responseJSON);
                },
                500: function(response) {
                    displayAlertMessage('danger', 'Error!', "Something's not right");
                }
            }
        });

    });

    $("#create-clear-button").on('click', function(e){
        clearAllCreateField();
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
                removeSorter();
                columnTh.addClass('sorter')[0].dataset.direction = 'asc';
            }

            loadOrderList();

        }

    };

    $(".update-filter-btn").on('click', function(e){
        filterOrderList();
    });

    $(".clear-filter-btn").on('click', function(e){
        if (!isFilterClear()) {
            var filterCheckBoxes = document.querySelectorAll("#collapseFilters .well input");
            for (i in filterCheckBoxes) {
                filterCheckBoxes[i].checked = false;
            }
            filterOrderList();
        }
    });

    $(".default-filter-btn").on('click', function(e){
        var filterCheckBoxes = document.querySelectorAll("#collapseFilters .well input");
        for (i in filterCheckBoxes) {
            filterCheckBoxes[i].checked = (user_default_filter.indexOf(filterCheckBoxes[i].value) > -1);
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

    $(".search-note-btn").click(function() {
        $(this).toggleClass('btn-default btn-primary');
    });

    $("button.search-btn").on('click', function(e){
        search();
    });

    $("input.search-key-input").keypress(function(e) {
        if (e.which == "13") {
            search();
        }
    });

    $(".clear-search").on('click', function(){
        var searchinput = $("input.search-key-input")[0];
        searchinput.value = '';
        $(".search-note-btn").removeClass('btn-primary').addClass("btn-default");
        if(searchinput.dataset.key.trim().length){
            searchinput.dataset.key = '';
            removeSorter();
            loadOrderList();
        }
    });

    document.querySelector("div.mytable-wrapper tbody").onclick = function(e){

        var originalElement = e.srcElement || e.originalTarget,
            columnTr = $(originalElement).closest('tr'),
            view_order_modal = $("#view-order-modal");

        if(typeof attachFormXHR !== 'undefined'){
            attachFormXHR.abort();
        }
        if(typeof updateOrderXHR !== 'undefined'){
            updateOrderXHR.abort();
        }

        clearAllErrors(view_order_modal);
        $("#view-order-title").text("Loading...");
        restoreIgnoredPaymentField($("#view-payment").find("table"));
        view_order_modal.find("ul.nav-tabs li a:first").tab('show');
        view_order_modal.find('div.modal-body').removeClass("edit-mode").addClass("loading");
        view_order_modal.modal('show');

        loadOrderDetails(columnTr.data("id"));
        $("#view-order-edit-reset-btn").find("span.glyphicon").removeClass("glyphicon-repeat").addClass("glyphicon-pencil").next().text("Edit");

    };

    document.querySelector("#view-order-modal").oninput = removeErrorOnInput;
    document.querySelector("#new-order-modal").oninput = removeErrorOnInput;

    $("#view-order-edit-reset-btn").on('click',function(e){
        var jthis = $(this);
        if(jthis.find("span.label").text() == "Edit"){
            jthis.parent().prev().addClass("edit-mode");
            jthis.find("span.glyphicon").removeClass("glyphicon-pencil").addClass("glyphicon-repeat").next().text("Reset");
            ignorePaymentFields($("#view-payment table"));
        } else {
            clearAllErrors($(this).parents(".modal-content"));
            jthis.parent().prev().removeClass("edit-mode");
            jthis.find("span.glyphicon").removeClass("glyphicon-repeat").addClass("glyphicon-pencil").next().text("Edit");
            resetViewOrderFieldValues();
        }
    });

    $("#view-order-edit-save-btn").on('click', function(e){

        var modal_content = $(this).parents(".modal-content"),
            thisbutton = this;

        clearAllErrors(modal_content);
        modal_content.find(".modal-body").addClass("loading");
        $(thisbutton).parent().find('button').prop('disabled', true);

        updateOrderXHR = $.ajax({
            url: "ajax/order/update",
            dataType: "json",
            accepts: "application/json; charset=utf-8",
            type : "POST",
            data : parseRequestData(modal_content),
            success : function(data) {
                if(data.hasOwnProperty('id')){
                    $("#view-order-modal").modal('hide');
                    displayAlertMessage('success', 'Success!', "Order has been updated");
                    refreshOrderList();
                } else {
                    displayAlertMessage('danger', 'Error!', "Something's not right");
                }
            },
            complete : function(response){
                $(thisbutton).parent().find('button').prop('disabled', false);
                modal_content.find(".modal-body").removeClass("loading");
            },
            statusCode: {
                400: function(response) {
                    modal_content.find(".modal-body").removeClass("loading");
                    showFieldErrors(modal_content, response.responseJSON);
                },
                500: function(response) {
                    displayAlertMessage('danger', 'Error!', "Something's not right");
                }
            }
        });

    });

    loadOrderList();

});

function ignorePaymentFields(containingParent){

    containingParent.find("tbody tr:first-child").nextAll().each(function(index){
        var inputField = $(this).find("select,input");
        fieldname = inputField.attr("name");
        if(inputField.is("select")){
            inputField.val(inputField.find("option:first-child").val());
        }else{
            inputField.val("");
        }
        inputField.removeAttr("name").attr("disabled", true);
        if (fieldname) {
            inputField[0].dataset.name = fieldname;
        }
        $(inputField).parents("[data-errorfor]").removeClass('has-error').removeAttr('data-toggle title data-original-title').tooltip('destroy');
    });

}

function restoreIgnoredPaymentField(containingParent){
    containingParent.find("[data-name]").each(function(index){
        $(this).attr("name", this.dataset.name);
        $(this).attr("disabled", false);
        delete this.dataset.name;
    });
}


function getFormDetail(caller){

    tabpane = $(caller).parents('div.tab-pane');

    requestdata = {
        "code": tabpane.find('button.form-type-display')[0].dataset.entryprefix,
        "id": tabpane.find('input.form-id-input').val().trim()
    }

    tabpane.addClass('loading');
    tabpane.find('button').prop('disabled', true);
    tabpane.find('input').prop('disabled', true);
    removeFormAttachError(tabpane);

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

            } else {
                renderFormAttachError('Entry/Form ID Invalid or Not Found!');
            }
        },
        complete : function(response){
            removeLoadingAndEnableFields();
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

function removeAttachedForm(caller){
    tabpane = $(caller).parents('div.tab-pane');
    tabpane.find("input[name]").val("");
    removeFormAttachError(tabpane);
    tabpane.find('table tr:not(:eq(5)) td').text("");
}

function removeFormAttachError(tabpane){
    tabpane.find('div.attach-form-btngroup').removeClass('has-error').removeAttr('data-toggle title data-original-title').tooltip('destroy');
}

function removeErrorOnInput(e){
    var originalElement = e.srcElement || e.originalTarget,
        errorElement = $(originalElement).parents("[data-errorfor]");

    if(errorElement.hasClass("has-error")){
        errorElement.removeClass('has-error').removeAttr('data-toggle title data-original-title').tooltip('destroy');
    }
}

function parseRequestData(modal_content) {
    var request_data = {'_token': window.Laravel.csrfToken };

    modal_content.find("[name]").each(function(index) {
        request_data[this.name] = (this.type === 'checkbox')? ((this.checked)? 1:0):$(this).val();
    });

    return request_data;
}

function showFieldErrors(modal_content, errorFields){
    for(fieldname in errorFields){
        var error_element = modal_content.find("[data-errorfor="+fieldname.replace('.','-')+"]");
        error_element.addClass('has-error');
        error_element.tooltip({'title': errorFields[fieldname][0].replace('.',' '), 'placement': 'left'});
    }
    modal_content.find("[data-errorfor]").tooltip('show');
    modal_content.find("div.tab-content div.tab-pane:has(.has-error:not(.attach-form-btngroup))").each(function(index){
        modal_content.find("ul.nav-tabs li:has(a[aria-controls="+this.id+"])").addClass("hilight-error");
    });
}

function clearAllErrors(modal_content){
    modal_content.find("ul.nav-tabs li").removeClass("hilight-error");
    modal_content.find("[data-errorfor],.attach-form-btngroup").removeClass('has-error').removeAttr('data-toggle title data-original-title').tooltip('destroy');
}

function clearAllCreateField(){
    var modal_content = $('#new-order-modal .modal-content');
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
            this.value = $(this).find("option:first-child").val();
        }
    });
    removeAttachedForm(modal_content.find('button.remove-attached-form'));
    restoreIgnoredPaymentField(modal_content);
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
    toggleUpperInputs(false);

    request_data = { 'page': page };

    sorterTh = $("div.mytable-wrapper thead th.sorter");
    if (sorterTh.length) {
        request_data['sort[index]'] = sorterTh.index();
        request_data['sort[direction]'] = sorterTh[0].dataset.direction;
    }

    if((filters = getActiveFilters()).length){
        request_data['filters'] = filters;
    }

    setSearchData(request_data);

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
            toggleUpperInputs(true);
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
        ordersHtml += "<tr data-id='"+order.id+"'><th scope='row' class='text-center'>"+order.id+"</th> <td>"+order.payment_name+"</td><td class='text-center'>\
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

function toggleUpperInputs(enabled){
    $("#collapseFilters").collapse('hide');
    $(".filter-btn, .new-order-btn, .search-input-group input, .search-input-group button").attr('disabled', !enabled);
}

function renderEmptyTable(){
    var empty_fake_date = {
        data: [],
        last_page: 0,
        current_page: 0
    }
    renderTableData(empty_fake_date);
}

function removeSorter(){
    $("div.mytable-wrapper thead tr th").removeClass('sorter').removeAttr('data-direction');
}

function filterOrderList(){
    updateFilters();
    removeSorter();
    loadOrderList();
    setTimeout(function(){
        $("#collapseFilters").collapse('hide');
    }, 700);
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

function isFilterClear(){
    return (getActiveFilters().length == 0);
}

function setSearchData(request_data){
    var search_key = $("input.search-key-input")[0].dataset.key;
    if (search_key.trim().length) {
        request_data['search_key'] = search_key;
        if ($(".search-note-btn").hasClass("btn-primary")) {
            request_data['search_note'] = 1;
        }
    }
}

function search(){
    var search_input = $("input.search-key-input")[0], search_text = search_input.value.trim();
    if(search_text.length){
        search_input.dataset.key = search_input.value.trim();
        removeSorter();
        loadOrderList();
    }
}

function loadOrderDetails(order_id){

    $.ajax({
        url: "ajax/order/detail",
        dataType: "json",
        accepts: "application/json; charset=utf-8",
        type : "GET",
        data : { 'id': order_id },
        success : function(response) {
            $("#view-order-title").text("Order ID: "+response.id);
            loadViewOrderFieldValues(response);
        },
        complete : function(data) {
            $("#view-order-modal").find('div.modal-body').removeClass("loading");
        },
        statusCode: {
            400: function(response) {
                displayAlertMessage('danger', 'Error!', "Bad Request");
            },
            500: function(response) {
                displayAlertMessage('danger', 'Error!', "Something's not right");
            }
        }

    });

}

function loadViewOrderFieldValues(data){
    var view_order_modal = $("#view-order-modal"),
        notes = data.notes;

    delete data.notes;

    for(fieldname in data){

        fieldnameSelector = fieldname.split("-");

        if(fieldnameSelector.length > 1){
            fieldnameSelector[1] = "\\["+fieldnameSelector[1]+"\\]";
        }

        fieldnameSelector = fieldnameSelector.join("");
        jDataElement = $(view_order_modal).find("input[name="+fieldnameSelector+"], select[name="+fieldnameSelector+"]");
        jDisplayElement = $(view_order_modal).find("[data-displayfor="+fieldname+"]");
        fieldValue = emptyIfNull(data[fieldname]);

        jDataElement.val(fieldValue);
        jDataElement[0].dataset.original = fieldValue;
        jDisplayElement.text(fieldValue);

        if (jDataElement.is("input[type='checkbox']")) {
            jDataElement.attr("checked", !!fieldValue);
        }
        if (jDataElement.is("select")) {
            jDisplayElement.text(jDataElement.find("option[value="+fieldValue+"]").text());
        }
        if (fieldname == "order-type") {
            jDisplayElement.text(orderTypes[fieldValue]);
        }

    }

    $(view_order_modal).find("#view-notes textarea").val("");
    $(view_order_modal).find("#view-notes div.note").remove();
    for(i in notes){
        $(view_order_modal).find("#view-notes").append(generateNoteHtml(notes[i]));
    }

}

function generateNoteHtml(note){
    return "<div class='note'>\
        <span>"+moment(note.created_at).format('lll')+"<span style='float: right;'>\
        ID: "+note.id+"</span></span>\
        <p>"+note.note+"</p>\
        <span class='author'>- "+(note['author'])+"</span>\
    </div>";
}

function resetViewOrderFieldValues(){
    var view_order_modal = $("#view-order-modal");
    view_order_modal.find("[data-original]").each(function(index){
        var jthis = $(this);

        jthis.val(this.dataset.original);
        if(jthis.is("input[type='checkbox']")){
            this.checked = !!this.dataset.original;
        }

        displayFieldName = jthis.attr("name")||jthis[0].dataset.name;
        jDisplayElement = view_order_modal.find("[data-displayfor="+(displayFieldName.replace("[", "-").replace("]", ""))+"]");

        jDisplayElement.text(this.dataset.original);

        if (jthis.is("select")) {
            jDisplayElement.text(jthis.find("option[value="+this.dataset.original+"]").text());
        }
        if (jthis.attr("name") == "order[type]") {
            jDisplayElement.text(orderTypes[this.dataset.original]);
        }

        view_order_modal.find("#view-notes textarea").val("");

    });
}


// ========================  HELPERs =====================

function emptyIfNull(data){
    return (data == null)? "":data;
}

function dateIfNotNull(data){
    return (data == null)? "":moment(data).format('L');
}
