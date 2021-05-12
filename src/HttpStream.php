<?php
namespace YPHP;

class HttpStream extends Stream{

    private $meta;

    /**
     * Returns the remaining contents in a string
     *
     * @return string
     * @throws \RuntimeException if unable to read or an error occurs while
     *     reading.
     */
    public function getContents(){
        return file_get_contents($this->source);
    }

    public function getHeaders(){
        $wrapper_data = $this->meta['wrapper_data'];
        $headers = [];
        foreach ($wrapper_data as $value) {
            $s = explode(':',$value);
            $headers[$s[0]] = @$s[1];
        }
        return $headers;
    }

    public function getMetadata($key = null){
        $url = $this->getSource();
        if (!$fp = fopen($url, 'r')) {
            trigger_error("Unable to open URL ($url)", E_USER_ERROR);
        }
        $meta = stream_get_meta_data($fp);
        fclose($fp);
        $this->meta = $meta;
        return $meta[$key];
    }
}