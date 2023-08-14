<?php namespace Iss\LaravelMayaSdk\Services;

class TotalAmount{

    protected array $items = [];
    protected string $currency = "PHP";
    protected float $totalAmount = 0;
    protected string $discount = "0.00",
        $serviceCharge = "0.00",
        $shippingFee = "0.00",
        $tax = "0.00",
        $subTotal = "0.00";

    public function setItems(array $items = [])
    {
        $this->items = $items;
        return $this;
    }

    public function setCurrency(string $currency = "PHP")
    {
        $this->currency = $currency;
        return $this;
    }

    public function setDiscount(string $discount = "0.00")
    {
        $this->discount = $discount;
        return $this;
    }

    public function setServiceCharge(string $serviceCharge = "0.00")
    {
        $this->serviceCharge = $serviceCharge;
        return $this;
    }

    public function setShippingFee(string $shippingFee = "0.00")
    {
        $this->shippingFee = $shippingFee;
        return $this;
    }

    public function setTax(string $tax = "0.00")
    {
        $this->tax = $tax;
        return $this;
    }

    public function setAmount(string $subTotal = "0.00")
    {
        $this->subTotal = $subTotal;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    protected function getCurrency()
    {
        return $this->currency;
    }

    protected function getDiscount(){
        return $this->discount;
    }

    protected function getServiceCharge(){
        return $this->serviceCharge;
    }

    protected function getShippingFee(){
        return $this->shippingFee;
    }

    protected function getTax(){
        return $this->tax;
    }

    protected function calculateSubTotal()
    {
        $subTotal = 0;
        if (empty($this->getItems())){
            $subTotal += (float) $this->getSubTotal();
        }else{
            foreach ($this->getItems() as $item) {
                $subTotal += (float) $item['totalAmount']['value'];
            }
        }
        $this->subTotal = (string) $subTotal;
        return $this;
    }

    protected function calculateTotalAmount()
    {
        $this->totalAmount = (float) $this->getSubTotal() + (float) $this->getTax() + (float) $this->getShippingFee() + (float) $this->getServiceCharge() - (float) $this->getDiscount();
        return $this;
    }

    protected function getTotalAmount()
    {
        return $this->totalAmount;
    }

    protected function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @return array[]
     */
    public function get(): array
    {
        $this->calculateSubTotal();
        $this->calculateTotalAmount();
        return  [
            "currency" => $this->getCurrency(),
            "value" => $this->getTotalAmount(),
            "details" => [
                "discount" => $this->getDiscount(),
                "serviceCharge" => $this->getServiceCharge(),
                "shippingFee" => $this->getShippingFee(),
                "tax" => $this->getTax(),
                "subtotal" => $this->getSubTotal()
            ]
        ];
    }
}
