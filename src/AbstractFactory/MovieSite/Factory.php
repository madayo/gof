<?php

namespace Src\AbstractFactory\MovieSite;

class Factory
{
    public static function getConvertor(string $url): MovieSite
    {
        $parsed_url = parse_url($url);
        if (!$parsed_url || !isset($parsed_url['host'])) {
            throw new \InvalidArgumentException('http で始まる URL 形式を指定してください。' . $url);
        }

        if (self::matchYoutube($parsed_url['host'])) {
            return new Youtube($parsed_url);
        } elseif (self::matchYoutubeShort($parsed_url['host'])) {
            return new Youtube($parsed_url, true);
        } elseif (self::matchVimeo($parsed_url['host'])) {
            return new Vimeo($parsed_url);
        }

        throw new \InvalidArgumentException('対応していない動画サイトの URL です。 ' . $url);
    }

    private function __construct()
    {
    }

    private static function matchYoutube(string $host): bool
    {
        return preg_match("/youtube\.com$/i", $host) === 1;
    }

    private static function matchYoutubeShort(string $host): bool
    {
        return preg_match("/youtu\.be$/i", $host) === 1;
    }

    private static function matchVimeo(string $host): bool
    {
        return preg_match("/vimeo\.com$/i", $host) === 1;
    }
}
