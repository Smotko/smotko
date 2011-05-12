<?php

class Zend_View_Helper_AddLink {
    
    const REGEX = "~(?:https?://(?:(?:(?:(?:(?:[a-žA-Ž\d](?:(?:[a-žA-Ž\d]|-)*[a-žA-Ž\d])?)\.)*(?:[a-žA-Ž](?:(?:[a-žA-Ž\d]|-)*[a-žA-Ž\d])?))|(?:(?:\d+)(?:\.(?:\d+)){3}))(?::(?:\d+))?)(?:/(?:(?:(?:(?:[a-žA-Ž\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=#/])*)(?:/(?:(?:(?:[a-žA-Ž\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=#/])*))*)(?:\?(?:(?:(?:[a-žA-Ž\d$\-_.+!*'(),]|(?:%[a-fA-F\d]{2}))|[;:@&=#/])*))?)?)~";
    const MAXSIZE = 25;

    /**
     * Filter the text.
     *
     * The filtering may take some time, depending on how many links are in
     * the text to be shortened, how responsive the service is, etc.
     *
     * @param string $text
     * @return string
     */
    public function addLink($text)
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

