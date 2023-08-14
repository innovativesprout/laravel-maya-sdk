<?php namespace Iss\LaravelMayaSdk\Services;

class BillingAddress{

    protected string $line1 = "";
    protected string $line2 = "";
    protected string $city = "";
    protected string $state = "";
    protected string $zipCode = "";
    protected string $countryCode = "PH";

    /**
     * @param string $line1
     * @return $this
     */
    public function setLine1(string $line1 = "")
    {
        $this->line1 = $line1;
        return $this;
    }

    /**
     * @param string $line2
     * @return $this
     */
    public function setLine2(string $line2 = "")
    {
        $this->line2 = $line2;
        return $this;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city = "")
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setState(string $state = "")
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param string $zipCode
     * @return $this
     */
    public function setZipCode(string $zipCode = "")
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @param string $countryCode
     * @return $this
     */
    public function setCountryCode(string $countryCode = "")
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getLine1(): string
    {
        return $this->line1;
    }

    public function getLine2(): string
    {
        return $this->line2;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function get()
    {
        return [
            "line1" => $this->getLine1(),
            "line2" => $this->getLine2(),
            "city" => $this->getCity(),
            "state" => $this->getState(),
            "zipCode" => $this->getZipCode(),
            "countryCode" => $this->getCountryCode()
        ];
    }
}
