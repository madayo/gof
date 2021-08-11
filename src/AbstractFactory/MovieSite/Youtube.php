<?php

namespace Src\AbstractFactory\MovieSite;

class Youtube extends MovieSite
{
    private const EMBED_BASE_URL = 'https://www.youtube.com/embed/{movie_id}';

    /**
     * @var bool youtu.be/ で始まる短縮 URL であるか？
     */
    private bool $is_short_url;

    public function __construct(array $parsed_url, bool $is_short_url = false)
    {
        $this->is_short_url = $is_short_url;
        parent::__construct($parsed_url);
    }

    /**
     * {@inheritdoc}
     */
    public function embedUrl(): string
    {
        return str_replace('{movie_id}', $this->movie_id, self::EMBED_BASE_URL);
    }

    /**
     * {@inheritdoc}
     */
    public function loopEmbedUrl(): string
    {
        // 関連動画を再生した動画と同じチャンネル内に限定する。再生を自動ループさせる。
        $params = [
            'rel' => '0',
            'loop' => '1',
            'playlist' => $this->movie_id
        ];

        return $this->embedUrl() . '?' . http_build_query($params);
    }

    /**
     * {@inheritdoc}
     */
    public function parseMovieId(): void
    {
        if ($this->is_short_url) {
            // /XXXXXX/ の形式で ID が埋め込まれている
            $this->movie_id = basename($this->path);
        } else {
            // クエリストリングの分解
            parse_str($this->query, $query_string);
            // ?v=XXXXXX の形式で ID が埋め込まれている
            $this->movie_id = $query_string['v'];
        }
    }
}
