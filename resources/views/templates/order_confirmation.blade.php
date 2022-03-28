<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">--}}
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing: border-box;
        }
        p{
            font-size: 11px;
            margin-bottom: 2px !important;
        }
        .page{
            width: 21cm !important;
            height: 29.7cm !important;
            overflow: hidden !important;

        }
        .inner_border{
            width: 20cm !important;
            height: 28.7cm !important;
            margin: .5cm auto;
            border: 1px solid lightgray;
        }
        .img{
            height: 2cm;
        }
        table{

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
            width: 44%;
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
            width: 12%;
            text-align: end;
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


    </style>
</head>
<body>
<div class="page ">
    <div class="container inner_border">
        <div class="row">
            <div class="col-12 pt-4 pl-3 m-0">
                <img class="img" src="{{asset('app_images/logo.png')}}" alt="logo">
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
                <p>Phone: {{$settings->phone1}}}</p>
                <p>Phone: {{$settings->phone2}}</p>
                <p>Email: {{$settings->email}}</p>
            </div>
            <div class="col-4 pb-5">
                <h6>Customer:</h6>
                <p>Name: {{$order->name}}</p>
                <p>Contact: {{$order->shipping->contact_person}}</p>
                <p>Address:  {{$order->shipping->address}}</p>
                <p>City:  {{$order->shipping->zip}} {{$order->shipping->address}}</p>
                <p>Phone:  {{$order->shipping->phone1}}</p>
                <p>Phone:  {{$order->shipping->phone2}}</p>
                <p>Email:  {{$order->shipping->email}}</p>
            </div>
            <div class="col-4 pb-5">
                <h5 class="mb-4">Order Confirmation</h5>
                <h6>No.  {{$order->order_no}}/{{date('Y')}}</h6>
                <p>Date:  {{date('d.m.Y')}}</p>
                @if($order->paid_on)
                <p class="font-weight-bold">Order is paid on: {{formatDate($order->paid_on)}}</p>
                @else
                <p class="font-weight-bold">Order should be paid with cash to courier</p>
                @endif
            </div>
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
                @foreach($order->items as $item)
                <tr class="tr_bordered">
                    <td class="w_id">{{$loop->index + 1}}</td>
                    <td class="w_name">{{$item->name}}</td>
                    <td class="w_code">{{$item->acc_code}}</td>
                    <td class="w_price">{{formatPrice($item->selling_price)}}</td>
                    <td class="w_qty">{{$item->qty}}</td>
                    <td class="w_total">{{formatPrice($selling_price * $item->qty)}}</td>
                </tr>
                @endforeach


                <tr class="totals">
                    <td colspan="3"></td>
                    <td class="sub_name" colspan="2">Subtotal:</td>
                    <td class="sub_value"> {{$order->subtotal}}</td>
                </tr>
                @if($order->subtotal_with_coupon)
                <tr class="totals">
                    <td colspan="3"></td>
                    <td class="sub_name" colspan="2">Subtotal with coupon:</td>
                    <td class="sub_value"> {{$order->subtotal_with_coupon}}</td>
                </tr>
                @endif
                <tr class="totals">
                    <td colspan="3"></td>
                    <td class="sub_name" colspan="2">Shipping fee:</td>
                    <td class="sub_value"> {{$order->shipping_fee}}</td>
                </tr>

                <tr class="totals">
                    <td colspan="3"></td>
                    <td class="sub_name font-weight-bold" colspan="2">Total Payment Value:</td>
                    <td class="sub_value font-weight-bold" > {{$order->total}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-5">
            <div class="col-12 ">
                <p>This document is valid without stamp and signature</p>
            </div>
        </div>
        @if($order->shipping->comment)
        <div class="row mt-5">
            <div class="col-12 ">
                <p>Note in the order: {{$order->shipping->comment}}</p>
            </div>
        </div>
        @endif
        <div class="row mt-5">
            <div class="col-9">

            </div>
            <div class="col-3 text-center">
                <p class="font_bigger">{{$settings->person_in_charge}}</p>
                <p class="font_bigger">{{$settings->person_title}}</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>

