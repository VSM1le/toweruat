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
                        <p style="line-height: 10px">รายงานลูกค้า</p>
                        <p style="line-height: 10px"></p>
                    </th>
                    <th style="background-color:white;"></th>
                </tr>
            </thead>
        </table>
        <table style="margin:0;border:1px solid black;">
            <thead>
                <tr style="background-color: yellow; height:15px">
                    <th class="th-inv">No.</th>
                    <th class="th-inv">Cust Code</th>
                    <th class="th-inv"style="width:200px">Th Name</th>
                    <th class="th-inv" style="width:200px">En Name</th>
                    <th class="th-inv">Tax ID</th>
                    <th class="th-inv">Address 1</th>
                    <th class="th-inv">Address 2</th>
                    <th class="th-inv">Zip code</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr style="vertical-align: top;">
                        <td class="td-inv" style="height: 15px; vertical-align: top;">
                            <p class="test">{{ $loop->iteration }}</p>
                        </td>
                        <td class="td-inv" style="height: 15px; vertical-align: top;">
                            <p class="test">{{ $customer->cust_code ?? null }}</p>
                        </td>
                        <td class="td-inv" style="text-align: left;">
                            <p class="test">{{ $customer->cust_name_th ?? null }}</p>
                        </td>
                        <td class="td-inv">
                            <p class="test">{{ $customer->cust_name_en ?? null }}</p> 
                        </td>
                        <td class="td-inv">
                            <p class="test">{{ $customer->cust_taxid ?? null }}</p>
                        </td>
                        <td class="td-inv">
                            <p class="test">{{ $customer->cust_address_th1 ?? null }}</p>
                        </td>
                         <td class="td-inv">
                            <p class="test">{{ $customer->cust_address_th2 ?? null }}</p>
                        </td>
                         <td class="td-inv">
                            <p class="test">{{ $customer->cust_zipcode?? null }}</p>
                        </td>
                    @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>