<?php

namespace Src\AbstractFactory\MovieSite;

abstract class MovieSite implements Convertor
{
    protected string $scheme;
    protected string $host;
    protected string $port;
    protected string $user;
    protected string $pass;
    protected string $path;
    protected string $query;
    protected string $fragment;
    protected string $movie_id;

    public function __construct(array $parsed_url)
    {
        $this->scheme = $parsed_url['scheme'] ?? '';
        $this->host = $parsed_url['host'] ?? '';
        $this->port = $parsed_url['port'] ?? '';
        $this->user = $parsed_url['user'] ?? '';
        $this->pass = $parsed_url['pass'] ?? '';
        $this->path = $parsed_url['path'] ?? '';
        $this->query = $parsed_url['query'] ?? '';
        $this->fragment = $parsed_url['fragment'] ?? '';

        $this->parseMovieId();
    }

    /**
     * @return string
     */
    public function movieId(): string
    {
        return $this->movie_id;
    }
}
