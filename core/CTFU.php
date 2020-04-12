<?php
class CTFU
{

    private $url = null;
    private $parts = array(), $params = array();
    private $cleanparams = array();

    private $blacklisted = array(
        "utm_source" => '',
        "utm_medium" => '',
        "utm_campaign" => '',
        "utm_content" => '',
        "utm_term" => '',
        "utm_creative" => '',
        "gclid" => '',
        'referrer' => ''
    );

    private $suspsterms = array(
        "utm" => ''
    );

    public function url($url){
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $this->url = $url;
            $this->parts = parse_url($url);

            if (!empty($this->parts['query'])) {
                $this->parms = parse_str($this->parts['query'], $this->params);
                return true;
            }
        }
        return false;
    }

    public function clean()
    {
        //$this->checkSuspects();
        $this->cleanparams = $this->removeBlacklisted();
    }

    public function removeBlacklisted()
    {
        return array_diff_key($this->params, $this->blacklisted);
    }

    public function checkSuspects()
    {
        $founded = array();
        $result = array();
        foreach ($this->suspsterms as $term) {
            $term = preg_quote($term, '~');
            $result = preg_grep('~' . $term . '~', $this->params);
            if (!empty($result)) {
                foreach ($result as $row) {
                    $founded[] = $row;
                }
            }
        }
        die(var_dump($founded));
    }

    public function createURL()
    {
        $url = '';
        $url .= $this->parts['scheme'] . '://' . $this->parts['host'] . $this->parts['path'] . http_build_query($this->cleanparams);
        return $url;
    }

    public function getParameters(){
        $string = '';
        $i = 0;
        foreach($this->blacklisted as $key => $par){
            $i++;
            if($i != count($this->blacklisted)){
                $string .= $key.', ';
            }else{
                $string .= $key;
            }

        }
        echo $string;
    }
}