<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing: border-box;
        }
        body{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        p{
            font-size: 11px;
            margin-bottom: 2px !important;
            line-height: 20px;
        }
        .page{
            width: 21cm !important;
            height: 29.7cm ;
            overflow: hidden !important;

        }
        .container{
            padding-left: 10px;
            padding-right: 10px;
        }
        .inner_border{
            width: 20cm !important;
            height: 28.7cm;
            overflow: hidden;
            margin: .5cm auto;
            border: 1px solid lightgray;
        }
        .row{
            width: 100%;

        }
        .img{
            margin-top: 20px;
            height: 30px;
        }

        .tr_bordered td, .tr_bordered th{
            font-size: 11px;
            border: 1px solid lightgray;

        }
        .m_table{
            width: 100%;
            border-collapse: collapse;
        }
        .w_id{
            width: 5%;
        }
        .w_name{
            width: 40%;
            text-align: left;
        }
        .w_code{
            width: 17%;
            text-align: center;
        }
        .w_price{
            width: 12%;
            text-align: center;
        }
        .w_qty{
            width: 10%;
            text-align: center;
        }
        .w_total{
            width: 16%;
            text-align: right;
        }
        .totals{
            font-size: 11px;

        }

        .sub_name{
            border: 1px solid lightgray;
        }
        .sub_value{
            border: 1px solid lightgray;
            text-align: right;

        }
        .font_bigger{
            font-size: 13px;
        }
        .mt-4{
            margin-top: 16px;
        }
        .mt-5{
            margin-top: 20px;
        }
        .mb-4{
            margin-bottom: 16px;
        }
        .col-12{
            width: 100%;
        }
        .col-4{
            width: 33%;
            float: left;
        }

        .col-9{
            width: 75%;
            float: left;
        }
        .col-3{
            width: 25%;
            float: left;
        }
        .col-3:after, .col-4:after, .col-9:after, .col-12:after{
            content: "";
            display: table;
            clear: both;
        }
        .pl-3{
            padding-left: 12px;
        }
        .pr-3{
            padding-right: 12px;
        }
        .pb-5{
            padding-bottom: 20px;
        }
        .font-weight-bold{
            font-weight: bold;
        }
        .table-sm{
            padding:10px;
        }
        .text-center{
            text-align: center;
        }
        td, th{
            padding:5px;
        }
        .float-right{
            float: right;
        }
        .clearfix {
            overflow: auto;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

    </style>
</head>
<body>
<div class="page ">
    <div class="container inner_border">
        <div class="row">
            <div class="col-12 pt-4 pl-3 m-0">
                <img class="img" height="34px" src="{{asset('app_images/logo.png')}}" alt="logo">
            </div>
        </div>
        <div class="row mt-4 ">
            <div class="col-4 pb-5 pl-3">
                <p>Company name: {{$settings->company_name}}</p>
                <p>Address: {{$settings->address}}</p>
                <p>City: {{$settings->zip}} {{$settings->city}}</p>
                <p>Country: {{$settings->country}}</p>
                <p>VAT: {{$settings->vat}}</p>
                <p>Registration no.: {{$settings->registration_no}}</p>
                <p>Phone: {{$settings->phone1}}</p>
                <p>Phone: {{$settings->phone2}}</p>
                <p>Email: {{$settings->email}}</p>
            </div>
            <div class="col-4 pb-5">
                <h6>Customer:</h6>
                <p>Name: {{$shipping->name}}</p>
                <p>Contact: {{$shipping->contact_person}}</p>
                <p>Address:  {{$shipping->address}}</p>
                <p>City:  {{$shipping->zip}} {{$shipping->city}}</p>
                <p>Phone:  {{$shipping->phone1}}</p>
                <p>Phone:  {{$shipping->phone2}}</p>
                <p>Email:  {{$shipping->email}}</p>
            </div>
            <div class="col-4 pb-5">
                <h3 class="mb-4">Order Confirmation</h3>
                <h6>No.  {{$order->id}}/{{date('Y')}}</h6>
                <p>Date:  {{date('d.m.Y')}}</p>
                @if($order->paid_on)
                <p class="font-weight-bold">Order is paid on: {{formatDate($order->paid_on)}}</p>
                @else
                <p class="font-weight-bold">Order should be paid with cash to courier</p>
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row pl-3 pr-3">
            <table class="m_table table-sm">
                <thead>
                <tr class="tr_bordered">
                    <th class="w_id ">#</th>
                    <th class="w_name ">Article</th>
                    <th class="w_code ">Code</th>
                    <th class="w_price ">Price</th>
                    <th class="w_qty ">Quantity</th>
                    <th class="w_total ">Total</th>

                </tr>
                </thead>
                <tbody>
                @foreach($order_items as $item)
                <tr class="tr_bordered">
                    <td class="w_id">{{$loop->index + 1}}.</td>
                    <td class="w_name">{{$item->name}}</td>
                    <td class="w_code">{{$item->acc_code}}</td>
                    <td class="w_price">{{formatPrice($item->selling_price)}}</td>
                    <td class="w_qty">{{$item->qty}}</td>
                    <td class="w_total">{{formatPrice($item->selling_price * $item->qty)}}</td>
                </tr>
                @endforeach


                <tr class="totals">
                    <td colspan="3"></td>
                    <td class="sub_name" colspan="2">Subtotal:</td>
                    <td class="sub_value"> {{formatPrice($order->subtotal)}}</td>
                </tr>
                @if($order->subtotal_with_coupon)
                <tr class="totals">
                    <td colspan="3"></td>
                    <td class="sub_name" colspan="2">Subtotal with coupon:</td>
                    <td class="sub_value"> {{formatPrice($order->subtotal_with_coupon)}}</td>
                </tr>
                @endif
                <tr class="totals">
                    <td colspan="3"></td>
                    <td class="sub_name" colspan="2">Shipping fee:</td>
                    <td class="sub_value"> {{formatPrice($order->shipping_fee)}}</td>
                </tr>

                <tr class="totals">
                    <td colspan="3"></td>
                    <td class="sub_name font-weight-bold" colspan="2">Total Payment Value:</td>
                    <td class="sub_value font-weight-bold" > {{formatPrice($order->total)}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-5">
            <div class="col-12 ">
                <p>This document is valid without stamp and signature</p>
            </div>
        </div>
        @if($shipping->comment)
        <div class="row mt-5">
            <div class="col-12 ">
                <p>Note in the order: {{$shipping->comment}}</p>
            </div>
        </div>
        @endif
        <div class="row mt-5">
            <div class="col-9">

            </div>
            <div class="col-3 text-center float-right pl-3">
                <p class="font_bigger">{{$settings->person_in_charge}}</p>
                <p class="font_bigger">{{$settings->person_title}}</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>

