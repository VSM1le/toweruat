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
        <table>
             <thead>
                <tr >
                    <th style="background-color:white;"></th>
                    <th style="text-align: center; background-color:white;">
                        <p>บริษัท นวม จำกัด</p>
                        <p style="line-height: 10px">รายงานใบเเจ้งหนี้บัญชี</p>
                    </th>
                    <th style="background-color:white;"></th>
                </tr>
            </thead>
        </table>
        <table style="margin:0;border:1px solid black;">
            <thead>
                <tr style="background-color: yellow; height:15px">
                    <th class="th-inv">No.</th>
                    <th class="th-inv">Invoice No.</th>
                    <th class="th-inv">Invoice Date</th>
                    <th class="th-inv" style="width:200px">Customer Name</th>
                    <th class="th-inv">Contrat Number</th>
                    <th class="th-inv" style="width:70px">Amt</th>
                    <th class="th-inv">Vat Amt</th>
                    <th class="th-inv">Whtax Amt</th>
                    <th class="th-inv" style="width: 70px">Net Amt</th>
                    <th class="th-inv">Due Date</th>
                    <th class="th-inv">Status</th>
                    <th class="th-inv">Paided Amount</th>
                    <th class="th-inv">Over due</th>
                    <th class="th-inv">Remark</th>
                    <th class="th-inv">
                        <p>Invoice</p>
                        <p style="line-height: 10px">Status</p>
                    </th>

                </tr>
            </thead>
            <tbody>
              @foreach ($filteredDetails as $detail )
                <tr style="vertical-align: top;@if($detail->invoiceheader->inv_status == 'CANCEL') color: red; @endif">
                    <td class="td-inv" style="height: 15px; vertical-align: top;">
                       <p class="test">{{ $loop->iteration }}</p>
                    </td>
                    <td class="td-inv" style="height: 15px; vertical-align: top;">
                       <p class="test">{{ $detail->invoiceheader->inv_no ?? null }}</p>
                    </td>
                    <td class="td-inv"tyle="text-align: center">
                        <p class="test">{{ $detail->invoiceheader->inv_date ?? null }}</p>
                    </td>
                    <td class="td-inv">
                        <p class="test">{{ Str::limit($detail->invoiceheader->customer->cust_name_th ?? null,35) }}</p> 
                    </td>
                    <td class="td-inv">
                        <p class="test">{{ $detail->invoiceheader->customerrental->custr_contract_no ?? null }}</p>
                    </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->invd_amt ?? 0, 2, '.', ',') }}</p>
                    </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->invd_vat_amt ?? 0,2,'.',',')}}</p>
                        </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->invd_wh_tax_amt ?? 0,2,'.',',')}}</p>
                    </td>
                     <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->invd_net_amt ?? 0,2,'.',',')}}</p>
                    </td>
                    <td class="td-inv" style="text-align: center">
                        <p class="test">{{ $detail->invoiceheader->invd_duedate ?? null }}</p>
                    </td>
                    <td class="td-inv" style="text-align: center">
                        <p class="test">{{ $detail->invd_receipt_flag ?? null}}</p>
                    </td>
                    <td class="td-inv">
                        <p class="test" style="text-align: right">{{ number_format($detail->invd_receipt_amt ?? 0,2,'.',',')}}</p>
                    </td>
                    <td class="td-inv">
                       <p class="test" style="text-align: center">
                        {{ $detail->overdue }}
                       </p>
                    </td>
                    <td class="td-inv">
                       <p class="test">{{ $detail->invd_remark ?? null}}</p>
                    </td>
                    <td class="td-inv"style="text-align: center">
                       <p class="test">{{ $detail->invoiceheader->inv_status ?? null }}</p>
                    </td>
                </tr>
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
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                    <td class="td-inv"></td>
                </tr>
                @endfor
            </tbody>
        </table>
        @if ($sumInvoice)
         <table style="margin-top: 5px; width:0%">
             <tbody>
                <tr >
                    <th style="background-color:white; width:150px">
                        Amount : {{ number_format($sumInvoice->amount ?? 0,2,'.',',') ?? null }} 
                    </th>
                    <th style="text-align: center; background-color:white; width:150px">
                        Vat Amount : {{ number_format($sumInvoice->vatAmt ?? 0,2,'.',',') ?? null }}
                    </th>
                    <th style="background-color:white;width:150px">
                        Wh Amount : {{ number_format($sumInvoice->whAmt ?? 0,2,'.',',') ?? null }}
                    </th>
                    <th style="background-color:white;width:150px">
                        Net Amount : {{ number_format($sumInvoice->netAmt ?? 0,2,'.',',') ?? null }}
                    </th>
                     <th style="background-color:white;width:150px">
                        มี invoice ทั้งหมด {{ $countInvoice ?? 0 }} ฉบับ 
                    </th>
                </tr>
             </tbody>
        </table>
        @endif
    </div>
</body>
</html>