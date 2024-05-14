<?php

namespace App\Services\Http;

class RedirectResponse implements ResponseInterface
{
    protected int $statusCode = 301;
    protected string $contentType = 'text/html';
    protected ?string $content = null;
    protected string $location;

    public function __construct(string $location)
    {
        $this->location = $location;
    }

    public function send(): void
    {
        $message = match ($this->getStatusCode()) {
            301 => 'Moved Permanently',
            302 => 'Found (Moved Temporarily)',
            307 => 'Temporary Redirect',
            404 => 'Not Found',
        };

        header('HTTP/1.1 ' . $this->getStatusCode() . ' ' . $message);
        header('Location: ' . $this->getLocation());

        exit();
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return RedirectResponse
     */
    public function setStatusCode(int $statusCode): RedirectResponse
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     * @return RedirectResponse
     */
    public function setContentType(string $contentType): RedirectResponse
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     * @return RedirectResponse
     */
    public function setContent(?string $content): RedirectResponse
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return RedirectResponse
     */
    public function setLocation(string $location): RedirectResponse
    {
        $this->location = $location;
        return $this;
    }
}