$(document).ready(function() {

    var attachFormXHR;

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
                    tabpane.find("input[name=entry]").val(entryId);
                    entryTable.find('tr:eq(0) td').text(entryId);

                    tabpane.find("input[name=type]").val(formsMappings[data.form_id][0]);
                    entryTable.find('tr:eq(1) td').text(orderTypes[formsMappings[data.form_id][0]]);

                    var name = data[formsMappings[data.form_id][1][0]]+" "+data[formsMappings[data.form_id][1][1]];
                    tabpane.find("input[name=name]").val(name);
                    entryTable.find('tr:eq(2) td').text(name);

                    var email = data[formsMappings[data.form_id][1][2]];
                    tabpane.find("input[name=email]").val(email);
                    entryTable.find('tr:eq(3) td').text(email);

                    var paypal_name = data[formsMappings[data.form_id][1][3]];
                    tabpane.find("input[name=paypal_name]").val(paypal_name);
                    entryTable.find('tr:eq(4) td').text(paypal_name);

                    tabpane.find("input[name=clicks]").val(parseInt(data[formsMappings[data.form_id][1][4]]));

                    tabpane.find("input[name=date_submitted]").val(data.date_created);
                    entryTable.find('tr:eq(6) td').text(data.date_created);

                } else {
                    renderFormAttachError('Entry/Form ID Invalid or Not Found!');
                }
            },
            complete : function(){
                tabpane.removeClass('loading');
                tabpane.find('button').prop('disabled', false);
                tabpane.find('input').prop('disabled', false);
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

    }



});
