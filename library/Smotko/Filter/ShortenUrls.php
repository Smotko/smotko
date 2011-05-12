<?php

class Smotko_Filter_ShortenUrls implements Zend_Filter_Interface
{
    const REGEX = "~(?:https?://(?:(?:(?:(?:(?:[a-zA-Z\d](?:(?:[a-zA-Z\d]|-)*[a-zA-Z\d])?)\.)*(?:[a-zA-Z](?:(?:[a-zA-Z\d]|-)*[a-zA-Z\d])?))|(?:(?:\d+)(?:\.(?:\d+)){3}))(?::(?:\d+))?)(?:/(?:(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*)(?:/(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*))*)(?:\?(?:(?:(?:[a-zA-Z\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=])*))?)?)~";
    const MAXSIZE = 35;

    /**
     * Filter the text.
     *
     * The filtering may take some time, depending on how many links are in
     * the text to be shortened, how responsive the service is, etc.
     *
     * @param string $text
     * @return string
     */
    public function filter($text)
    {

        $matches = $replacements = array();
        
        $matched = preg_match_all(self::REGEX, $text, $matches, PREG_PATTERN_ORDER);
        if ($matched) {

            foreach ($matches[0] as $url) {
                if (strlen($url) > self::MAXSIZE) {
                    $urlShort = str_split($url, self::MAXSIZE);
                    $urlShort = $urlShort[0] . '/.../';
                }
                else{
                    $urlShort = $url;
                }
                $replacements[$url] = '<a href = "' . $url . '" title = "' . $url . '">' . $urlShort . "</a>";

            }
        }
        if (empty($replacements)) {
            return $text;
        }
        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $text
        );
    }
}