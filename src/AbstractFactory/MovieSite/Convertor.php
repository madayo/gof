<?php

namespace Src\AbstractFactory\MovieSite;

interface Convertor
{
    /**
     * 埋め込み用の URL を取得する
     * @return string
     */
    public function embedUrl(): string;

    /**
     * ループ再生用のパラメータを付与した埋め込み用の URL
     * @return string
     */
    public function loopEmbedUrl(): string;

    /**
     * URL 中から動画 ID にあたる文字列を抜き出す
     * @return void
     */
    public function parseMovieId(): void;
}