<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use App\Repository\PostRepository;
use Framework\Base\Controller\BaseController;
use Framework\Http\Router\Handler\NotFound;
use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction extends BaseController
{
    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    /**
     * @var NotFound
     */
    private NotFound $notFoundHandler;

    public function __construct(
        RendererInterface $renderer,
        NotFound $notFoundHandler,
        PostRepository $postRepository
    ) {
        parent::__construct($renderer);
        $this->postRepository = $postRepository;
        $this->notFoundHandler = $notFoundHandler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (!$post = $this->postRepository->find($request->getAttribute('id'))) {
            return ($this->notFoundHandler)->handle($request);
        }

        return new HtmlResponse($this->render('main/blog/show', [
            'post' => $post,
        ]));
    }
}
