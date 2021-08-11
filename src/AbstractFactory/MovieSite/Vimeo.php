<?php

namespace Src\AbstractFactory\MovieSite;

class Vimeo extends MovieSite
{
    private const EMBED_BASE_URL = 'https://player.vimeo.com/video/{movie_id}';

    /**
     * {@inheritdoc}
     */
    public function embedUrl(): string
    {
        $params = [
            'title' => '0',
            'byline' => '0',
            'portrait' => '0'
        ];
        return $this->_embedURL($params, $this->fragment !== '');
    }

    /**
     * {@inheritdoc}
     */
    public function loopEmbedUrl(): string
    {
        $params = [
            'title' => '0',
            'byline' => '0',
            'portrait' => '0',
            'loop' => '1',
            'autoplay' => '1'
        ];
        return $this->_embedURL($params, $this->fragment !== '');
    }

    /**
     * {@inheritdoc}
     */
    public function parseMovieId(): void
    {
        // /XXXXXX/ の形式で ID が埋め込まれている
        $this->movie_id = basename($this->path);
    }

    private function _embedURL(array $params, bool $time_designation = false): string
    {
        $url = str_replace('{movie_id}', $this->movie_id, self::EMBED_BASE_URL) . '?' . http_build_query($params);
        // 開始時間の指定あり
        if ($time_designation) {
            $url .= "#{$this->fragment}";
        }
        return $url;
    }
}
