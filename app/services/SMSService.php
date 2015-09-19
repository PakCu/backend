<?php 

use Artistan\Nexmo\Service\Message\Sms;

class SMSService
{
    public static function StreamingReady($number)
    {
        self::send($number, 'PiMasjid bersedia untuk menerima stream. Tekan butang mula pada alat PiMasjid. Untuk berhenti streaming, balas dengan berhenti.');
    }
    
    public static function StreamClosed($number, $tajuk)
    {
        self::send($number, 'Stream bertajuk ' . $tajuk . ' telah dihentikan.');
    }

    public static function NoActiveStream($number)
    {
        self::send($number, 'Anda tiada stream yang aktif.');
    }

    public static function AlreadyStreaming($number, $title)
    {
        self::send($number, 'Anda sedang di dalam stream yang aktif bertajuk ' . $title . '. Untuk berhenti streaming, balas sms dengan berhenti');
    }

    public static function InvalidFormat($number)
    {
        self::send($number, 'Format mesej tidak betul. Contoh: ceramah lokasi;tajuk ceramah');
    }

    public static function MobileNumberNotRegistered($number)
    {
        self::send($number, 'Nombor telefon ini tidah didaftarkan sebagai penceramah.');
    }

    public static function LocationNotFound($number, $location_id)
    {
        self::send($number, 'Lokasi dengan id: ' . $location_id . ' tidak dijumpai');
    }

    protected static function send($number, $message)
    {
        $sms = new Sms;
        $sms->sendText($number, '601117225390', $message);
    }

}