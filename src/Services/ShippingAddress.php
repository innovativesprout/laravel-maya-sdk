<?php namespace Iss\LaravelMayaSdk\Services;

class ShippingAddress{

    const STANDARD_SHIPPING = "ST";
    const SAME_DAY_SHIPPING = "SD";
    protected string $shippingType = self::STANDARD_SHIPPING;

    protected string $firstName = "";
    protected string $lastName = "";
    protected string $phone = "";
    protected string $email = "";
    protected string $line1 = "";
    protected string $line2 = "";
    protected string $city = "";
    protected string $state = "";
    protected string $zipCode = "";
    protected string $countryCode = "PH";

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName = "")
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName = "")
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone(string $phone = "")
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email = "")
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setShippingType(string $type = "ST")
    {
        if ($type === "ST"){
            $this->shippingType = self::STANDARD_SHIPPING;
        }else{
            $this->shippingType = self::SAME_DAY_SHIPPING;
        }
        return $this;
    }

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

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getShippingType(): string
    {
        return $this->shippingType;
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

    public function get(): array
    {
        return [
            "firstName" => $this->getFirstName(),
            "lastName" => $this->getLastName(),
            "phone" => $this->getPhone(),
            "email" => $this->getEmail(),
            "shippingType" => $this->getShippingType(),
            "line1" => $this->getLine1(),
            "line2" => $this->getLine2(),
            "city" => $this->getCity(),
            "state" => $this->getState(),
            "zipCode" => $this->getZipCode(),
            "countryCode" => $this->getCountryCode()
        ];
    }
}
