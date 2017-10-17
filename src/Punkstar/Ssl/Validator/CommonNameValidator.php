<?php

namespace Punkstar\Ssl\Validator;

use Punkstar\Ssl\Certificate;

class CommonNameValidator
{
    /**
     * @var Certificate
     */
    private $certificate;
    
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }
    
    public function isValid($domain) : bool
    {
        foreach ($this->getNameVariations($domain) as $nameVariation) {
            if (in_array($nameVariation, $this->getAllowedNames(), true)) {
                return true;
            }
        }
        
        return false;
    }
    
    private function getAllowedNames() : array
    {
        // Add any SANS that might be on the certificate.
        $allowedNames = $this->certificate->sans();
    
        $sslCertSubject = $this->certificate->subject();
    
        // Add the common name from the certificate.
        if (isset($sslCertSubject['CN'])) {
            $allowedNames[] = $sslCertSubject['CN'];
        }
        
        return $allowedNames;
    }
    
    private function getNameVariations($domain) : array
    {
        $nameVariations = [$domain];
    
        // If we're looking at a subdomain then check for wildcards.
        if (substr_count($domain, '.') >= 2) {
            $nameVariations[] = '*' . substr($domain, strpos($domain, '.'));
        }
        
        return $nameVariations;
    }
}
