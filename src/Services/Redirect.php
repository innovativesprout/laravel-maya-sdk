<?php namespace Iss\LaravelMayaSdk\Services;

class Redirect{

    protected string $success = "";
    protected string $failure = "";
    protected string $cancel = "";

    /**
     * @param string $url
     * @return $this
     */
    public function setSuccess(string $url = "")
    {
        $this->success = $url;
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setFailure(string $url = "")
    {
        $this->failure = $url;
        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setCancel(string $url = "")
    {
        $this->cancel = $url;
        return $this;
    }

    protected function getFailure()
    {
        return $this->failure;
    }

    protected function getSuccess()
    {
        return $this->success;
    }

    protected function getCancel()
    {
        return $this->cancel;
    }

    public function getRedirectUrls()
    {
        return [
            "success" => $this->getSuccess(),
            "failure" => $this->getFailure(),
            "cancel" => $this->getCancel(),
        ];
    }
}
