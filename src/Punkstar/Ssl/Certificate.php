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
     * Certificate constructor.
     *
     * @param string $certificate
     * @param SanParser $sanParser
     */
    public function __construct($certificate, SanParser $sanParser = null)
    {
        if ($sanParser === null) {
            $sanParser = new SanParser();
        }

        $this->sanParser = $sanParser;

        $this->rawCert = $certificate;
        $this->certData = openssl_x509_parse($this->rawCert);
        $this->sanParser = $sanParser;
    }

    /**
     * @return DateTime
     */
    public function validFrom()
    {
        $date = new DateTime();
        $date->setTimestamp($this->certData['validFrom_time_t']);
        return $date;
    }

    /**
     * @return DateTime
     */
    public function validTo()
    {
        $date = new DateTime();
        $date->setTimestamp($this->certData['validTo_time_t']);
        return $date;
    }

    /**
     * @return string
     */
    public function certName()
    {
        return $this->certData['name'];
    }

    /**
     * @return array
     */
    public function subject()
    {
        return $this->certData['subject'];
    }

    /**
     * @return array
     */
    public function issuer()
    {
        return $this->certData['issuer'];
    }

    /**
     * @return array
     */
    public function sans()
    {
        return $this->sanParser->parse($this->certData['extensions']['subjectAltName']);
    }

    /**
     * @return string
     */
    public function toString()
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
}
