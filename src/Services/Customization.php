<?php namespace Iss\LaravelMayaSdk\Services;

use Iss\LaravelMayaSdk\Facades\Maya;

class Customization{

    protected string $logoUrl = "";
    protected string $iconUrl = "";
    protected string $appleTouchIconUrl = "";
    protected string $customTitle = "";
    protected string $colorScheme = "";
    protected bool $hideReceiptInput = true;
    protected bool $skipResultPage = false;
    protected bool $showMerchantName = false;
    protected int $redirectTimer = 5;

    public function setLogoUrl(string $logoUrl = "")
    {
        $this->logoUrl = $logoUrl;
        return $this;
    }

    public function setIconUrl(string $iconUrl = "")
    {
        $this->iconUrl = $iconUrl;
        return $this;
    }

    public function setAppleTouchIconUrl(string $appleTouchIconUrl = "")
    {
        $this->appleTouchIconUrl = $appleTouchIconUrl;
        return $this;
    }

    public function setCustomTitle(string $customTitle = "")
    {
        $this->customTitle = $customTitle;
        return $this;
    }

    public function setColorScheme(string $colorScheme = "")
    {
        $this->colorScheme = $colorScheme;
        return $this;
    }

    public function hideReceipt()
    {
        $this->hideReceiptInput = true;
        return $this;
    }

    public function showReceipt()
    {
        $this->hideReceiptInput = false;
        return $this;
    }

    public function skipResultPage()
    {
        $this->skipResultPage = true;
        return $this;
    }

    public function doNotSkipResultPage()
    {
        $this->skipResultPage = false;
        return $this;
    }

    public function showMerchantName()
    {
        $this->showMerchantName = true;
        return $this;
    }

    public function hideMerchantName()
    {
        $this->showMerchantName = false;
        return $this;
    }

    public function setRedirectTimer(int $redirectTimer = 5)
    {
        $this->redirectTimer = $redirectTimer;
        return $this;
    }

    private function getHideReceiptInput()
    {
        return $this->hideReceiptInput;
    }

    private function getSkipResultPage()
    {
        return $this->skipResultPage;
    }

    private function getShowMerchantName()
    {
        return $this->showMerchantName;
    }

    private function getRedirectTimer()
    {
        return $this->redirectTimer;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function buildRequestBody(): array
    {
        $this->validate();
        return [
            "logoUrl" => $this->getLogoUrl(),
            "iconUrl" => $this->getIconUrl(),
            "appleTouchIconUrl" => $this->getAppleTouchIconUrl(),
            "customTitle" => $this->getCustomTitle(),
            "colorScheme" => $this->getColorScheme(),
            "hideReceiptInput" => $this->getHideReceiptInput(),
            "skipResultPage" => $this->getSkipResultPage(),
            "showMerchantName" => $this->getShowMerchantName(),
            "redirectTimer" => $this->getRedirectTimer(),
        ];
    }

    private function getLogoUrl()
    {
        return $this->logoUrl;
    }

    private function getIconUrl()
    {
        return $this->iconUrl;
    }

    private function getAppleTouchIconUrl()
    {
        return $this->appleTouchIconUrl;
    }

    private function getCustomTitle()
    {
        return $this->customTitle;
    }

    private function getColorScheme()
    {
        return $this->colorScheme;
    }

    /**
     * @throws \Exception
     */
    private function validate()
    {
        if (empty($this->getLogoUrl())){
            throw new \Exception('Logo URL is required.');
        }

        if (empty($this->getIconUrl())){
            throw new \Exception('Icon URL is required.');
        }

        if (empty($this->getAppleTouchIconUrl())){
            throw new \Exception('Apple touch icon URL is required.');
        }

        if (empty($this->getCustomTitle())){
            throw new \Exception('Custom title is required.');
        }

        if (empty($this->getColorScheme())){
            throw new \Exception('Color scheme is required.');
        }
    }

    public function set()
    {
        return Maya::client()->setRequestMethod('POST')->setService('customization')->send($this->buildRequestBody());
    }

    public function get()
    {
        return Maya::client()->setRequestMethod('GET')->setService('customization')->send();
    }

    public function delete()
    {
        return Maya::client()->setRequestMethod('DELETE')->setService('customization')->send();
    }
}
