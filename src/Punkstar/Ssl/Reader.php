<?php

namespace Punkstar\Ssl;

class Reader
{

    /**
     * @param $url
     * @return Certificate
     */
    public function readFromUrl($url)
    {
        $urlHost = parse_url($url, PHP_URL_HOST);

        $streamContext = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
        $stream = stream_socket_client("ssl://".$urlHost.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $streamContext);
        $streamParams = stream_context_get_params($stream);

        $certResource = $streamParams['options']['ssl']['peer_certificate'];

        return new Certificate($this->certResourceToString($certResource));
    }

    /**
     * @param $file
     * @return Certificate
     */
    public function readFromFile($file)
    {
        return new Certificate(file_get_contents($file));
    }

    /**
     * @param $certResource
     * @return string
     */
    protected function certResourceToString($certResource)
    {
        $output = null;

        openssl_x509_export($certResource, $output);

        return $output;
    }
}
