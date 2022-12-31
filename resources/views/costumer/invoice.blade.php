<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order[0]->invoice }}</title>

    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: normal; /* inherit */
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }

    div.text-center {
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.flaticon.com%2Ffree-icon%2Fprofile_1250689&psig=AOvVaw1cxwZzQPQH1ChQZ5QMG8Cb&ust=1671768895064000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCOi98suujPwCFQAAAAAdAAAAABAD" width="150px">
                            </td>

                            <td>
                                Invoice : <strong>#{{ $order[0]->invoice }}</strong><br>
                                {{ $order[0]->created_at }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>PENERIMA</strong><br>
                                {{ $order[0]->customer_name }}<br>
                                {{ $order[0]->customer_phone }}<br>
                                {{ $order[0]->customer_address }}<br>
                                {{ $order[0]->district->name }}, {{$citie[0]->name}}<br>
                                {{$citie[0]->postal_code}}

                            </td>

                            <td>
                                <strong>PENGIRIM</strong><br>
                                Apik<br>
                                08113568277<br>
                                Cosmy Tanglin and Orchard Apartment<br>
                                Babatan, Wiyung<br>
                                Surabaya Barat
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Produk</td>
                <td>Subtotal</td>
            </tr>

            @foreach ($order_detail as $row)
            <tr class="item">
                <td>
                    {{$row->product->name}}<br>
                    <strong>Harga</strong>: Rp. {{number_format($row->price)}} x {{$row->qty}}
                </td>
                <td>Rp. {{number_format($row->price * $row->qty)}}</td>
            </tr>
            @endforeach
            <tr class="item">
                <td><strong>Ongkir</strong></td>
                <td>Rp. {{number_format($order[0]->shipping)}}</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>
                   Total: Rp {{number_format($order[0]->cost)}}
                </td>
            </tr>

        </table>
        <hr>
        <div class="text-center">
            <h5>*:Pemabayaran dilakukan dengan transfer ke No.Rek (070-00-01877775)</h5>
        </div>
    </div>
</body>
</html>
