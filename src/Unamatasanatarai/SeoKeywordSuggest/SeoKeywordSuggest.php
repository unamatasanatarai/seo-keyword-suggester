<?php

namespace Unamatasanatarai\SeoKeywordSuggest;

class SeoKeywordSuggest
{

    private $stopWords = [];

    private $punctuation = [
        ',',
        ')',
        '(',
        '.',
        "'",
        '"',
        '<',
        '>',
        '!',
        '?',
        '/',
        '-',
        '_',
        '[',
        ']',
        ':',
        '+',
        '=',
        '#',
        '$',
        '&quot;',
        '&copy;',
        '&gt;',
        '&lt;',
        '&nbsp;',
        '&trade;',
        '&reg;',
        ';',
    ];

    private $contents;

    private $minWordLength = 5;
    private $occurancesCount = 2;

    private $minWord2Length = 3;

    private $minWord3Length = 3;
    private $phrase3WordLengthMin = 10;

    public function __construct()
    {
        $this->appendPunctuation();
    }

    public function getKeywords()
    {
        return $this->parseWords() + $this->parse2Words() + $this->parse3Words();

    }

    private function replaceChars($content)
    {
        $content = mb_strtolower($content);
        $content = strip_tags($content);

        $content = str_replace($this->punctuation, " ", $content);
        $content = preg_replace('/ {2,}/si', " ", $content);

        return $content;
    }

    public function parseWords()
    {
        $arrayOfWords  = explode(" ", $this->contents);
        $arrayOfValues = [];
        foreach ($arrayOfWords as $key => $val) {
            if (mb_strlen(trim($val)) >= $this->minWordLength && ! in_array(trim($val),
                    $this->stopWords) && ! is_numeric(trim($val))
            ) {
                $arrayOfValues[] = trim($val);
            }
        }

        return $this->sortOutFilteredPhrases($arrayOfValues);
    }

    public function parse2Words()
    {
        $arrayOfWords  = explode(" ", $this->contents);
        $arrayOfValues = [];
        for ($i = 0; $i < count($arrayOfWords) - 1; $i++) {
            if ((mb_strlen(trim($arrayOfWords[ $i ])) >= $this->minWord2Length) && (mb_strlen(trim($arrayOfWords[ $i + 1 ])) >= $this->minWord2Length)) {
                $arrayOfValues[] = trim($arrayOfWords[ $i ]) . " " . trim($arrayOfWords[ $i + 1 ]);
            }
        }

        return $this->sortOutFilteredPhrases($arrayOfValues);
    }

    public function parse3Words()
    {
        $arrayOfWords  = explode(" ", $this->contents);
        $arrayOfValues = [];

        for ($i = 0; $i < count($arrayOfWords) - 2; $i++) {
            if ((mb_strlen(trim($arrayOfWords[ $i ])) >= $this->minWord3Length) && (mb_strlen(trim($arrayOfWords[ $i + 1 ])) > $this->minWord3Length) && (mb_strlen(trim($arrayOfWords[ $i + 2 ])) > $this->minWord3Length) && (mb_strlen(trim($arrayOfWords[ $i ]) . trim($arrayOfWords[ $i + 1 ]) . trim($arrayOfWords[ $i + 2 ])) > $this->phrase3WordLengthMin)) {
                $arrayOfValues[] = trim($arrayOfWords[ $i ]) . " " . trim($arrayOfWords[ $i + 1 ]) . " " . trim($arrayOfWords[ $i + 2 ]);
            }
        }

        return $this->sortOutFilteredPhrases($arrayOfValues);
    }

    private function occurancesFilter($array_count_values, $min_occur)
    {
        $occur_filtered = [];
        foreach ($array_count_values as $word => $occured) {
            if ($occured >= $min_occur) {
                $occur_filtered[ $word ] = $occured;
            }
        }

        return $occur_filtered;
    }

    private function appendPunctuation()
    {
        $this->punctuation[] = chr(10);
        $this->punctuation[] = chr(13);
        $this->punctuation[] = chr(9);
    }

    public function setStopWords($stopWords)
    {
        $this->stopWords = $stopWords;

        return $this;
    }

    public function setContent($content)
    {
        $this->contents = $this->replaceChars($content);

        return $this;
    }

    public function setPhrase3WordLengthMin($phrase3WordLengthMin)
    {
        $this->phrase3WordLengthMin = $phrase3WordLengthMin;

        return $this;
    }

    public function setMinWord3Length($minWord3Length)
    {
        $this->minWord3Length = $minWord3Length;

        return $this;
    }

    public function setMinWord2Length($minWord2Length)
    {
        $this->minWord2Length = $minWord2Length;

        return $this;
    }

    public function setOccurancesCount($occurancesCount)
    {
        $this->occurancesCount = $occurancesCount;

        return $this;
    }

    public function setMinWordLength($minWordLength)
    {
        $this->minWordLength = $minWordLength;

        return $this;
    }

    private function sortOutFilteredPhrases($arrayOfValues)
    {
        $arrayOfValues  = array_count_values($arrayOfValues);
        $occur_filtered = $this->occurancesFilter($arrayOfValues, $this->occurancesCount);
        arsort($occur_filtered);
        return $occur_filtered;
    }
}
