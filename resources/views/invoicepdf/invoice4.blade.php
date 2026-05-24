<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice</title>
    <style>
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
         @page {
            margin: 2px; /* Adjust this value as needed */
        }
        body {
            font-family: 'THSarabunNew';
            margin: auto;
            padding: 20px;
        }
        .invoice-container {
            width: 100%;
            max-width: 800px;
            /* margin: auto; */
            margin-bottom: none;
            /* border: 1px solid #000000; */
            /* box-shadow: 0 0 10px rgb(0, 0, 0); */
        }
        .header {
            width: 100%;
            margin-bottom: 0px;
        }
        .header img {
            max-width: 100px;
            margin-left: 50px;
        }
        .company-details {
            padding: 10px 5px;
        }
        .company-details h2, .company-details h4, .company-details p {
            margin: 5px 0;
        }
        .invoice-details {
            text-align: center;
            margin: 5px 0;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .content-table th, .content-table td {
            padding: 4px;
        }
        .content-table th {
            text-align: left;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            padding: 8px;
            text-align: left;
        }
        .signature-grid {
            width: 150px;
            height: 80px;
            margin-top: 10px;
            border-collapse: collapse;
        }
        .signature-cell {
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
        }
        p {
            font-size: 14px;
            margin: 0;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
         .adjacent-table {
            width: 100%;
            border: 1px solid #000;
            border-top: none;
            border-collapse: collapse;
            margin-top: -20px; /* Adjusts overlap of the borders */
        }
         .adjacent-table2 {
            width: 100%;
            border: 1px solid #000;
            border-top: none;
            border-collapse: collapse;
            margin-top: 0px; /* Adjusts overlap of the borders */
        }
         .cancel-overlay {
            position: fixed; /* Fixed position to cover the entire viewport */
            top: 250;
            left: 0;
            width: 100%;
            height: 100%;
            color: rgba(255, 0, 0); /* Red color for the text */
            opacity:0.8;
            font-size: 10em;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 9999; /* Ensure it appears above all other content */
            pointer-events: none; /* Allow interaction with underlying content */
        } 
    </style>
</head>
<body>
     @if($Invoices->inv_status  === "CANCEL")
        <div class="cancel-overlay">CANCEL
             <p style="font-size: 30px;">{{ $Invoices->inv_remark }}</p>
        </div>
    @endif 
    <div class="invoice-container">
        <table class="header" style="padding-bottom:15px">
            <tr>
                <td style="vertical-align: top; ">
                    <img style="margin-left:30px" src="{{ asset('/nuam.jpg') }}" alt="Company Logo">
                </td>
                <td class="company-details" style="vertical-align: top;padding-left:30%">
                    <p style="margin: 0px; font-weight: bold; font-size:24px;line-height:15px;">บริษัท นวม จำกัด</p>
                    <p style="margin: 0px; font-weight: bold; font-size:20px;line-height:15px;">NUAM CO., LTD</p>
                    <p style="margin: -1px">185/2 ซอยสุขุมวิท 31 ถนนสุขุมวิท แขวงคลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร 10110</p>
                    <p style="margin: -1px">185/2 Soi Sukhumvit 31 Rd. Nort Khlongton, Watthana, Bangkok, Thailand 10110</p>
                    <p style="margin: -1px">Tel: 0-2264-2245-7 Fax: 0-2264-2248</p>
                    <p style="margin: -1px">เลขประจำตัวผู้เสียภาษี 0105565185083&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงานใหญ่(Head Office)</p>
                </td>
                <td class="blank-column">
                    <p><span class="page-number"></span></p>
                </td>
            </tr>
        </table>
        <div class="invoice-details" style="padding-bottom: 8px">
            <p style="margin: -5px;font-size:24px;line-height:10px;"><strong>ใบแจ้งหนี้</strong></p>
            <p style="margin: -5px;font-size:24px;line-height:18px"><strong>ORIGINAL INVOICE</strong></p>
            <p style="margin: -5px;font-size:24px;line-height:18px"><strong>(ต้นฉบับ)</strong></p>
        </div>
        <table style="width:100%; border: 1px solid #000; border-collapse: collapse;">
            <tbody>
                <tr >
                    <td style="width:544px; vertical-align:top;">
                      <table style="width: 100%; border-collapse: collapse;margin:0">
                        <tr>
                            <td style="vertical-align: top; font-size: 18px;width:19%; ">
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">เลขที่สัญญา</p>
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">CONTRACT NO.</p>
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">ชื่อลูกค้า</p>
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">ACCOUNT NAME</p>
                            </td>
                            <td style="vertical-align: top; font-size: 18px;width:43% ">
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">{{ $Invoices->customerrental->custr_contract_no_real ?? "-" }}</p>
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;"><br></p>
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">{{ $Invoices->customer->cust_name_th }}</p>

                            </td>
                            <td style="vertical-align: top; font-size: 18px; ;">
                                <p style="margin: 0; font-size: 18px; line-height: 0.7;">พื้นที่เลขที่ {{ $Invoices->inv_unite ?? $Invoices->customerrental->custr_unit ?? null }}</p>
                            </td>
                        </tr>
                    </table> 
                    </td>

                    <td style="height: 2px; border:1px solid #000; margin:0px; vertical-align:top">
                        <p style="font-size: 18px">วันที่</p>
                        <p style="font-size: 18px;line-height:0.8">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::parse($Invoices->inv_date)->format('d/m/Y') }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="height:60px; vertical-align:top;">
                    <p style="font-size: 18px">ที่อยู่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        {{
                        $Invoices->customer->cust_address_th1
                        }}</p>   
                    <p style="font-size: 18px">Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{
                        $Invoices->customer->cust_address_th2
                        }}
                         {{$Invoices->customer->cust_zipcode}}
                        </p>   
                    </td>
                    <td style="vertical-align:top;width: 40%; border:1px solid #000; margin:0px;">
                        <p style="font-size: 18px">เลขที่ใบแจ้งหนี้</p>
                        <p style="font-size: 18px">No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $Invoices->inv_no }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="height: 60px; vertical-align:top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลขประจำตัวผู้เสียภาษี&nbsp;{{ $Invoices->customer->cust_taxid }}&nbsp;
                        {{ $Invoices->customer->cust_branch }}
                    </td>
                    <td style="vertical-align:top; width: 40%; border:1px solid #000; margin:0px;">
                        <p style="font-size: 18px">กำหนดชำระภายในวันที่</p>
                       <p style="font-size: 18px;">DUE DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{\Carbon\Carbon::parse($Invoices->invd_duedate)->format('d/m/Y')}}</p> 
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="content-table" style="border: 1px solid #000">
            <thead>
                <tr style="text-align: center;">
                    <th style="text-align: center;padding:10px; line-height:8px; border: 1px solid #000;border-top: none;">รายการ<br style="margin: 0">Description</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">ประจำเดือน<br>Period</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">จำนวนเงิน<br>Gross Amount</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">ภาษีมูลค่าเพิ่ม
                        <br><span style="white-space: nowrap;">Value Added Tax</span></th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">จำนวนเงินสุทธิ<br>Net Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 200px;">
                    <td style="height:390px;width: 280px;min-width:280px;max-width:280px; border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;vertical-align:top; border-collapse: collapse;">
                        @foreach ( $Invoices->invoicedetail as $index => $invoice )
                            <div style="font-size: 18px; position: relative; padding-right: 100px;">
                                <span style="white-space: nowrap">
                                    {{ $index + 1}}. {{ $invoice->invd_product_name }}
                                </span>
                                @if ($invoice->invd_remake)
                                    <span style="position: absolute; left: 0; top: 0; white-space: nowrap; transform: translateY(50%);">
                                        &nbsp;&nbsp;&nbsp; - {{ $invoice->invd_remake }}
                                    </span> 
                                @endif
                            </div> 
                        @endforeach
                    </td>
                    <td style="width: 140px; text-align: center; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                        @foreach ( $Invoices->invoicedetail as $invoice )
                            <p style="font-size: 18px">{{ $invoice->invd_period }}</p>
                        @endforeach
                       </td>
                    <td style="width:100px;text-align: right; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                         @foreach ( $Invoices->invoicedetail as $invoice )
                            <p style="font-size: 18px" >{{ number_format($invoice->invd_amt,2,'.',',') }}</p>
                        @endforeach
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                         @foreach ( $Invoices->invoicedetail as $invoice )
                            <p style="font-size: 18px" >{{ number_format($invoice->invd_vat_amt,2,'.',',')}}</p>
                        @endforeach
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                         @foreach ( $Invoices->invoicedetail as $invoice )
                            <p style="font-size: 18px" >{{ number_format($invoice->invd_net_amt,2,'.',',')}}</p>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-left: none"></td>
                    <td style="text-align: right; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;border-left:1px solid #000">
                           <p style="font-size: 18px">{{ number_format($Invoices->invoicedetail->sum('invd_amt'),2,'.',',') }}</p>
                   </td>
                   <td style="text-align: right; border-bottom: 1px solid #000;border-right:1px solid #000;vertical-align:top;">
                           <p style="font-size: 18px" >{{ number_format($Invoices->invoicedetail->sum('invd_vat_amt'),2,'.',',') }}</p>
                   </td>
                   <td style="text-align: right; border-bottom: 1px solid #000;vertical-align:top;">
                           <p style="font-size: 18px">{{ number_format($Invoices->invoicedetail->sum('invd_net_amt'),2,'.',',') }}</p>
                   </td>
                </tr>
            </tbody>
        </table>
       <table class="adjacent-table">
        <tr>
             <td style="width:58.5%; height:30px; text-align:center;">
                <p style="font-size: 18px">({{ $bath }})</p>
             </td>
             <td style="width: 29.6%; text-align:center; line-height:8px">
                <p style="font-size: 16px">รวมเป็นเงิน<br style="">TOTAL AMOUNT</p>
             </td>
             <td style="border-left: 1px solid #000;text-align:right;font-size:18px">{{ number_format($Invoices->invoicedetail->sum('invd_net_amt'),2,'.',',') }}</td>
        </tr>
        </table>
        <table class="adjacent-table2">
        <tr>
             <td style="width:58.5%;border-right: 1px solid #000; height:90px; text-align:center;">
                <p></p>
             </td>
             <td style="border-left: 1px solid #000;text-align:center;">
                <p>........................................................................................................<br>ผู้มีอำนาจลงนาม AUTHORIZED SIGNATURE</p>
             </td>
        </tr>
        </table>
        
 
    </div>
</body>
</html>