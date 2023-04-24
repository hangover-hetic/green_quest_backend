<?php

namespace App\Controller;


use App\Entity\FeedPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CreateFeedPostController extends AbstractController
{
    public function __invoke(Request $request): FeedPost
    {
        $feedPost = new FeedPost();
        $feedPost->setAuthor($this->getUser());
        $feedPost->setCreatedAt(new \DateTimeImmutable());
        $feedPost->setFeed($request->get("feed"));
        $feedPost->setTitle($request->get("title"));
        $feedPost->setContent($request->get("content"));
        $coverFile = $request->files->get("imageFile");
        if($coverFile) {
            $feedPost->setImageFile($coverFile);
        }
        return $feedPost;
    }
}
