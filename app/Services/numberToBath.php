<?php

namespace App\Services;

class numberToBath
{
    const BAHT_TEXT_NUMBERS = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
    const BAHT_TEXT_UNITS = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    const BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
    const BAHT_TEXT_TWENTY = 'ยี่';
    const BAHT_TEXT_INTEGER = 'ถ้วน';
    const BAHT_TEXT_BAHT = 'บาท';
    const BAHT_TEXT_SATANG = 'สตางค์';
    const BAHT_TEXT_POINT = 'จุด';
    
    /**
     * Convert baht number to Thai text
     * @param double|int $number
     * @param bool $include_unit
     * @param bool $display_zero
     * @return string|null
     */
    function baht_text($number, $include_unit = true, $display_zero = true)
    {
        if (!is_numeric($number)) {
            return null;
        }
    
        $log = floor(log($number, 10));
        if ($log > 5) {
            $millions = floor($log / 6);
            $million_value = pow(1000000, $millions);
            $normalised_million = floor($number / $million_value);
            $rest = $number - ($normalised_million * $million_value);
            $millions_text = '';
            for ($i = 0; $i < $millions; $i++) {
                $millions_text .= self::BAHT_TEXT_UNITS[6];
            }
            return $this->baht_text($normalised_million, false) . $millions_text . 
            $this->baht_text($rest, true, false);
        }
    
        $number_str = (string)floor($number);
        $text = '';
        $unit = 0;
    
        if ($display_zero && $number_str == '0') {
            $text = self::BAHT_TEXT_NUMBERS[0];
        } else for ($i = strlen($number_str) - 1; $i > -1; $i--) {
            $current_number = (int)$number_str[$i];
    
            $unit_text = '';
            if ($unit == 0 && $i > 0) {
                $previous_number = isset($number_str[$i - 1]) ? (int)$number_str[$i - 1] : 0;
                if ($current_number == 1 && $previous_number > 0) {
                    $unit_text .= self::BAHT_TEXT_ONE_IN_TENTH;
                } else if ($current_number > 0) {
                    $unit_text .= self::BAHT_TEXT_NUMBERS[$current_number];
                }
            } else if ($unit == 1 && $current_number == 2) {
                $unit_text .= self::BAHT_TEXT_TWENTY;
            } else if ($current_number > 0 && ($unit != 1 || $current_number != 1)) {
                $unit_text .= self::BAHT_TEXT_NUMBERS[$current_number];
            }
    
            if ($current_number > 0) {
                $unit_text .= self::BAHT_TEXT_UNITS[$unit];
            }
    
            $text = $unit_text . $text;
            $unit++;
        }
    
        if ($include_unit) {
            $text .= self::BAHT_TEXT_BAHT;
    
            $satang = explode('.', number_format($number, 2, '.', ''))[1];
            $text .= $satang == 0
                ? self::BAHT_TEXT_INTEGER
                : $this->baht_text($satang, false) . self::BAHT_TEXT_SATANG;
        } else {
            $exploded = explode('.', $number);
            if (isset($exploded[1])) {
                $text .= self::BAHT_TEXT_POINT;
                $decimal = (string)$exploded[1];
                for ($i = 0; $i < strlen($decimal); $i++) {
                    $text .= self::BAHT_TEXT_NUMBERS[$decimal[$i]];
                }
            }
        }
    
        return $text;
    }
    function numberToWords($number) {
        $units = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $teens = ['eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
        $tens = ['', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        $thousands = ['', 'thousand', 'million', 'billion'];
    
        if ($number == 0) {
            return 'zero';
        }
    
        // Format the number to always have two decimal places
        $number = number_format($number, 2, '.', '');
    
        $numberParts = explode('.', strval($number));
        $integerPart = intval($numberParts[0]);
        $fractionalPart = intval($numberParts[1]);
    
        $integerStr = strval($integerPart);
        $length = strlen($integerStr);
        $parts = [];
        $chunkCount = ceil($length / 3);
    
        for ($i = 0; $i < $chunkCount; $i++) {
            $chunk = substr($integerStr, -3);
            $integerStr = substr($integerStr, 0, -3);
            array_unshift($parts, $chunk);
        }
    
        $words = [];
    
        foreach ($parts as $index => $chunk) {
            $chunk = str_pad($chunk, 3, '0', STR_PAD_LEFT);
            $hundredsDigit = (int)$chunk[0];
            $tensDigit = (int)$chunk[1];
            $unitsDigit = (int)$chunk[2];
    
            $chunkWords = [];
    
            if ($hundredsDigit > 0) {
                $chunkWords[] = $units[$hundredsDigit] . ' hundred';
            }
    
            if ($tensDigit > 1) {
                $chunkWords[] = $tens[$tensDigit];
                if ($unitsDigit > 0) {
                    $chunkWords[] = $units[$unitsDigit];
                }
            } elseif ($tensDigit == 1) {
                if ($unitsDigit > 0) {
                    $chunkWords[] = $teens[$unitsDigit - 1];
                } else {
                    $chunkWords[] = 'ten';
                }
            } else {
                if ($unitsDigit > 0) {
                    $chunkWords[] = $units[$unitsDigit];
                }
            }
    
            if (!empty($chunkWords) && !empty($thousands[$chunkCount - $index - 1])) {
                $chunkWords[] = $thousands[$chunkCount - $index - 1];
            }
    
            $words = array_merge($words, $chunkWords);
        }
    
        $integerWords = implode(' ', $words);
    
        $fractionalWords = '';
        if ($fractionalPart > 0) {
            $tensPart = (int)($fractionalPart / 10);
            $unitsPart = $fractionalPart % 10;
            
            $fractionalWords = $tens[$tensPart];
            if ($unitsPart > 0) {
                $fractionalWords .= ' ' . $units[$unitsPart];
            }
            $fractionalWords .= ' satang';
        }
    
        return trim($integerWords) . ' baht' . ($fractionalWords ? ' ' . trim($fractionalWords) : '');
    }
}
