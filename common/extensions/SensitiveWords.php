<?php

/**
 * 锟斤拷锟叫词硷拷锟?
 * User: thinkpad
 * Date: 2016/7/19
 * Time: 16:37
 */
class SensitiveWords
{
    /**
     * 锟斤拷锟斤拷欠锟斤拷锟斤拷写锟?
     * @return bool
     */
    public static function checkWords($content)
    {
        $result = false;
        $filePath = self::getWordsDicPath();
        if (function_exists('trie_filter_search_all') && file_exists($filePath)) {
            $file = trie_filter_load($filePath);
            $res = trie_filter_search_all($file, $content);  // 一锟轿帮拷锟斤拷锟叫碉拷锟斤拷锟叫词讹拷锟斤拷锟斤拷锟斤拷
            trie_filter_free($file);
            if ($res)
                $result = true;
        }
        return $result;
    }

    /**
     * 锟斤拷锟斤拷锟斤拷锟叫达拷锟街碉拷
     * @return bool
     */
    public static function updateWords($words = array())
    {
        $result = false;
        $str = '';
        $file = dirname(__FILE__) . '/words.txt';
        $fp = @fopen($file, 'ab');
        if (!$fp) die("Open $file failed");
        foreach ($words as $w) {
            $str .= $w . "\n";
            fwrite($fp, $str);
        }
        if ($fp) @fclose($fp);
        $wordsDicPath = self::getWordsDicPath();
        $command = '/root/tools/trie_filter/dpp ' . $file . ' ' . $wordsDicPath;
        exec($command);
        if (file_exists($wordsDicPath))
            $result = true;
        return $result;
    }

    private static function getWordsDicPath(){
        $file = dirname(__FILE__).'/words.dic';
        return $file;
    }
}