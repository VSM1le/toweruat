<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landscape Report</title>
    <style>
        @page {
            size: A4 landscape; /* This sets the page size to A4 in landscape */
            margin: 10mm; /* Adjust the margins as needed */
        }
        @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew Bold.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: bold;
        }
        @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew Italic.ttf') }}') format('truetype');
            font-weight: italic;
            font-style: normal;
        }
        @font-face {
            font-family: 'THSarabunNew';
            src: url('{{ url('/fonts/THSarabunNew BoldItalic.ttf') }}') format('truetype');
            font-weight: italic;
            font-style: bold;
        }

        body {
            font-family: 'THSarabunNew';
            margin: 0;
            padding: 0;
        }

        .report-container {
            width: 100%;
        }
        .th-inv{
            background-color: yellow;
            text-align: center;
            border: 1px solid black;
            line-height: 10px;
            margin: 0;
            padding: 0;
        }
        .td-inv{
            border: 1px solid black;
        }
        .test{
            line-height: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
/* 
        table, th, td {
            border: 1px solid black;
        }
 */
        th, td {
            /* padding: 8px; */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
        p{
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="report-container">
        {{-- <h1>บริษัท นวม จำกัด</h1> --}}
        {{-- <h2>รายงานใบเเจ้งหนี้บัญชี</h2> --}}
        <table>
             <thead>
                <tr >
                    <th style="background-color:white;"></th>
                    <th style="text-align: center; background-color:white;">
                        <p>บริษัท นวม จำกัด</p>
                        <p style="line-height: 10px">Credit Note report</p>
                        <p style="line-height: 10px">{{$dateFrom}} - {{$dateTo}}</p>
                    </th>
                    <th style="background-color:white;"></th>
                </tr>
            </thead>
        </table>
        <table style="margin:0;border:1px solid black;">
            <thead>
                <tr style="background-color: yellow; height:15px">
                    <th class="th-inv">No.</th>
                    <th class="th-inv">Credit No</th>
                    <th class="th-inv">Credit Date</th>
                    <th class="th-inv"style="width:200px">Customer Name</th>
                    <th class="th-inv">Receipt number</th>
                    <th class="th-inv">Receipt date</th>  
                    <th class="th-inv">Amount</th>
                    <th class="th-inv">Tax amount</th>
                    <th class="th-inv">Wh amount</th>
                    <th class="th-inv">Net Amount</th>
                    <th class="th-inv">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($creditNotes as $creditNote )
                @foreach ($creditNote->creditdetail as $detail)
                    <tr style="vertical-align: top;@if($creditNote->credit_status === 0) color: red; @endif">
                        <td class="td-inv" style="height: 15px; vertical-align: top;">
                            <p class="test">{{ $loop->iteration }}</p>
                        </td>
                        <td class="td-inv" style="height: 15px; vertical-align: top;">
                            <p class="test">{{ $creditNote->credit_no?? null }}</p>
                        </td>
                        <td class="td-inv" style="height: 15px; vertical-align: top;">
                            <p class="test">{{  Carbon\Carbon::parse($creditNote->credit_date)->format('d-m-Y') ?? null  }}</p>
                        </td> 
                        <td class="td-inv" style="text-align: left;">
                            <p class="test">{{ Str::limit($creditNote->customer->cust_name_th ?? null,35) }}</p>
                        </td>
                         <td class="td-inv" style="text-align: left;">
                            <p class="test">{{ $creditNote->credit_receipt_num ?? null }}</p>
                        </td>
                         <td class="td-inv" style="height: 15px; vertical-align: top;">
                            <p class="test">{{  Carbon\Carbon::parse($creditNote->credit_receipt_date)->format('d-m-Y') ?? null  }}</p>
                        </td> 
                        <td class="td-inv">
                            <p class="test" style="text-align:center;">{{ number_format($detail->crd_amt ?? 0,2,'.',',') }}</p> 
                        </td>
                        <td class="td-inv">
                            <p class="test" style="text-align:center;">{{ number_format($detail->crd_tax_amt ?? 0,2,'.',',')}}</p>
                        </td>
                        <td class="td-inv">
                            <p class="test" style="text-align:center;">{{ number_format($detail->crd_wh_amt ?? 0,2,'.',',')}}</p>
                        </td>
                         <td class="td-inv">
                            <p class="test" style="text-align:center;">{{ number_format($detail->crd_net_amt ?? 0,2,'.',',')}}</p>
                        </td>
                         <td class="td-inv">
                            <p class="test"style="text-align:center;">
                                @if($creditNote->credit_status === 1)
                                    USE
                                @else
                                    CANCEL
                                @endif
                            </p>
                        </td>
                    @endforeach
                    @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>