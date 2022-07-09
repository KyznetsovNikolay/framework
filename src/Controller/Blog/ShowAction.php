<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use App\Repository\PostRepository;
use Framework\Base\Controller\BaseController;
use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction extends BaseController
{
    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    public function __construct(RendererInterface $renderer, PostRepository $postRepository)
    {
        parent::__construct($renderer);
        $this->postRepository = $postRepository;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        if (!$post = $this->postRepository->find($request->getAttribute('id'))) {
            return $next($request);
        }

        return new HtmlResponse($this->render('main/blog/show', [
            'post' => $post,
        ]));
    }
}
