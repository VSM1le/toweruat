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
        <table style="width: 100%;">
            <thead>
                <tr>
                    <!-- Empty cell for left alignment -->
                    <th style="background-color:white; width: 33%;"></th>
                    
                    <!-- Middle content -->
                    <th style="text-align: center; background-color:white; width: 33%;">
                        <p>บริษัท นวม จำกัด</p>
                        <p style="line-height: 10px">รายงานใบเสร็จรับเงิน 
                        <p style="line-height: 10px">{{ $startDate }} - {{ $endDate }}</p>
                    </th>
                    
                    <!-- Page number aligned to the right -->
                    <th style="text-align: right; background-color:white; width: 33%; vertical-align:top;">
                        <span>Page {{ $currentPage }}/{{ $sumPage }}</span>
                    </th>
                </tr>
            </thead>
        </table> 
        <table style="margin:0;border:1px solid black;">
            <thead>
                <tr style="background-color: yellow; height:15px">
                    <th class="th-inv">No.</th>
                    <th class="th-inv">Receipt No.</th>
                    <th class="th-inv">Invoice No.</th>
                    <th class="th-inv">Receipt Date</th>
                    <th class="th-inv" style="max-width:150px">Customer Name</th>
                    <th class="th-inv">Contract Number</th>
                    <th class="th-inv" style="max-width:70px">Product Name</th>
                    <th class="th-inv" style="width:70px">Amt</th>
                    <th class="th-inv">Vat Amt</th>
                    <th class="th-inv">Whtax Amt</th>
                    <th class="th-inv" style="width: 70px">Paid Amt</th>
                    <th class="th-inv">
                        <p>Receipt </p>
                        <p style="line-height: 10px">Status</p>
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($filteredDetails as $detail )
                @if ($detail->receiptheader->rec_have_inv_flag != "0")
                <tr style="vertical-align: top;@if($detail->receiptheader->rec_status == 'Cancel') color: red; @endif">
                    <td class="td-inv" style="height: 15px; vertical-align: top;">
                       <p class="test">{{ $loop->iteration }}</p>
                    </td>
                    <td class="td-inv" style="height: 15px; vertical-align: top;">
                       <p class="test">{{ $detail->receiptheader->rec_no ?? null }}</p>
                    </td>
                    <td class="td-inv" style="height: 15px; vertical-align: top;">
                       <p class="test">{{ $detail->invoicedetail->invoiceheader->inv_no ?? null }}</p>
                    </td>
                    <td class="td-inv"tyle="text-align: center">
                        <p class="test">
                            {{  Carbon\Carbon::parse($detail->receiptheader->rec_date)->format('d-m-Y') ?? null }}
                        </p>
                    </td>
                    <td class="td-inv">
                        <p class="test">{{ Str::limit($detail->receiptheader->customer->cust_name_th ?? null,35) }}</p> 
                    </td>
                    <td class="td-inv">
                        <p class="test">{{ $detail->invoicedetail->invoiceheader->customerrental->custr_contract_no ?? null}}</p>
                    </td>
                    <td class="td-inv">
                        <p class="test">{{ Str::limit($detail->invoicedetail->invd_product_name ?? $detail->recd_product_name ,25) }}</p> 
                    </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">
                            {{ number_format(round($detail->rec_pay * (100 / (100 + $detail->invoicedetail->invd_vat_percent)),2) ?? 0, 2, '.', ',') }}
                        </p>
                    </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">
                            {{ number_format($detail->rec_pay - round($detail->rec_pay * (100 / (100 + $detail->invoicedetail->invd_vat_percent)),2)?? 0,2,'.',',')}}
                        </p>
                        </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->whpay ?? 0,2,'.',',')}}</p>
                    </td>
                     <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->rec_pay ?? 0,2,'.',',')}}</p>
                    </td>
                    <td class="td-inv"style="text-align: center">
                       <p class="test">{{ $detail->receiptheader->rec_status ?? null }}</p>
                    </td>
                </tr>
 
                @else 
                <tr style="vertical-align: top;@if($detail->receiptheader->rec_status == 'Cancel') color: red; @endif">
                    <td class="td-inv" style="height: 15px; vertical-align: top;">
                       <p class="test">{{ $loop->iteration }}</p>
                    </td>
                    <td class="td-inv" style="height: 15px; vertical-align: top;">
                       <p class="test">{{ $detail->receiptheader->rec_no }}</p>
                    </td>
                    <td class="td-inv" style="height: 15px; vertical-align: top;">
                       <p class="test">-</p>
                    </td>
                    <td class="td-inv"tyle="text-align: center">
                        <p class="test">{{  Carbon\Carbon::parse($detail->receiptheader->rec_date)->format('d-m-Y') ?? null }}</p>
                    </td>
                    <td class="td-inv">
                        <p class="test">{{ Str::limit($detail->receiptheader->customer->cust_name_th ?? null,35) }}</p> 
                    </td>
                    <td class="td-inv">
                        <p class="test">{{ $detail->receiptheader->customerrental->custr_contract_no ?? null }}</p>
                    </td>
                    <td class="td-inv">
                        <p class="test">{{ Str::limit($detail->recd_product_name ,25) }}</p> 
                    </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->recd_amt ?? 0, 2, '.', ',') }}</p>
                    </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->recd_vat_amt ?? 0,2,'.',',')}}</p>
                        </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->wh_pay ?? 0,2,'.',',')}}</p>
                    </td>
                     <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->rec_pay ?? 0,2,'.',',')}}</p>
                    </td>
                    <td class="td-inv"style="text-align: center">
                       <p class="test">{{ $detail->receiptheader->rec_status ?? null }}</p>
                    </td>
                </tr>
                @endif
                @endforeach
                @for($i = count($filteredDetails);$i < 29; $i++)
                <tr>
                    <td class="td-inv" style="height: 15px"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                </tr>
                @endfor
            </tbody>
        </table>
        @if ($currentPage === $sumPage)
         <table style="margin-top: 5px; width:0%">
             <tbody>
                <tr >
                    <th style="background-color:white; width:250px">
                        Paid Amount : {{ number_format($sumValidReceipt ?? 0,2,'.',',') }} 
                    </th>
                    <th style="text-align: center; background-color:white; width:250px">
                        Cancel Amount : {{ number_format($sumCancelReceipt ?? 0,2,'.',',') }} 
                    </th>
                </tr>
             </tbody>
        </table>
        @endif
    </div>
</body>
</html>