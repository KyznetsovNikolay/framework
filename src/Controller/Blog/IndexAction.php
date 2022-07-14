<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use App\Repository\PostRepository;
use Framework\Base\Controller\BaseController;
use Framework\Base\Helper\Pagination;
use Framework\Template\RendererInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexAction extends BaseController
{
    private const PER_PAGE = 5;

    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    public function __construct(RendererInterface $renderer, PostRepository $postRepository)
    {
        parent::__construct($renderer);
        $this->postRepository = $postRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $page = $request->getAttribute('page') ?: 1;
        $pager = new Pagination(
            $this->postRepository->count(),
            (int)$page,
            self::PER_PAGE
        );

        $posts = $this->postRepository->getAll(
            $pager->getOffset(),
            $pager->getLimit()
        );

        return new HtmlResponse($this->render('main/blog/index', [
            'posts' => $posts,
            'pager' => $pager,
        ]));
    }
}
