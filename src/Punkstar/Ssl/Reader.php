<?php

namespace Punkstar\Ssl;

class Reader
{
    const CONNECTION_TIMEOUT = 30;

    /**
     * @param $url
     * @return Certificate
     * @throws Exception
     */
    public function readFromUrl($url)
    {
        $urlHost = parse_url($url, PHP_URL_HOST);

        if ($urlHost === null) {
            $urlHost = $url;
        }

        $streamContext = stream_context_create(array(
            "ssl" => array(
                "capture_peer_cert" => TRUE,
                "verify_peer" => FALSE,
                "verify_peer_name" => FALSE
            )
        ));

        $stream = @stream_socket_client("ssl://" . $urlHost . ":443", $errorNumber, $errorString, self::CONNECTION_TIMEOUT, STREAM_CLIENT_CONNECT, $streamContext);

        if ($stream) {
            $streamParams = stream_context_get_params($stream);

            $certResource = $streamParams['options']['ssl']['peer_certificate'];

            return new Certificate($this->certResourceToString($certResource));
        } else {
            throw new Exception(sprintf("Unable to connect to %s", $urlHost));
        }
    }
    
    /**
     * @param $file
     * @return Certificate
     * @throws Exception
     */
    public function readFromFile($file)
    {
        if (!file_exists($file)) {
            throw new Exception(sprintf("File '%s' does not exist", $file), Exception::FILE_NOT_FOUND);
        }

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
