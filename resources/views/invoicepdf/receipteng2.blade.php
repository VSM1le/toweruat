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
        .custom-checkbox {
            position: relative;
            display: inline-block;
            width: 20px;
            height: 20px;
        }

        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .custom-checkbox span {
            position: absolute;
            top: 0;
            left: 0;
            width: 20px;
            height: 20px;
            background-color: #ccc;
            border-radius: 3px;
        }

        .custom-checkbox input[type="checkbox"]:checked + span {
            background-color: #2196F3;
            border: 2px solid #000; /* Make the checkbox thicker */
        }

        .custom-checkbox span:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-checkbox input[type="checkbox"]:checked + span:after {
            display: block;
        }

        .custom-checkbox span:after {
            left: 7px;
            top: 3px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }
    </style>
</head>
<body>
     @if($Receipt->rec_status=== "Cancel")
        <div class="cancel-overlayy" style="color: rgba(255, 0, 0);">CANCEL
            <p style="font-size: 30px;">{{$Receipt->rec_remark ?? null}}</p>
        </div>
    @endif 
    <div class="invoice-container">
        <table class="header" style="padding-bottom:15px">
            <tr>
                <td style="vertical-align: top; ">
                    <img style="margin-left:30px" src="{{ asset('/nuam.jpg') }}" alt="Company Logo">
                </td>
                <td class="company-details" style="vertical-align: top;padding-left:30%">
                    <p style="margin: 0px; font-weight: bold; font-size:24px;line-height:19px;">บริษัท นวม จำกัด</p>
                    <p style="margin: 0px; font-weight: bold; font-size:20px;line-height:10px;">NUAM CO., LTD</p>
                    <p style="margin: -1px">185/2 ซอยสุขุมวิท 31 ถนนสุขุมวิท แขวงคลองตันเหนือ เขตวัฒนา กรุงเทพมหานคร 10110</p>
                    <p style="margin: -1px">185/2 Soi Sukhumvit 31 Rd. Nort Khlongton, Watthana, Bangkok, Thailand 10110</p>
                    <p style="margin: -1px">Tel: 0-2264-2245-7 Fax: 0-2264-2248</p>
                    <p style="margin: -1px">เลขประจำตัวผู้เสียภาษี 0105565185083&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สำนักงานใหญ่(Head Office)</p>
                </td>
                <td class="blank-column" style="vertical-align:top">
                    <p style=""><span class="page-number">page{{ $currentPage }}/{{ $sumPage }}</span></p>
                </td>
            </tr>
        </table>
        <div class="invoice-details" style="padding-bottom: 8px">
            <p style="margin: -5px;font-size:24px;line-height:10px;"><strong>สำเนาใบเสร็จรับเงิน/สำเนาใบกำกับภาษี</strong></p>
            <p style="margin: -5px;font-size:24px;line-height:18px"><strong>COPY RECEIPT / TAX INVOICE</strong></p>
            <p style="margin: -5px;font-size:24px;line-height:18px"><strong>(บัญชี)</strong></p>
        </div>
        <table style="width:100%; border: 1px solid #000; border-collapse: collapse;">
            <tbody>
                <tr >
                    <td style="width:544px; vertical-align:top;">
                    <table style="width: 100%; border-collapse: collapse;margin:0">
                        <tr>
                            <td style="vertical-align: top; font-size: 18px;width:19%; ">
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">ได้รับเงินจาก</p>
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">Received From</p>
                            </td>
                            <td style="vertical-align: top; font-size: 18px;width:49% ">
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">{{ $Receipt->customer->cust_name_en ?? null }}</p>
                            </td>
                            <td style="vertical-align: top; font-size: 18px; ;">
                                <p style="margin: 0; font-size: 18px; line-height: 0.7;">เลขที่สัญญา {{ $Receipt->receiptdetail->first()->invoicedetail->invoiceheader
                                ->customerrental->custr_contract_no_real ?? null}}</p>
                            </td>
                        </tr>
                    </table> 
                    </td>

                    <td style="height: 2px; border:1px solid #000; margin:0px; vertical-align:top">
                        <p style="font-size: 18px; line-height:0.8">เลขที่ใบเสร็จ</p>
                        <p style="font-size: 18px; line-height:0.8">No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$Receipt->rec_no}}</p>
                    </td>
                </tr>
                <tr>
                    <td style="height:10px; vertical-align:top;">
                    <p style="font-size: 18px">ที่อยู่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        {{
                        $Receipt->customer->cust_address_th1
                        }}</p>   
                    <p style="font-size: 18px; line-height:0.8">Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{
                        $Receipt->customer->cust_address_th2
                        }}
                        {{$Receipt->customer->cust_zipcode}}
                        </p>   
                    </td>
                    <td style="vertical-align:top;width: 40%; border:1px solid #000; margin:0px;">
                        <p style="font-size: 18px; line-height:0.8">วันที่</p>
                        <p style="font-size: 18px; line-height:0.8">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{  \Carbon\Carbon::parse($Receipt->rec_date)->format('d/m/Y')}}</p>
                    </td>
                </tr>
                <tr>
                    <td style="height: 40px; vertical-align:top; font-size:18px;line-height:0.8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลขประจำตัวผู้เสียภาษี&nbsp;{{ $Receipt->customer->cust_taxid }}&nbsp;
                        {{ $Receipt->customer->cust_branch }}
                    </td>
                    <td style="vertical-align:top; width: 40%; border:1px solid #000; margin:0px;">
                    <table style="width: 100%; border-collapse: collapse;margin:0">
                        <tr>
                            <td style="vertical-align: top; font-size: 18px;width:19%; ">
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">พื้นที่เลขที่</p>
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">Plan No.</p>
                            </td>
                            <td style="vertical-align: top; font-size: 18px;width:49% ">
                                <p style="margin: 0; line-height: 0.7; font-size: 18px;">{{ $Receipt->receiptdetail->first()->invoicedetail->invoiceheader
                                ->inv_unite ?? $Receipt->receiptdetail->first()->invoicedetail->invoiceheader
                                ->customerrental->custr_unit ?? null}}</p>
                            </td>
                        </tr>
                    </table> 
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="content-table" style="border: 1px solid #000">
            <thead>
                <tr style="text-align: center;">
                    <th style="text-align: center;padding:10px; line-height:8px; border: 1px solid #000;border-top: none;">รายการ<br style="margin: 0">Description</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">จำนวนเงิน<br>Gross Amount</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">ภาษีมูลค่าเพิ่ม<br>Value Added Tax</th>
                    <th style="text-align: center; padding:10px; line-height:8px;border: 1px solid #000;border-top: none;">จำนวนเงินสุทธิ<br>Net Amount</th>
                </tr>
            </thead>
            @if ($Receipt->rec_have_inv_flag == '0')
             <tbody>
                <tr style="height: 200px;">
                    <td style="height:250px;width: 320px; border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;vertical-align:top; border-collapse: collapse;">
                         @foreach ($receiptdetails as $index => $receipt)
                            <div style="font-size: 18px; position: relative; padding-right: 100px;">
                                <span style="white-space: nowrap">
                                    {{$index + 1}} . {{App\Models\ProductService::where('ps_code', $receipt->recd_product_code)->pluck('ps_name_en')->first() ?? null }} 
                                </span>

                                @if ($receipt->recd_remark)
                                  <span style="position: absolute; left: 0; top: 0; white-space: nowrap; transform: translateY(50%);">
                                    &nbsp;&nbsp;&nbsp; - {{ $receipt->recd_remark}} 
                                    </span>
                                @endif
                            </div> 
                        @endforeach
                    </td>
                   <td style="vertical-align: top; width: 100px; text-align: right; border-right: 1px solid #000;">
                        @foreach ( $receiptdetails as $receiptdetail)
                            <p style="font-size: 18px; margin: 0;">{{ number_format($receiptdetail->recd_amt,2,'.',',') }}</p>
                        @endforeach
                    </td> 
                    <td style="text-align: right; border-right:1px solid #000;vertical-align:top;width:100px">
                         @foreach ( $receiptdetails as $receiptdetail)
                            <p style="font-size: 18px" >{{ number_format($receiptdetail->recd_vat_amt,2,'.',',')}}</p>
                        @endforeach
                    </td>
                    <td style="text-align: right; border-right:1px solid #000;vertical-align:top;width:100px">
                         @foreach ( $receiptdetails as $receipt)
                            <p style="font-size: 18px" >{{ number_format($receipt->rec_pay,2,'.',',')}}</p>
                        @endforeach
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr style="">
                   <td style="height:100px;border:1px solid #000; vertical-align:top;font-size:18px">
                        <p style="font-size: 18px;line-height:0.8">
                            มูลค่าที่ได้รับยกเว้นภาษีมูลค่าเพิ่ม
                            <span style="float: right;clear:both;padding-right:15px">
                                @if ($currentPage == $sumPage)
                                {{ number_format($Receipt->receiptdetail
                                    ->filter(function ($detail) {
                                        return $detail->recd_vat_percent == 0;
                                    })
                                    ->pluck('recd_amt')
                                    ->sum(), 2, '.', ',') }}
                                @endif
                            </span> 
                        </p>
                        <p style="font-size:18px;line-height:0.8">มูลค่าที่รวมภาษีมูลค่าเพิ่ม
                            <span style="float: right;clear:both;padding-right:15px">
                                @if ($currentPage == $sumPage)
                                {{ number_format($Receipt->receiptdetail
                                    ->filter(function ($detail) {
                                        return $detail->recd_vat_percent != 0;
                                    })
                                    ->sum('rec_pay'), 2, '.', ',') }}
                                @endif
                            </span>
                        </p>
                        <p style="font-size:18px;line-height:0.8">
                            &nbsp;&nbsp;&nbsp;&nbsp;-มูลค่าที่เสียภาษีมูลค่าเพิ่ม
                            <span style="float: right;clear:both;padding-right:15px">
                                @if ($currentPage == $sumPage)
                                {{ number_format($Receipt->receiptdetail
                                    ->filter(function ($detail) {
                                        return $detail->recd_vat_percent != 0;
                                    })
                                    ->sum('recd_amt'), 2, '.', ',') }}
                                @endif
                            </span>
                        </p>
                        <p style="font-size:18px;line-height:0.8">
                            &nbsp;&nbsp;&nbsp;&nbsp;-ภาษีมูลค่าเพิ่ม
                            <span style="float: right;clear:both;padding-right:15px">
                                @if ($currentPage == $sumPage)
                                {{ number_format($Receipt->receiptdetail
                                    ->pluck('recd_vat_amt')
                                    ->sum(), 2, '.', ',') }}
                                @endif
                            </span>
                        </p>
                        <p style="font-size:18px;line-height:0.8">
                            มูลค่าที่ไม่อยู่ในข้อบังคับภาษีมูลค่าเพิ่ม
                        </p>
                    </td> 
                    <td style="border-right:solid 1px #000">

                    </td>
                    <td style="border-right:solid 1px #000">
                    </td>
                    <td style="">

                    </td>
                </tr>
                <tr style="">
                     <td style="border:1px solid #000; {{ $currentPage != $sumPage ? 'height: 20px;' : '' }}">
                        @if ($currentPage == $sumPage)
                            <p style="font-size: 18px;line-height:0.5">{{ $bath }} </p>
                        @endif
                    </td>
                    <td style="border:1px solid #000; text-align:right">
                        <p style="font-size: 18px">
                            @if ($currentPage == $sumPage)
                                {{  number_format($Receipt->receiptdetail->pluck('recd_amt')->sum(),2,'.',',') }}
                            @endif
                        </p>
                    </td>
                    <td style="border:1px solid #000; text-align:right">
                    <p style="font-size: 18px">
                            @if ($currentPage == $sumPage)
                                {{  number_format($Receipt->receiptdetail->pluck('recd_vat_amt')->sum(),2,'.',',') }}
                            @endif
                    </p>
                    </td>
                    </td>
                    <td style="border:1px solid #000; text-align:right">
                         <p style="font-size: 18px">
                            @if ($currentPage == $sumPage)
                                {{  number_format($Receipt->receiptdetail->pluck('rec_pay')->sum(),2,'.',',') }}
                            @endif
                        </p> 
                    </td> 
                </tr>
            </tbody>    
        </table>
         <table class="details-table">
            <tr>
                <td style="vertical-align: top;line-height:0.5; width:100px">
                    <p style="font-size: 18px">ชำระโดย</p>
                    <p style="font-size: 18px">Payment of</p>
                </td>
                <td style="vertical-align:top;width:150px">
                    <span style="display: inline-block;">
                        <input  type="checkbox" {{ $Receipt->rec_payment_type == 'cash'&& $currentPage == $sumPage ? 'checked' : ''}}>
                    </span>
                    <span style="display: inline-block; margin-left: 5px;line-height:0.5;position: relative;">
                        <p style="display: absolute; margin: 0; font-size:18px">เงินสด<br>cash</p>
                    </span> 
                    <span style="margin-left: 10px; vertical-align: top; font-size: 18px;line-height:1;position:relative;top:-10px">
                        @if ($Receipt->rec_payment_type == "cash" && $currentPage == $sumPage)
                            {{  number_format($real,2,'.',',')  }} 
                        @endif 
                    </span>
                </td>
                <td style="vertical-align:top;">
                    <span style="display: inline-block;">
                        <input  type="checkbox" {{ $Receipt->rec_payment_type == 'tran'  && $currentPage == $sumPage  ? 'checked' : ''}}>
                    </span>
                    <span style="display: inline-block; margin-left: 5px;line-height:0.5;position:relative">
                        <p style="display: absolute; margin: 0; font-size:18px">เงินโอน<br>T/T</p>
                    </span> 
                    <span style=" margin-left: 10px; vertical-align: top; font-size: 18px;line-height:1; line-height:0;position:relative;top:-10px">
                        @if ($Receipt->rec_payment_type == "tran" && $currentPage == $sumPage )
                            {{  number_format($real,2,'.',',')  }} 
                            @endif 
                    </span>
                </td> 
                  <td style="vertical-align:top;min-width:150px">
                  <span style="display: inline-block;">
                    <input value="value" type="checkbox" {{ $Receipt->rec_payment_type == 'cheq' && $currentPage == $sumPage ? 'checked':'' }}>
                </span>
                <span style="display: inline-block; margin-left: 5px;line-height:0.5;position: relative;">
                    <p style="margin: 0; font-size:18px;">เช็คธนาคาร<br>Cheque No.</p>
                </span>
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position:relative;top:-10px">
                        @if ($Receipt->rec_payment_type == "cheq" && $currentPage == $sumPage )
                            {{ $Receipt->rec_bank }}
                        @endif 
                </span>
                </td> 
            </tr>
         
        </table>
        <table>
             <tr>
                 <td style="vertical-align:top;min-width:150px">
                <span style="display: inline-block; margin-left: 5px;line-height:0.5;position: relative;">
                    <p style="margin: 0; font-size:18px">สาขา<br>Branch</p>
                </span>
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative;top:-10px">
                    @if ( $currentPage == $sumPage )
                        {{ $Receipt->rec_branch}}
                    @endif 
                </span>
                </td>
                 <td style="vertical-align:top;min-width:150px">
                <span style="display: inline-block; margin-left: 5px;line-height:0.5;position:relative;">
                    <p style="margin: 0; font-size:18px">เลขที่<br>NO.</p>
                </span>
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative; top:-10px">
                    @if ( $currentPage == $sumPage )
                        {{ $Receipt->rec_cheque_no}}
                    @endif 
                </span>
                </td>
                 <td style="vertical-align:top;min-width:150px">
                <span style="display: inline-block; margin-left: 5px;line-height:0.5;position:relative;">
                    <p style="margin: 0; font-size:18px">วันที่<br>Date</p>
                </span> 
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative; top:-10px">
                    @if ( $currentPage == $sumPage )
                        {{ $Receipt->rec_cheque_date  }}
                    @endif 
                </span>
                </td>
               <td style="vertical-align:top;min-width:150px">
                <span style="display: inline-block; margin-left: 5px; line-height: 0.5;position:relative">
                    <p style="margin: 0; font-size: 18px;">จำนวน<br>Amount</p>
                </span>
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative; top:-10px">
                    @if ($Receipt->rec_payment_type == "cheq" && $currentPage == $sumPage)
                           {{ number_format($real,2,'.',',')  }} 
                    @endif
                </span>
                </td> 
            </tr>
        </table>
        <table>
            <tr>
                 <td style="vertical-align:top;">
                  <span style="display: inline-block;">
                    <input value="value" type="checkbox" {{
                        $Receipt->receiptdetail->pluck('invoicedetail.invd_wh_tax_amt')
                            ->sum() > 0  && $currentPage == $sumPage ? 'checked' : ''     }}>
                </span>
                <span style="display: inline-block; margin-left: 5px; line-height: 0.5;position:relative">
                    <p style="margin: 0; font-size:18px">ภาษีหัก ณ ที่จ่าย<br>Withholding Tax</p>
                </span> 
                 <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative; top:-10px">
                @if ( $currentPage == $sumPage )
                  {{ number_format($Receipt->receiptdetail
                            ->sum('whpay'),2,'.',',') }} 
                @endif
                </span>
                </td> 
            </tr>
        </table> 
        <table class="outer-table">
            <tr>
                <td>
                    <table style="border-collapse:collapse">
                        <tr >
                            <td class="bordered" style="height: 40px; width: 100px;border:solid 1px #000; text-align:center;line-height:0.8">
                                <p>ผู้รับเงิน</p>
                                <p>Collector</p>
                            </td>
                            <td class="bordered" style="height: 40px; width: 100px;border:solid 1px #000;text-align:center;line-height:0.8">
                                <p>การเงิน</p>
                                <p>Cashier</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 40px; border:solid 1px #000"></td>
                            <td style="border:solid 1px #000"></td>
                        </tr>
                    </table>
                </td>
                <td class="text-container" style="padding-left: 10px;">
                    <p style="font-size: 15px">หมายเหตุ: ในกรณีชำระเป็นเช็ค ใบเสร็จรับเงินและใบกำกับภาษีฉบับนี้จะสมบูรณ์ต่อเมื่อบริษัทฯ ได้รับเงินตามเช็คแล้ว</p>
                    <p style="font-size: 15px">REMARK: If payment is made by cheque. This receipt will be valid cheque has been cleared by the bank.</p>
                </td>
            </tr>
        </table>
            @else 
            <tbody>
                <tr style="height: 200px;">
                    <td style="height:250px;width: 320px; border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;vertical-align:top; border-collapse: collapse;">
                        @foreach ($receiptdetails as $index => $receipt)
                             <div style="font-size: 18px; position: relative; padding-right: 100px;">
                                <span>
                                    {{$index + 1}}. {{App\Models\ProductService::where('ps_code', $receipt->invoicedetail->invd_product_code)->pluck('ps_name_en')->first() }} 
                                </span>
                                
                                <!-- Invoice number aligned to the right -->
                                <span style="position: absolute; right: 15px; top: 0;">
                                    {{ $receipt->invoicedetail->invoiceheader->inv_no }}
                                </span>

                                <!-- If remake is too long, position it on the next line using relative positioning -->
                                @if ($receipt->invoicedetail->invd_remake)
                                    <span style="position: absolute; left: 0; top: 0; white-space: nowrap; transform: translateY(50%);">
                                    &nbsp;&nbsp;&nbsp; - {{ $receipt->invoicedetail->invd_remake }}
                                    </span>
                                @endif
                            </div> 
                            @if ($currentPage == $sumPage && $loop->last && $Receipt->rec_exceed_amount)
                                <div style="font-size: 18px; position: relative; padding-right: 100px;">
                                    <span style="white-space: nowrap">
                                        {{$index + 2}}. {{ $Receipt->rec_exceed_desc}}
                                    </span> 
                                </div>
                            @endif
                        @endforeach
                    </td>
                   <td style="vertical-align: top; width: 100px; text-align: right; border-right: 1px solid #000;">
                        @foreach ( $receiptdetails as $receiptdetail)
                            <p style="font-size: 18px; margin: 0;">{{ number_format($receiptdetail->gross,2,'.',',') }}</p>
                              @if ($currentPage == $sumPage && $loop->last && $Receipt->rec_exceed_amount)
                            <p style="font-size: 18px; margin: 0;">{{ number_format($Receipt->rec_exceed_amount,2,'.',',') }}</p>
                            @endif 
                        @endforeach
                    </td> 
                    <td style="text-align: right; border-right:1px solid #000;vertical-align:top;width:100px">
                         @foreach ( $receiptdetails as $receiptdetail)
                            <p style="font-size: 18px" >{{ number_format($receiptdetail->calculated_vat,2,'.',',')}}</p>
                             @if ($currentPage == $sumPage && $loop->last && $Receipt->rec_exceed_amount)
                            <p style="font-size: 18px; margin: 0;">{{ number_format(0,2,'.',',') }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td style="text-align: right; border-right:1px solid #000;vertical-align:top;width:100px">
                         @foreach ( $receiptdetails as $receipt)
                            <p style="font-size: 18px" >{{ number_format($receipt->rec_pay,2,'.',',')}}</p>
                             @if ($currentPage == $sumPage && $loop->last && $Receipt->rec_exceed_amount)
                            <p style="font-size: 18px; margin: 0;">{{ number_format($Receipt->rec_exceed_amount,2,'.',',') }}</p>
                            @endif 
                        @endforeach
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr style="">
                   <td style="height:100px;border:1px solid #000; vertical-align:top;font-size:18px">
                        <p style="font-size: 18px;line-height:0.8">
                            มูลค่าที่ได้รับยกเว้นภาษีมูลค่าเพิ่ม
                            <span style="float: right;clear:both;padding-right:15px">
                                @if ($currentPage == $sumPage)
                                {{ number_format($Receipt->receiptdetail
                                    ->filter(function ($detail) {
                                        return $detail->invoicedetail->invd_vat_percent == 0;
                                    })
                                    ->pluck('gross')
                                    ->sum() + ($Receipt->rec_exceed_amount ?? 0), 2, '.', ',') }}
                                @endif
                            </span> 
                        </p>
                        <p style="font-size:18px;line-height:0.8">มูลค่าที่รวมภาษีมูลค่าเพิ่ม
                            <span style="float: right;clear:both;padding-right:15px">
                                @if ($currentPage == $sumPage)
                                {{ number_format($Receipt->receiptdetail
                                    ->filter(function ($detail) {
                                        return $detail->invoicedetail->invd_vat_percent != 0;
                                    })
                                    ->sum('rec_pay'), 2, '.', ',') }}
                                @endif
                            </span>
                        </p>
                        <p style="font-size:18px;line-height:0.8">
                            &nbsp;&nbsp;&nbsp;&nbsp;-มูลค่าที่เสียภาษีมูลค่าเพิ่ม
                            <span style="float: right;clear:both;padding-right:15px">
                                @if ($currentPage == $sumPage)
                                {{ number_format($Receipt->receiptdetail
                                    ->filter(function ($detail) {
                                        return $detail->invoicedetail->invd_vat_percent != 0;
                                    })
                                    ->sum('gross'), 2, '.', ',') }}
                                @endif
                            </span>
                        </p>
                        <p style="font-size:18px;line-height:0.8">
                            &nbsp;&nbsp;&nbsp;&nbsp;-ภาษีมูลค่าเพิ่ม
                            <span style="float: right;clear:both;padding-right:15px">
                                @if ($currentPage == $sumPage)
                                {{ number_format($Receipt->receiptdetail
                                    ->pluck('calculated_vat')
                                    ->sum(), 2, '.', ',') }}
                                @endif
                            </span>
                        </p>
                        <p style="font-size:18px;line-height:0.8">
                            มูลค่าที่ไม่อยู่ในข้อบังคับภาษีมูลค่าเพิ่ม
                        </p>
                    </td> 
                    <td style="border-right:solid 1px #000">

                    </td>
                    <td style="border-right:solid 1px #000">
                    </td>
                    <td style="">

                    </td>
                </tr>
                <tr style="">
                     <td style="border:1px solid #000; {{ $currentPage != $sumPage ? 'height: 20px;' : '' }}">
                        @if ($currentPage == $sumPage)
                            <p style="font-size: 18px;line-height:0.5">{{ $bath }} </p>
                        @endif
                    </td>
                    <td style="border:1px solid #000; text-align:right">
                        <p style="font-size: 18px">
                            @if ($currentPage == $sumPage)
                                {{  number_format($Receipt->receiptdetail->pluck('gross')->sum()  + ($Receipt->rec_exceed_amount ?? 0),2,'.',',') }}
                            @endif
                        </p>
                    </td>
                    <td style="border:1px solid #000; text-align:right">
                    <p style="font-size: 18px">
                            @if ($currentPage == $sumPage)
                                {{  number_format($Receipt->receiptdetail->pluck('calculated_vat')->sum(),2,'.',',') }}
                            @endif
                    </p>
                    </td>
                    </td>
                    <td style="border:1px solid #000; text-align:right">
                         <p style="font-size: 18px">
                            @if ($currentPage == $sumPage)
                                {{  number_format($Receipt->receiptdetail->pluck('rec_pay')->sum() + ($Receipt->rec_exceed_amount ?? 0),2,'.',',') }}
                            @endif
                        </p> 
                    </td> 
                </tr>
            </tbody>    
        </table>
         <table class="details-table">
            <tr>
                <td style="vertical-align: top;line-height:0.5; width:100px">
                    <p style="font-size: 18px">ชำระโดย</p>
                    <p style="font-size: 18px">Payment of</p>
                </td>
                <td style="vertical-align:top;width:150px">
                    <span style="display: inline-block;">
                        <input  type="checkbox" {{ $Receipt->rec_payment_type == 'cash'&& $currentPage == $sumPage ? 'checked' : ''}}>
                    </span>
                    <span style="display: inline-block; margin-left: 5px;line-height:0.5;position: relative;">
                        <p style="display: absolute; margin: 0; font-size:18px">เงินสด<br>cash</p>
                    </span> 
                    <span style="margin-left: 10px; vertical-align: top; font-size: 18px;line-height:1;position:relative;top:-10px">
                        @if ($Receipt->rec_payment_type == "cash" && $currentPage == $sumPage)
                            {{  number_format($real,2,'.',',')  }} 
                        @endif 
                    </span>
                </td>
                <td style="vertical-align:top;">
                    <span style="display: inline-block;">
                        <input  type="checkbox" {{ $Receipt->rec_payment_type == 'tran'  && $currentPage == $sumPage  ? 'checked' : ''}}>
                    </span>
                    <span style="display: inline-block; margin-left: 5px;line-height:0.5;position:relative">
                        <p style="display: absolute; margin: 0; font-size:18px">เงินโอน<br>T/T</p>
                    </span> 
                    <span style=" margin-left: 10px; vertical-align: top; font-size: 18px;line-height:1; line-height:0;position:relative;top:-10px">
                        @if ($Receipt->rec_payment_type == "tran" && $currentPage == $sumPage )
                            {{  number_format($real,2,'.',',')  }} 
                            @endif 
                    </span>
                </td> 
                  <td style="vertical-align:top;min-width:150px">
                  <span style="display: inline-block;">
                    <input value="value" type="checkbox" {{ $Receipt->rec_payment_type == 'cheq' && $currentPage == $sumPage ? 'checked':'' }}>
                </span>
                <span style="display: inline-block; margin-left: 5px;line-height:0.5;position: relative;">
                    <p style="margin: 0; font-size:18px;">เช็คธนาคาร<br>Cheque No.</p>
                </span>
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position:relative;top:-10px">
                        @if ($Receipt->rec_payment_type == "cheq" && $currentPage == $sumPage )
                            {{ $Receipt->rec_bank }}
                        @endif 
                </span>
                </td> 
            </tr>
         
        </table>
        <table>
             <tr>
                 <td style="vertical-align:top;min-width:150px">
                <span style="display: inline-block; margin-left: 5px;line-height:0.5;position: relative;">
                    <p style="margin: 0; font-size:18px">สาขา<br>Branch</p>
                </span>
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative;top:-10px">
                    @if ( $currentPage == $sumPage )
                        {{ $Receipt->rec_branch}}
                    @endif 
                </span>
                </td>
                 <td style="vertical-align:top;min-width:150px">
                <span style="display: inline-block; margin-left: 5px;line-height:0.5;position:relative;">
                    <p style="margin: 0; font-size:18px">เลขที่<br>NO.</p>
                </span>
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative; top:-10px">
                    @if ( $currentPage == $sumPage )
                        {{ $Receipt->rec_cheque_no}}
                    @endif 
                </span>
                </td>
                 <td style="vertical-align:top;min-width:150px">
                <span style="display: inline-block; margin-left: 5px;line-height:0.5;position:relative;">
                    <p style="margin: 0; font-size:18px">วันที่<br>Date</p>
                </span> 
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative; top:-10px">
                    @if ( $currentPage == $sumPage )
                        {{ $Receipt->rec_cheque_date  }}
                    @endif 
                </span>
                </td>
               <td style="vertical-align:top;min-width:150px">
                <span style="display: inline-block; margin-left: 5px; line-height: 0.5;position:relative">
                    <p style="margin: 0; font-size: 18px;">จำนวน<br>Amount</p>
                </span>
                <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative; top:-10px">
                    @if ($Receipt->rec_payment_type == "cheq" && $currentPage == $sumPage)
                           {{ number_format($real,2,'.',',')  }} 
                    @endif
                </span>
                </td> 
            </tr>
        </table>
        <table>
            <tr>
                 <td style="vertical-align:top;">
                  <span style="display: inline-block;">
                    <input value="value" type="checkbox" {{
                        $Receipt->receiptdetail->pluck('invoicedetail.invd_wh_tax_amt')
                            ->sum() > 0  && $currentPage == $sumPage ? 'checked' : ''     }}>
                </span>
                <span style="display: inline-block; margin-left: 5px; line-height: 0.5;position:relative">
                    <p style="margin: 0; font-size:18px">ภาษีหัก ณ ที่จ่าย<br>Withholding Tax</p>
                </span> 
                 <span style="margin-left: 10px; vertical-align: top; font-size: 18px;position: relative; top:-10px">
                @if ( $currentPage == $sumPage )
                  {{ number_format($Receipt->receiptdetail
                            ->sum('whpay'),2,'.',',') }} 
                @endif
                </span>
                </td> 
            </tr>
        </table> 
        <table class="outer-table">
            <tr>
                <td>
                    <table style="border-collapse:collapse">
                        <tr >
                            <td class="bordered" style="height: 40px; width: 100px;border:solid 1px #000; text-align:center;line-height:0.8">
                                <p>ผู้รับเงิน</p>
                                <p>Collector</p>
                            </td>
                            <td class="bordered" style="height: 40px; width: 100px;border:solid 1px #000;text-align:center;line-height:0.8">
                                <p>การเงิน</p>
                                <p>Cashier</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 40px; border:solid 1px #000"></td>
                            <td style="border:solid 1px #000"></td>
                        </tr>
                    </table>
                </td>
                <td class="text-container" style="padding-left: 10px;">
                    <p style="font-size: 15px">หมายเหตุ: ในกรณีชำระเป็นเช็ค ใบเสร็จรับเงินและใบกำกับภาษีฉบับนี้จะสมบูรณ์ต่อเมื่อบริษัทฯ ได้รับเงินตามเช็คแล้ว</p>
                    <p style="font-size: 15px">REMARK: If payment is made by cheque. This receipt will be valid cheque has been cleared by the bank.</p>
                </td>
            </tr>
        </table>
        @endif
    </div>
</body>
</html>