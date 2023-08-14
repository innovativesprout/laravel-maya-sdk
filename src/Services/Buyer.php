<?php namespace Iss\LaravelMayaSdk\Services;

class Buyer{

    protected array $shippingAddress = [];
    protected array $billingAddress = [];
    protected string $firstName = "";
    protected string $lastName = "";
    protected string $phone = "";
    protected string $email = "";
    protected string $birthday = "";
    protected string $middleName = "";
    protected string $sex = "";


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

    public function setBirthday(string $birthday = "")
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function setMiddleName(string $middleName = "")
    {
        $this->middleName = $middleName;
        return $this;
    }

    public function setSex(string $sex = "")
    {
        $this->sex = $sex;
        return $this;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    /**
     * @return string
     */
    protected function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    protected function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    protected function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    protected function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param array $shippingAddress
     * @return $this
     */
    public function setShippingAddress(array $shippingAddress = []): Buyer
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    /**
     * @param array $billingAddress
     * @return $this
     */
    public function setBillingAddress(array $billingAddress = []): Buyer
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    public function getShippingAddress(): array
    {
        return $this->shippingAddress;
    }

    public function getBillingAddress(): array
    {
        return $this->billingAddress;
    }

    public function get()
    {
         return [
            "firstName" => $this->getFirstName(),
            "middleName" => $this->getMiddleName(),
            "lastName" => $this->getLastName(),
            "birthday" => $this->getBirthday(),
            "sex" => $this->getSex(),
            "contact" => [
                "phone" => $this->getPhone(),
                "email" => $this->getEmail()
            ],
            "shippingAddress" => $this->getShippingAddress(),
            "billingAddress" => $this->getBillingAddress()
        ];
    }

}
