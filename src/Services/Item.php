<?php namespace Iss\LaravelMayaSdk\Services;

use Illuminate\Support\Facades\Log;

class Item{
    protected array $items = [];
    protected string $currency_code = "PHP";
    protected array $totalAmount = [];
    protected array $required_item_fields = [
        "amount", "totalAmount", "name", "code", "description", "quantity"
    ];

    /**
     * @param array $item
     * @return $this
     * @throws \Exception
     */
    public function addItem(array $item = []): Item
    {
        if (empty($item)){
            return $this;
        }

        foreach ($this->required_item_fields as $required_item_field) {
            if (!array_key_exists($required_item_field, $item)){
                throw new \Exception("This {$required_item_field} field is not found in your new item.");
            }
        }

        $searched_index = array_search($item['code'], array_column($this->getItems(), 'code'));
        if ($searched_index !== false){
            $inline_item = $this->getItems()[$searched_index];

            $quantity = (float) $inline_item['quantity'] + (float) $item['quantity'];
            $totalAmount = (float) ($inline_item['amount']['value'] * $quantity);

            unset($inline_item['quantity']);
            unset($inline_item['totalAmount']['value']);
            $inline_item['quantity'] = (string) $quantity;
            $inline_item['totalAmount']['value'] = $totalAmount;

        }else{
            $this->items[] = $item;
        }

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

}
