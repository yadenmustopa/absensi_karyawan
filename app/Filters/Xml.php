<?php

namespace App\Libraries;

class Xml
{

    public static function alphanumeric_only(string $text)
    {
        return preg_replace("/[^a-zA-Z0-9]+/", "", $text);
    }

    public static function convert($data, $name = 'response', &$doc = null, &$node = null)
    {
        $name = self::alphanumeric_only($name);
        if (null == $doc) {
            $doc = new \DOMDocument('1.0', 'UTF-8');
            $doc->formatOutput = true;
            $node = $doc;
        }

        if (is_array($data)) {
            foreach ($data as $var => $val) {
                if (is_numeric($var)) {
                    self::convert($val, $name, $doc, $node);
                } else {
                    if (!isset($child)) {
                        $child = $doc->createElement($name);
                        $node->appendChild($child);
                    }

                    self::convert($val, $var, $doc, $child);
                }
            }
        } else {
            $child = $doc->createElement($name);
            $node->appendChild($child);
            $textNode = $doc->createTextNode($data);
            $child->appendChild($textNode);
        }

        if ($doc === $node) {
            return $doc->saveXML();
        }
    }

    public static function array2xml($data)
    {
        $data = self::object_to_array_recursive($data);

        return self::convert($data);
    }

    public static function object_to_array_recursive($obj)
    {
        $array = (array) $obj;
        foreach ($array as &$attribute) {
            if (is_object($attribute) || is_array($attribute)) {
                $attribute = self::object_to_array_recursive($attribute);
            }
        }

        return $array;
    }
}
