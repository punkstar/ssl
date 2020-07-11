<?php

namespace Punkstar\Ssl;

class Reader
{
    /**
     * Default connection timeout in seconds.
     */
    const DEFAULT_CONNECTION_TIMEOUT = 5;
    
    /**
     * Default port on which to expect https.
     */
    const DEFAULT_PORT = 443;
    
    /**
     * Option Flag: Name of option for defining a connection timeout.
     */
    const OPT_CONNECTION_TIMEOUT = 'connection_timeout';

    /**
     * Connect to a URL and retrieve the SSL certificate.
     *
     * Available options:
     *
     *     - connection_timeout: Timeout when connection to the URL, specified in seconds.
     *
     * @param $url
     * @param array $options
     * @return Certificate
     * @throws Exception
     */
    public function readFromUrl($url, array $options = []): Certificate
    {
        $urlHost = parse_url($url, PHP_URL_HOST);

        if ($urlHost === null) {
            $urlHost = $url;
        }
    
        $urlPort = parse_url($url, PHP_URL_PORT);
    
        if ($urlPort === null) {
            $urlPort = self::DEFAULT_PORT;
        }
    
        $options = $this->prepareReadFromUrlOptions($options);

        $streamContext = stream_context_create(array(
            'ssl' => array(
                'capture_peer_cert' => TRUE,
                'capture_peer_cert_chain' => TRUE,
                'verify_peer'       => FALSE,
                'verify_peer_name'  => FALSE
            )
        ));

        $stream = @stream_socket_client(
            sprintf('ssl://%s:%d', $urlHost, $urlPort),
            $errorNumber,
            $errorString,
            $options[self::OPT_CONNECTION_TIMEOUT],
            STREAM_CLIENT_CONNECT,
            $streamContext
        );

        if ($stream) {
            $streamParams = stream_context_get_params($stream);

            $certResource = $streamParams['options']['ssl']['peer_certificate'];

            return new Certificate(
                $this->certResourceToString($certResource),
                array_map(function ($cert) {
                    return $this->certResourceToString($cert);
                }, array_slice($streamParams['options']['ssl']['peer_certificate_chain'] ?? [], 1))
            );
        }
        
        throw new Exception(
            sprintf('Unable to connect to %s:%d', $urlHost, $urlPort),
            Exception::CONNECTION_PROBLEM
        );
    }
    
    /**
     * @param $file
     * @return Certificate
     * @throws Exception
     */
    public function readFromFile($file): Certificate
    {
        if (!file_exists($file)) {
            throw new Exception(sprintf("File '%s' does not exist", $file), Exception::FILE_NOT_FOUND);
        }

        preg_match_all(
            '/(-----BEGIN CERTIFICATE-----[\s\w+\/=]+-----END CERTIFICATE-----)/',
            file_get_contents($file),
            $matches
        );

        if (count($matches) === 0) {
            throw new Exception(sprintf("File '%s' does not contain correctly formatted certificate(s)", $file), Exception::MALFORMED_CERTIFICATE);
        }

        list($certificates) = $matches;

        return new Certificate(array_shift($certificates), $certificates);
    }

    /**
     * @param $certResource
     * @return string
     */
    protected function certResourceToString($certResource): string
    {
        $output = null;

        openssl_x509_export($certResource, $output);

        return $output;
    }

    /**
     * @param $options
     * @return array
     */
    protected function prepareReadFromUrlOptions(array $options): array
    {
        if (!isset($options[self::OPT_CONNECTION_TIMEOUT])) {
            $options[self::OPT_CONNECTION_TIMEOUT] = self::DEFAULT_CONNECTION_TIMEOUT;
        }

        return $options;
    }
}
