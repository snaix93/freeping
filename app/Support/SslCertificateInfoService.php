<?php


namespace App\Support;


use App\Exceptions\SslCertificateCheckException;
use Carbon\Carbon;

class SslCertificateInfoService
{

    protected function getCertificateData(string $host, int $port)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('https://%s:%s/', $host, $port));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_CERTINFO, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_PROXY_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CAINFO, base_path() . "/vendor/composer/ca-bundle/res/cacert.pem");
        $result = curl_exec($ch);

        throw_unless($result,new SslCertificateCheckException(curl_error($ch)));

        $info = curl_getinfo($ch, CURLINFO_CERTINFO);

        curl_close($ch);

        return $info;
    }

    public function getExpiryDate(string $host, int $port = 443): Carbon
    {
        $certInfo = $this->getCertificateData($host, $port);

        if(empty($certInfo)){
            throw new SslCertificateCheckException('Certificate info unavailable');
        }

        return new Carbon($certInfo[0]['Expire date']);
    }
}
