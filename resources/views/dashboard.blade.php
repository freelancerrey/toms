@extends('layouts.app')

@section('title', 'Dashboard')

@section('pagecss')
<link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('content')
<div class="modal fade" id="new-order-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add New Order</h4>
            </div>
            <div class="modal-body" style='height: 420px;'>
                <div class='row' style='margin-bottom: 10px'>
                    <div class="col-md-10 text-left">
                        <select style='padding: 7px 10px; border: 1px solid #d1d1d1;'>
                            <option value='1'>ORDER - Waiting for Confirmation</option>
                            <option value='2'>ORDER - Waiting for Previous Order</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-right">
                        <select style='padding: 7px 10px; border: 1px solid #d1d1d1;'>
                            <option value='1'>1</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
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
                                    <td><input type='text' value='test' placeholder='Enter Reference here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Paid Thru : </th>
                                    <td>
                                        <select>
                                            <option value='1'>Authorize.net</option>
                                            <option value='2'>Paypal</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Name : </th>
                                    <td><input type='text' value='' placeholder='Enter Name here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Email : </th>
                                    <td><input type='text' value='' placeholder='Enter Email here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Amount : </th>
                                    <td><input type='text' value='' placeholder='Enter Amount here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Date : </th>
                                    <td><input type='text' value='' placeholder='Enter Date here...'></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="create-order">
                        <div class='row'>
                            <div class="col-md-7 text-left">
                                <div class="input-group has-error" data-toggle="tooltip" data-placement="bottom" title="Tooltip on left">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default">Gravity</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Gravity</a></li>
                                            <li><a href="#">Wufoo</a></li>
                                        </ul>
                                    </div>
                                    <input type="text" class="form-control" aria-label="..." id='create-order-formid' placeholder="Form/Entry ID...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5 text-right">
                                <div class="checkbox"><label><input type="checkbox" value=""><strong>Put on top of the Que</strong></label></div>
                            </div>
                        </div>
                        <table class="table table-bordered" style='margin-top: 5px'>
                            <tbody>
                                <tr> <th scope="row" class="active text-right" style="width: 165px;">Traffic Type : </th> <td>Mark</td></tr>
                                <tr> <th scope="row" class="active text-right">Customer Name : </th> <td>Larry</td></tr>
                                <tr> <th scope="row" class="active text-right">Email : </th> <td>Jacob</td></tr>
                                <tr> <th scope="row" class="active text-right">Paypal Name : </th> <td>Jacob</td></tr>
                                <tr> <th scope="row" class="active text-right">Number of Clicks : </th> <td>Larry</td></tr>
                                <tr> <th scope="row" class="active text-right">Date Submitted : </th> <td>Larry</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="create-traffic">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" class="active text-right" style="width: 165px;">URL : </th>
                                    <td><input type='text' value='' placeholder='Enter URL here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Stats Page : </th>
                                    <td><input type='text' value='' placeholder='Enter Stats Page here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">In the Rotator : </th>
                                    <td><input type="checkbox" value=""></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">No. Of Clicks Sent : </th>
                                    <td><input type='text' value='' placeholder='Enter no. of clicks here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">No. Of Optins : </th>
                                    <td><input type='text' value='' placeholder='Enter no. of optins here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Follow Up Sent : </th>
                                    <td><input type="checkbox" value=""></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Result Screenshoot : </th>
                                    <td><input type='text' value='' placeholder='Enter Screenshoot URL here...'></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="create-notes">
                        <div class='has-error' data-toggle="tooltip" data-placement="bottom" title="Tooltip on left">
                            <textarea class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="clear" class="btn btn-default" >Clear</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="view-order-modal" tabindex="-1" role="dialog" aria-labelledby="view-order-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="view-order-title">Modal title</h4>
            </div>
            <div class="modal-body" style='height: 410px;'>
                <div class='row' style='margin-bottom: 10px'>
                    <div class="col-md-10 text-left">
                        <select style='padding: 7px 10px; border: 1px solid #d1d1d1;'>
                            <option value='1'>ORDER - Waiting for Confirmation</option>
                            <option value='2'>ORDER - Waiting for Previous Order</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-right">
                        <select style='padding: 7px 10px; border: 1px solid #d1d1d1;'>
                            <option value='1'>1</option>
                            <option value='2'>2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
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
                                    <td><input type='text' value='test' placeholder='Enter Reference here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Paid Thru : </th>
                                    <td>
                                        <select>
                                            <option value='1'>Authorize.net</option>
                                            <option value='2'>Paypal</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Name : </th>
                                    <td><input type='text' value='' placeholder='Enter Name here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Email : </th>
                                    <td><input type='text' value='' placeholder='Enter Email here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Amount : </th>
                                    <td><input type='text' value='' placeholder='Enter Amount here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Date : </th>
                                    <td><input type='text' value='' placeholder='Enter Date here...'></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="view-order">
                        <div class='row attach-formid-btngroup'>
                            <div class="col-md-7 text-left">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default">Gravity</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Gravity</a></li>
                                            <li><a href="#">Wufoo</a></li>
                                        </ul>
                                    </div>
                                    <input type="text" class="form-control" aria-label="..." id='create-order-formid' placeholder="Form/Entry ID...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-5 text-right">
                                <div class="checkbox"><label><input type="checkbox" value=""><strong>Put on top of the Que</strong></label></div>
                            </div>
                        </div>
                        <table class="table table-bordered" style='margin-top: 10px'>
                            <tbody>
                                <tr id='form-entry-view'> <th scope="row" class="active text-right">Form/Entry ID : </th> <td>Mark <span class="glyphicon glyphicon-circle-arrow-up" style='font-size: 20px; float: right;' aria-hidden="true"></span></td></tr>
                                <tr> <th scope="row" class="active text-right" style="width: 165px;">Traffic Type : </th> <td>Mark</td></tr>
                                <tr> <th scope="row" class="active text-right">Customer Name : </th> <td>Larry</td></tr>
                                <tr> <th scope="row" class="active text-right">Email : </th> <td>Jacob</td></tr>
                                <tr> <th scope="row" class="active text-right">Paypal Name : </th> <td>Jacob</td></tr>
                                <tr> <th scope="row" class="active text-right">Number of Clicks : </th> <td>Larry</td></tr>
                                <tr> <th scope="row" class="active text-right">Date Submitted : </th> <td>Larry</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="view-traffic">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" class="active text-right" style="width: 165px;">URL : </th>
                                    <td><input type='text' value='' placeholder='Enter URL here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Stats Page : </th>
                                    <td><input type='text' value='' placeholder='Enter Stats Page here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">In the Rotator : </th>
                                    <td><input type="checkbox" value=""></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">No. Of Clicks Sent : </th>
                                    <td><input type='text' value='' placeholder='Enter no. of clicks here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">No. Of Optins : </th>
                                    <td><input type='text' value='' placeholder='Enter no. of optins here...'></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Follow Up Sent : </th>
                                    <td><input type="checkbox" value=""></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="active text-right">Result Screenshoot : </th>
                                    <td><input type='text' value='' placeholder='Enter Screenshoot URL here...'></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="view-notes">
                        <textarea></textarea>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem </p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis </p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde </p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
                        <div class='note'>
                            <span>Dec 23, 2016</span>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit</p>
                            <span class='author'>- James Starr</span>
                        </div>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class='row' style='margin-bottom: 20px;'>
    <div class="col-md-6"><button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" style="width: 90px"><span class="glyphicon glyphicon-filter"></span>&nbsp;Filters</button></div>
    <div class="col-md-6 text-right"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-order-modal"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;New Order</button></div>
</div>
<div class="collapse" id="collapseFilters">
    <div class="well">
        <div class='row'>
            <div class="col-md-2">
                <div class="checkbox"><label><input type="checkbox" value=""><strong>Payment</strong></label></div>
            </div>
            <div class="col-md-2">
                <div class="checkbox"><label><input type="checkbox" value=""><strong>Order</strong></label></div>
            </div>
            <div class="col-md-2">
                <div class="checkbox"><label><input type="checkbox" value=""><strong>Process</strong></label></div>
            </div>
            <div class="col-md-2">
                <div class="checkbox"><label><input type="checkbox" value=""><strong>Traffic</strong></label></div>
            </div>
            <div class="col-md-2">
                <div class="checkbox"><label><input type="checkbox" value=""><strong>Done</strong></label></div>
            </div>
            <div class="col-md-2">
                <div class="checkbox"><label><input type="checkbox" value=""><strong>Discard</strong></label></div>
            </div>
        </div>
        <div class='text-right' style='margin-top: 15px;'>
            <button class="btn btn-default" type="clear">Clear</button>
            <button class="btn btn-default" type="button">Default</button>
            <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </div>
</div>
<div class="input-group">
    <input type="text" class="form-control" placeholder="Type Search Keyword Here...">
        <span class="input-group-btn">
    <button class="btn btn-default" type="button" style='width: 90px;'>Search!</button>
    </span>
</div>
<nav aria-label="..."> <ul class="pagination pagination-sm"> <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> <li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li> <li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> </ul> </nav>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr style='background: #adadad;'>
            <th class='text-center'>#</th>
            <th>Payment Name <button type="button" class="btn btn-default btn-xs" style='float:right;'><span class="glyphicon glyphicon-sort-by-alphabet"></span></button></th>
            <th class='text-center'>Pay Date</th>
            <th class='text-center'>Type</th>
            <th>Customer Name</th>
            <th class='text-center'>Clicks</th>
            <th class='text-center'>Order Date</th>
            <th style='width: 180px;' class='text-center'>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr> <th scope="row" class='text-center'>1</th> <td>Mark Jacob <span class="badge">4</span></td> <td>12/23/16</td> <td>@otto</td> <td>Otto</td> <td>@mdo</td><td>12/23/16</td> <td class='status-cell'><span class="order-status payment">PROCESS<br>Waiting for Previous Order</span></td> </tr>
        <tr> <th scope="row" class='text-center'>2</th> <td>Jacob <span class="badge">4</span></td> <td>Thornton</td> <td>@fat</td> <td>Otto</td> <td>@mdo</td><td>Otto</td> <td class='status-cell'><span class="order-status order">PROCESS<br>Waiting for Previous Order</span></td></tr>
        <tr> <th scope="row" class='text-center'>3</th> <td>Larry <span class="badge">4</span></td> <td>the Bird</td> <td>@twitter</td> <td>Otto</td> <td>@mdo</td><td>Otto</td> <td class='status-cell'><span class="order-status process">PROCESS<br>Waiting for Previous Order</span></td></tr>
        <tr> <th scope="row" class='text-center'>3</th> <td>Larry</td> <td>the Bird</td> <td>@twitter</td> <td>Otto</td> <td>@mdo</td><td>Otto</td> <td class='status-cell'><span class="order-status traffic">PROCESS<br>Waiting for Previous Order</span></td></tr>
        <tr> <th scope="row" class='text-center'>3</th> <td>Larry</td> <td>the Bird</td> <td>@twitter</td> <td>Otto</td> <td>@mdo</td><td>Otto</td> <td class='status-cell'><span class="order-status done">PROCESS<br>Waiting for Previous Order</span></td></tr>
        <tr> <th scope="row" class='text-center'>3</th> <td>Larry</td> <td>the Bird</td> <td>@twitter</td> <td>Otto</td> <td>@mdo</td><td>Otto</td> <td class='status-cell'><span class="order-status discard">PROCESS<br>Waiting for Previous Order</span></td></tr>
    </tbody>
</table>
<nav aria-label="..."> <ul class="pagination pagination-sm"> <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> <li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li> <li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> </ul> </nav>
@endsection
