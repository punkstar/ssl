<?php

namespace Punkstar\Ssl;

use DateTime;

class Certificate
{
    protected $rawCert;
    protected $certData;

    /**
     * Certificate constructor.
     *
     * @param string $certificate
     */
    public function __construct($certificate)
    {
        $this->rawCert = $certificate;
        $this->certData = openssl_x509_parse($this->rawCert);
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
