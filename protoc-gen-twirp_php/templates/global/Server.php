<?php
# Generated by the protocol buffer compiler (protoc-gen-twirp_php {{ .Version }}).  DO NOT EDIT!

namespace {{ .Namespace }};

use Psr\Http\Message\ServerRequestInterface;
use Twirp\RequestHandler;

/**
 * Collects server implementations and routes requests based on their prefix.
 */
final class Server extends TwirpServer implements RequestHandler
{
    /**
     * @var RequestHandler[]
     */
    private $handlers = [];

    /**
     * Registers a server instance for a prefix.
     *
     * @param string         $prefix
     * @param RequestHandler $server
     */
    public function registerServer($prefix, RequestHandler $server)
    {
        $this->handlers[$prefix] = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(ServerRequestInterface $req)
    {
        foreach ($this->handlers as $prefix => $handler) {
            if (strpos($req->getUri()->getPath(), $prefix) == 0) {
                return $handler->handle($req);
            }
        }

        return $this->writeError([], $this->noRouteError($req));
    }
}
