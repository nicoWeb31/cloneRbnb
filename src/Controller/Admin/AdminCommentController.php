<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment_index")
     */
    public function index(CommentRepository $repo)
    {

        $comments = $repo->findAll();

        return $this->render('admin/admin_comment/index.html.twig', [
            'comments' => $comments
        ]);
    }
}
