@extends('layouts.app')

@section('title', 'Dashboard')

@section('pagecss')
<link href="/css/dashboard.css" rel="stylesheet">
<link href="/css/bootcomplete.css" rel="stylesheet">
<link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
@endsection

@section('content')
<div id="alert-message" style="position: fixed;left: 300px;right: 300px;text-align: center;z-index: 100; display: none">
    <div class="alert alert-success alert-dismissible fade in" role="alert" style="display: inline-block;margin: 0;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong class='status'>Status!</strong> <span class='message'>Message.</span>
    </div>
</div>
<div class="modal fade" id="new-order-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Order</h4>
            </div>
            <div class="modal-body" style='height: 450px;'>
                <div class='row' style='margin-bottom: 10px'>
                    <div class="col-md-2 text-left">
                        <select style='padding: 7px 10px; border: 1px solid #d1d1d1;' name='order[priority]'>
                            @for ($i = 0; $i <= config('custom.priority_level'); $i++)
                                <option value='{{ $i }}'>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-10 text-right">
                        <select style='padding: 7px 10px; border: 1px solid #d1d1d1;' name='order[status]'>
                            @foreach ($order_statuses as $status)
                                <option value="{{ $status['id'] }}">{{ $status['category'] }} - {{ $status['status'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#create-payment" aria-controls="create-payment" role="tab" data-toggle="tab">Payment</a></li>
                    <li role="presentation"><a href="#create-order" aria-controls="create-order" role="tab" data-toggle="tab">Order</a></li>
                    <li role="presentation"><a href="#create-traffic" aria-controls="create-traffic" role="tab" data-toggle="tab">Traffic</a></li>
                    <li role="presentation"><a href="#create-notes" aria-controls="create-notes" role="tab" data-toggle="tab">Notes</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="create-payment">
                        <table class="table table-bordered" style='margin-top: 20px'>
                            <tbody>
                                <tr>
                                    <th scope="row" class="active text-right" style="width: 165px;">Reference : </th>
                                    <td data-errorfor='payment-reference'>
                                        <input name='payment[id]' type='hidden' value=''>
                                        <input name='payment[reference]' id='create-order-reference' type='text' value='' placeholder='Enter Reference here...'>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Paid Thru : </th>
                                    <td data-errorfor='payment-gateway'>
                                        <select name='payment[gateway]'>
                                            @foreach ($payment_gateways as $gateway)
                                                <option value="{{ $gateway['id'] }}">{{ $gateway['gateway'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Name : </th>
                                    <td data-errorfor='payment-name'><input type='text' name='payment[name]' value='' placeholder='Enter Name here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Email : </th>
                                    <td data-errorfor='payment-email'><input type='text' name='payment[email]' value='' placeholder='Enter Email here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Amount : </th>
                                    <td data-errorfor='payment-amount'><input type='text' name='payment[amount]' value='' placeholder='Enter Amount here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Date : </th>
                                    <td data-errorfor='payment-date'><input type='text' name='payment[date]' value='' id='create-order-paydate' placeholder='Enter Date here...'></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="create-order">
                        <div class='row'>
                            <div class="col-md-8 text-left">
                                <div class="input-group attach-form-btngroup" data-placement="bottom">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default form-type-display" data-entryprefix='GF'>Gravity</button>
                                        <button type="button" class="btn btn-default form-type-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only"></span>
                                        </button>
                                        <button type="button" class="btn btn-default remove-attached-form"><span class="glyphicon glyphicon-remove-sign"></span></button>
                                        <ul class="dropdown-menu form-type-list">
                                            <li data-prefix='GF'><a href="#">Gravity</a></li>
                                            <li data-prefix='WF'><a href="#">Wufoo</a></li>
                                        </ul>
                                    </div>
                                    <input type="text" class="form-control form-id-input" aria-label="..." placeholder="Form/Entry ID...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary attach-form-button" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="checkbox"><label><input type="checkbox" name='order[put_on_top]' value="1"><strong>Put on Top of Que</strong></label></div>
                            </div>
                        </div>
                        <input type="hidden" name="order[entry]" value="">
                        <input type="hidden" name="order[type]" value="">
                        <input type="hidden" name="order[name]" value="">
                        <input type="hidden" name="order[email]" value="">
                        <input type="hidden" name="order[paypal_name]" value="">
                        <input type="hidden" name="order[date_submitted]" value="">
                        <table class="table table-bordered" style='margin-top: 5px'>
                            <tbody>
                                <tr> <th scope="row" class="active text-right" style="width: 165px;">Entry ID : </th> <td data-errorfor='order-entry'></td></tr>
                                <tr> <th scope="row" class="active text-right">Traffic Type : </th> <td data-errorfor='order-type'></td></tr>
                                <tr> <th scope="row" class="active text-right">Customer Name : </th> <td data-errorfor='order-name'></td></tr>
                                <tr> <th scope="row" class="active text-right">Email : </th> <td data-errorfor='order-email'></td></tr>
                                <tr> <th scope="row" class="active text-right">Paypal Name : </th> <td data-errorfor='order-paypal_name'></td></tr>
                                <tr> <th scope="row" class="active text-right">Number of Clicks : </th> <td data-errorfor='order-clicks'><input type='text' name='order[clicks]' value=''></td></tr>
                                <tr> <th scope="row" class="active text-right">Date Submitted : </th> <td data-errorfor='order-date_submitted'></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="create-traffic">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" class="active text-right" style="width: 165px;">URL : </th>
                                    <td data-errorfor='order-url'><input type='text' name='order[url]' value='' placeholder='Enter URL here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Stats Page : </th>
                                    <td data-errorfor='order-stats'><input type='text' name='order[stats]' value='' placeholder='Enter Stats Page here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">In the Rotator : </th>
                                    <td><input type="checkbox" name='order[in_rotator]' value=""></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">No. Of Clicks Sent : </th>
                                    <td data-errorfor='order-clicks_sent'><input type='text' value='' name='order[clicks_sent]' placeholder='Enter sent clicks here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">No. Of Optins : </th>
                                    <td data-errorfor='order-optins'><input type='text' name='order[optins]' value='' placeholder='Enter no. of optins here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Follow Up Sent : </th>
                                    <td><input type="checkbox" name='order[followup_sent]' value=""></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Result Screenshoot : </th>
                                    <td data-errorfor='order-screenshot'><input type='text' value='' name='order[screenshot]' placeholder='Enter Screenshoot URL here...'></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="create-notes">
                        <div data-errorfor='note'>
                            <textarea class="form-control" name='note' rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="clear" class="btn btn-default" id='create-clear-button'>
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    Clear
                </button>
                <button type="button" class="btn btn-primary" id='create-order-button'>
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                    Create
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="view-order-modal" tabindex="-1" role="dialog" aria-labelledby="view-order-modal">
    <input type='hidden' name='id' value=''>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="view-order-title">Modal title</h4>
            </div>
            <div class="modal-body" style='height: 450px;'>
                <div class='row' style='margin-bottom: 10px'>
                    <div class="col-md-2 text-left">
                        <select style='padding: 7px 10px; border: 1px solid #d1d1d1;' name='order[priority]'>
                            @for ($i = 0; $i <= config('custom.priority_level'); $i++)
                                <option value='{{ $i }}'>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-10 text-right">
                        <select style='padding: 7px 10px; border: 1px solid #d1d1d1;' name='order[status]'>
                            @foreach ($order_statuses as $status)
                                <option value="{{ $status['id'] }}">{{ $status['category'] }} - {{ $status['status'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#view-payment" aria-controls="view-payment" role="tab" data-toggle="tab">Payment</a></li>
                    <li role="presentation"><a href="#view-order" aria-controls="view-order" role="tab" data-toggle="tab">Order</a></li>
                    <li role="presentation"><a href="#view-traffic" aria-controls="view-traffic" role="tab" data-toggle="tab">Traffic</a></li>
                    <li role="presentation"><a href="#view-notes" aria-controls="view-notes" role="tab" data-toggle="tab">Notes</a></li>
                    <li role="presentation"><a href="#view-logs" aria-controls="view-logs" role="tab" data-toggle="tab">Logs</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="view-payment">
                        <table class="table table-bordered" style='margin-top: 20px'>
                            <tbody>
                                <tr>
                                    <th scope="row" class="active text-right" style="width: 165px;">Reference : </th>
                                    <td data-errorfor='payment-reference'>
                                        <input name='payment[id]' type='hidden' value=''>
                                        <input name='payment[reference]' id='view-order-reference' type='text' value='' placeholder='Enter Reference here...'>
                                        <span data-displayfor='payment-reference'>test</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Paid Thru : </th>
                                    <td data-errorfor='payment-gateway'>
                                        <select name='payment[gateway]'>
                                            @foreach ($payment_gateways as $gateway)
                                                <option value="{{ $gateway['id'] }}">{{ $gateway['gateway'] }}</option>
                                            @endforeach
                                        </select>
                                        <span data-displayfor='payment-gateway'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Name : </th>
                                    <td data-errorfor='payment-name'>
                                        <input type='text' name='payment[name]' value='' placeholder='Enter Name here...'>
                                        <span data-displayfor='payment-name'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Email : </th>
                                    <td data-errorfor='payment-email'>
                                        <input type='text' name='payment[email]' value='' placeholder='Enter Email here...'>
                                        <span data-displayfor='payment-email'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Amount : </th>
                                    <td data-errorfor='payment-amount'>
                                        <input type='text' name='payment[amount]' value='' placeholder='Enter Amount here...'>
                                        <span data-displayfor='payment-amount'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Date : </th>
                                    <td data-errorfor='payment-date'>
                                        <input type='text' name='payment[date]' value='' id='create-order-paydate' placeholder='Enter Date here...'>
                                        <span data-displayfor='payment-date'></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="view-order">
                        <div class='row attach-form-row'>
                            <div class="col-md-8 text-left">
                                <div class="input-group attach-form-btngroup" data-placement="bottom">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default form-type-display" data-entryprefix='GF'>Gravity</button>
                                        <button type="button" class="btn btn-default form-type-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only"></span>
                                        </button>
                                        <button type="button" class="btn btn-default remove-attached-form"><span class="glyphicon glyphicon-remove-sign"></span></button>
                                        <ul class="dropdown-menu form-type-list">
                                            <li data-prefix='GF'><a href="#">Gravity</a></li>
                                            <li data-prefix='WF'><a href="#">Wufoo</a></li>
                                        </ul>
                                    </div>
                                    <input type="text" class="form-control form-id-input" aria-label="..." placeholder="Form/Entry ID...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary attach-form-button" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <label>
                                    <input type="checkbox" class='order-putontop' name='order[put_on_top]' value="0">
                                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                                    <strong>Put on Top of Que</strong>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" name="order[entry]" value="">
                        <input type="hidden" name="order[type]" value="">
                        <input type="hidden" name="order[name]" value="">
                        <input type="hidden" name="order[email]" value="">
                        <input type="hidden" name="order[paypal_name]" value="">
                        <input type="hidden" name="order[date_submitted]" value="">
                        <table class="table table-bordered" style='margin-top: 5px'>
                            <tbody>
                                <tr>
                                    <th scope="row" class="active text-right" style="width: 165px;">Entry ID : </th>
                                    <td data-errorfor='order-entry' data-displayfor='order-entry'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Traffic Type : </th>
                                    <td data-errorfor='order-type' data-displayfor='order-type'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Customer Name : </th>
                                    <td data-errorfor='order-name' data-displayfor='order-name'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Email : </th>
                                    <td data-errorfor='order-email' data-displayfor='order-email'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Paypal Name : </th>
                                    <td data-errorfor='order-paypal_name' data-displayfor='order-paypal_name'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Number of Clicks : </th>
                                    <td data-errorfor='order-clicks'>
                                        <input type='text' name='order[clicks]' value=''>
                                        <span data-displayfor='order-clicks'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Date Submitted : </th>
                                    <td data-errorfor='order-date_submitted' data-displayfor='order-date_submitted'></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="view-traffic">
                        <table class="table table-bordered" style="margin-top: 20px;">
                            <tbody>
                                <tr>
                                    <th scope="row" class="active text-right" style="width: 165px;">URL : </th>
                                    <td data-errorfor='order-url'>
                                        <input type='text' name='order[url]' value='' placeholder='Enter URL here...'>
                                        <span data-displayfor='order-url'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Stats Page : </th>
                                    <td data-errorfor='order-stats'>
                                        <input type='text' name='order[stats]' value='' placeholder='Enter Stats Page here...'>
                                        <span data-displayfor='order-stats'></span>
                                    </td>
                                </tr>
                                <tr class='check-display'>
                                    <th scope="row" class="active text-right">In the Rotator : </th>
                                    <td>
                                        <input type="checkbox" name='order[in_rotator]' value="">
                                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">No. Of Clicks Sent : </th>
                                    <td data-errorfor='order-clicks_sent'>
                                        <input type='text' value='' name='order[clicks_sent]' placeholder='Enter sent clicks here...'>
                                        <span data-displayfor='order-clicks_sent'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">No. Of Optins : </th>
                                    <td data-errorfor='order-optins'>
                                        <input type='text' name='order[optins]' value='' placeholder='Enter no. of optins here...'>
                                        <span data-displayfor='order-optins'></span>
                                    </td>
                                </tr>
                                <tr class='check-display'>
                                    <th scope="row" class="active text-right">Follow Up Sent : </th>
                                    <td>
                                        <input type="checkbox" name='order[followup_sent]' value="">
                                        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Result Screenshoot : </th>
                                    <td data-errorfor='order-screenshot'>
                                        <input type='text' value='' name='order[screenshot]' placeholder='Enter Screenshoot URL here...'>
                                        <span data-displayfor='order-screenshot'></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="view-notes">
                        <textarea></textarea>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="view-logs">
                        <table id='log-table'>
                            <thead>
                                <tr><th style='width: 150px'>Time</th><th style='width: 130px'>User</th><th>Log</th><tr>
                            </thead>
                            <tbody>
                                <tr><td class='text-center'>12/23/2016 10:34:32 PM</td><td class='text-left'>James Starr</td><td class='text-left'>Order created</td></tr>
                                <tr><td class='text-center'>12/23/2016 10:34:32 PM</td><td class='text-left'>James Starr</td><td class='text-left'>Order created</td></tr>
                                <tr><td class='text-center'>12/23/2016 10:34:32 PM</td><td class='text-left'>James Starr</td><td class='text-left'>um doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore verita</td></tr>
                                <tr><td class='text-center'>12/23/2016 10:34:32 PM</td><td class='text-left'>James Starr</td><td class='text-left'>Order created</td></tr>
                                <tr><td class='text-center'>12/23/2016 10:34:32 PM</td><td class='text-left'>James Starr</td><td class='text-left'>Order created</td></tr>
                                <tr><td class='text-center'>12/23/2016 10:34:32 PM</td><td class='text-left'>James Starr</td><td class='text-left'>Order created</td></tr>
                                <tr><td class='text-center'>12/23/2016 10:34:32 PM</td><td class='text-left'>James Starr</td><td class='text-left'>Order created</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id='view-order-edit-reset-btn'>
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    <span class='label'>Edit</span>
                </button>
                <button type="button" class="btn btn-primary">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>

<div class='row' style='margin-bottom: 20px;'>
    <div class="col-md-6"><button class="btn btn-default filter-btn" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" style="width: 90px"><span class="glyphicon glyphicon-filter"></span>&nbsp;Filters</button></div>
    <div class="col-md-6 text-right"><button type="button" class="btn btn-primary new-order-btn" data-toggle="modal" data-target="#new-order-modal"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;New Order</button></div>
</div>
<div class="collapse" id="collapseFilters">
    <div class="well">
        <div class='filters'>
            @foreach ($statuses_filters as $category => $statuses)
            <div>
                <label class='status-head'><input type='checkbox'> {{ $category }}</label>
                @foreach ($statuses as $id => $status)
                <label class='status'><input type='checkbox' value='{{ $id }}'> <span>{{ $status }}</span><br></label>
                @endforeach
            </div>
            @endforeach
        </div>
        <div class='text-right' style='margin-top: 15px;'>
            <button class="btn btn-default btn-sm clear-filter-btn" type="clear">
                <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                Clear
            </button>
            <button class="btn btn-default btn-sm default-filter-btn" type="button">
                <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>
                Default
            </button>
            <button class="btn btn-primary btn-sm update-filter-btn" type="submit">
                <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>
                Update
            </button>
        </div>
    </div>
</div>
<div class="input-group search-input-group" style='margin-bottom: 40px;'>
    <input type="text" class="form-control search-key-input" data-key='' placeholder="Type Search Keyword Here...">
    <span class="input-group-btn">
        <button class="btn btn-default clear-search" type="button">
            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
        </button>
        <button class="btn btn-default search-note-btn" type="button">
            <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
        </button>
        <button class="btn btn-default search-btn" type="button" style='width: 90px;'>
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            Search!
        </button>
    </span>
</div>
<div class="pagination-wrapper">
    <button type="button" class="btn btn-default btn-xs pag-first-btn" title='First' disabled='true'>
        <span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span>
    </button>
    <button type="button" class="btn btn-default btn-xs pag-prev-btn" title='Previous' disabled='true'>
        <span class="glyphicon glyphicon-backward" aria-hidden="true"></span>
    </button>
    <select disabled='true' class='show-pages-select' title='Jump to Pages'></select>
    <button type="button" class="btn btn-default btn-xs pag-next-btn" title='Next' disabled='true'>
        <span class="glyphicon glyphicon-forward" aria-hidden="true"></span>
    </button>
    <button type="button" class="btn btn-default btn-xs pag-last-btn" title='Last' disabled='true'>
        <span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span>
    </button>
</div>
<!-- <button type="button" class="btn btn-default btn-xs" style='float:right;'><span class="glyphicon glyphicon-sort-by-alphabet"></span></button> -->
<div class='mytable-wrapper loading initializing'>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr style='background: #adadad;'>
                <th class='text-center'><span>#</span></th>
                <th class='text-center'><span>Payment Name</span></th>
                <th class='text-center'><span>Pay Date</span></th>
                <th class='text-center'><span>Type</span></th>
                <th class='text-center'><span>Customer Name</span></th>
                <th class='text-center'><span>Clicks</span></th>
                <th class='text-center'><span>Order Date</span></th>
                <th class='text-center'><span>P</span></th>
                <th style='width: 180px;' class='text-center'><span>Status</span></th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr class='no-record'><td colspan='9'>No Order Found</td></tr>
            <tr class='init'><td colspan='9'>Initializing</td></tr>
        </tfoot>
    </table>
</div>
<div class="pagination-wrapper">
    <button type="button" class="btn btn-default btn-xs pag-first-btn" title='First' disabled='true'>
        <span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span>
    </button>
    <button type="button" class="btn btn-default btn-xs pag-prev-btn" title='Previous' disabled='true'>
        <span class="glyphicon glyphicon-backward" aria-hidden="true"></span>
    </button>
    <select disabled='true' class='show-pages-select' title='Jump to Pages'></select>
    <button type="button" class="btn btn-default btn-xs pag-next-btn" title='Next' disabled='true'>
        <span class="glyphicon glyphicon-forward" aria-hidden="true"></span>
    </button>
    <button type="button" class="btn btn-default btn-xs pag-last-btn" title='Last' disabled='true'>
        <span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span>
    </button>
</div>
@endsection

@section('pagescripts')
<script src="/js/dashboard.js"></script>
<script src="/js/jquery.bootcomplete.js"></script>
<script type="text/javascript" src="/js/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    var orderTypes = {!! json_encode($order_type_mappings['types'], true) !!},
        formsMappings = {!! json_encode($order_type_mappings['forms'], true) !!},
        user_default_filter = {!! json_encode(explode(',', Auth::user()->default_filter), true) !!};
</script>
@endsection
