<?php

namespace Punkstar\Ssl;

use DateTime;
use Punkstar\Ssl\Parser\SanParser;

class Certificate
{
    protected $rawCert;
    protected $certData;

    /**
     * @var SanParser
     */
    protected $sanParser;

    /**
     * @var Certificate[]
     */
    protected $chain;

    /**
     * Certificate constructor.
     *
     * @param string $certificate
     * @param SanParser $sanParser
     */
    public function __construct($certificate, $certificateChain = [], SanParser $sanParser = null)
    {
        if ($sanParser === null) {
            $sanParser = new SanParser();
        }

        $this->sanParser = $sanParser;

        $this->rawCert = $certificate;
        $this->certData = $this->extractCertData($certificate);
        $this->chain = array_map(function ($cert) use ($sanParser) {
            return new Certificate($cert, [], $sanParser);
        }, $certificateChain);
        $this->sanParser = $sanParser;
    }

    /**
     * @return DateTime
     */
    public function validFrom(): \DateTime
    {
        $date = new DateTime();
        $date->setTimestamp($this->certData['validFrom_time_t']);
        return $date;
    }

    /**
     * @return DateTime
     */
    public function validTo(): \DateTime
    {
        $date = new DateTime();
        $date->setTimestamp($this->certData['validTo_time_t']);
        return $date;
    }

    /**
     * @return string
     */
    public function certName(): ?string
    {
        return $this->certData['name'] ?? null;
    }

    /**
     * @return array
     */
    public function subject(): array
    {
        return $this->certData['subject'] ?? [];
    }

    /**
     * @return array
     */
    public function issuer(): array
    {
        return $this->certData['issuer'] ?? [];
    }

    /**
     * @return array
     */
    public function sans(): array
    {
        return $this->sanParser->parse($this->certData['extensions']['subjectAltName'] ?? '');
    }

    /**
     * @return string
     */
    public function signatureAlgorithm(): string
    {
        return $this->certData['signatureTypeSN'];
    }

    /**
     * @return string
     */
    public function publicKey(): string
    {
        return openssl_pkey_get_details(openssl_pkey_get_public($this->toString()))['key'];
    }

    /**
     * @return Certificate[]
     */
    public function chain(): array
    {
        return $this->chain;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->rawCert;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param Certificate $cert
     * @return boolean
     */
    public function signedBy(Certificate $cert): bool
    {
        return openssl_x509_verify($this->toString(), $cert->publicKey()) === 1;
    }

    protected function extractCertData($certificate): array
    {
        $parsedData = openssl_x509_parse($certificate);

        if ($parsedData === false) {
            throw new Exception("Unable to extract data from certificate.", Exception::MALFORMED_CERTIFICATE);
        }

        return $parsedData;
    }
}
