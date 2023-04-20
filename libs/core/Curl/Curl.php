<?php
/**
 * Created by : VsCode
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/15
 * Time:  19:50
 */

namespace libs\core\Curl;

class Curl {
    private $url;
    private $ch;
    private $response;
    private $headers = [];
    private $options = [];

    public function __construct($url = null) {
        if ($url !== null) {
            $this->setUrl($url);
        }
    }

    public function setUrl($url) {
        $this->url = $url;
        $this->ch = curl_init($url);
        $this->setDefaultOptions();
        return $this;
    }

    public function setHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setHeaders($headers) {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function setOption($name, $value) {
        $this->options[$name] = $value;
        return $this;
    }

    public function setOptions($options) {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    public function get($data = null) {
        return $this->request("GET", $data);
    }

    public function post($data = null) {
        return $this->request("POST", $data);
    }

    public function put($data = null) {
        return $this->request("PUT", $data);
    }

    public function delete($data = null) {
        return $this->request("DELETE", $data);
    }

    public function request($method, $data = null) {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data !== null) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($this->ch, CURLOPT_VERBOSE, true);

        curl_setopt($this->ch, CURLOPT_STDERR, fopen('a.text', 'w'));
        $this->setHeadersOption();
        $this->setOptionsOption();
        $this->response = curl_exec($this->ch);
        return $this->response;
    }

    public function getResponse() {
        return $this->response;
    }

    public function getJsonResponse() {
        return json_decode($this->response);
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getOptions() {
        return $this->options;
    }

    private function setHeadersOption() {
        $headers = [];
        foreach ($this->headers as $name => $value) {
            $headers[] = "$name: $value";
        }
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
    }

    private function setOptionsOption() {
        foreach ($this->options as $name => $value) {
            curl_setopt($this->ch, $name, $value);
        }
    }

    private function setDefaultOptions() {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 38);
        //设置代理端口发出去
//        curl_setopt($this->ch, CURLOPT_PROXY, 'http://127.0.0.1:10809');
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false); // 不验证证书
    }

    public function __destruct() {
        curl_close($this->ch);
    }
}
