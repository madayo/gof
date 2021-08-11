<?php

namespace Test\AbstractFactory\MovieSite;

use Src\AbstractFactory\MovieSite\Factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /**
     * http 形式の URL になっていないもの
     */
    public function testIllegalFormatURL()
    {
        $url = '111';
        try {
            Factory::getConvertor($url);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('http で始まる URL 形式を指定してください。' . $url, $e->getMessage());
        }
    }

    /**
     * サポート外の URL
     */
    public function testUnsupportedURL()
    {
        $url = 'https://www.php.net/manual/ja/function.parse-url.php';
        try {
            Factory::getConvertor($url);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('対応していない動画サイトの URL です。 ' . $url, $e->getMessage());
        }
    }

    /**
     * Youtube
     */
    public function testYoutube()
    {
        // www.youtube.com/ で始まる、動画ページの URL の場合
        $url = 'https://www.youtube.com/watch?v=JwGxL2z9iN8';
        $convertor = Factory::getConvertor($url);
        $this->assertSame('JwGxL2z9iN8', $convertor->movieId());
        $this->assertSame('https://www.youtube.com/embed/JwGxL2z9iN8', $convertor->embedUrl());
        $this->assertSame('https://www.youtube.com/embed/JwGxL2z9iN8?rel=0&loop=1&playlist=JwGxL2z9iN8', $convertor->loopEmbedUrl());

        // youtube.com/ で始まる、動画ページの URL をコピーして、 www を取り除いた場合
        $url = 'https://youtube.com/watch?v=JwGxL2z9iN8';
        $convertor = Factory::getConvertor($url);
        $this->assertSame('JwGxL2z9iN8', $convertor->movieId());
        $this->assertSame('https://www.youtube.com/embed/JwGxL2z9iN8', $convertor->embedUrl());
        $this->assertSame('https://www.youtube.com/embed/JwGxL2z9iN8?rel=0&loop=1&playlist=JwGxL2z9iN8', $convertor->loopEmbedUrl());

        //  youtu.be/ で始まる、動画埋め込み用の短縮 URL の場合
        $url = 'https://youtu.be/JwGxL2z9iN8';
        $convertor = Factory::getConvertor($url);
        $this->assertSame('JwGxL2z9iN8', $convertor->movieId());
        $this->assertSame('https://www.youtube.com/embed/JwGxL2z9iN8', $convertor->embedUrl());
        $this->assertSame('https://www.youtube.com/embed/JwGxL2z9iN8?rel=0&loop=1&playlist=JwGxL2z9iN8', $convertor->loopEmbedUrl());
    }

    /**
     * Vimeo
     */
    public function testVimeo()
    {
        // 開始時間の指定なし
        $url = 'https://vimeo.com/50315573';
        $convertor = Factory::getConvertor($url);
        $this->assertSame('50315573', $convertor->movieId());
        $this->assertSame('https://player.vimeo.com/video/50315573?title=0&byline=0&portrait=0', $convertor->embedUrl());
        $this->assertSame('https://player.vimeo.com/video/50315573?title=0&byline=0&portrait=0&loop=1&autoplay=1', $convertor->loopEmbedUrl());
        // 開始時間の指定あり
        $url = 'https://vimeo.com/50315573#t=30s';
        $convertor = Factory::getConvertor($url);
        $this->assertSame('50315573', $convertor->movieId());
        $this->assertSame('https://player.vimeo.com/video/50315573?title=0&byline=0&portrait=0#t=30s', $convertor->embedUrl());
        $this->assertSame('https://player.vimeo.com/video/50315573?title=0&byline=0&portrait=0&loop=1&autoplay=1#t=30s', $convertor->loopEmbedUrl());
    }
}
