<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Form\CommentAdminType;
use App\Repository\CommentRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page}", name="admin_comment_index")
     * @return  response
     */
    public function index(CommentRepository $repo,$page,PaginationService $pagi)
    {

        $pagi->setEntityClass(Comment::class)
            ->setCurrentPage($page);

        return $this->render('admin/admin_comment/index.html.twig', [
            'paginations'=>$pagi
        ]);
    }

    /**
     * for edit a comment in administartion
     * @Route("/admin/comments/{id}/edit", name="admin_comment_edit")
     * @return response
     */
    public function edit(Comment $comment,Request $req, EntityManagerInterface $man)
    {


        $form = $this->createForm(CommentAdminType::class,$comment);


        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){

            $man->persist($comment);
            $man->flush();

            $this->addFlash('success', "Le commentaire {$comment->getId()} à étét modifier avec succès !");
            return $this->redirectToRoute('admin_comment_index');

        }

        return $this->render('admin/admin_comment/edit.html.twig', [
            'comment' => $comment,
            'form'=>$form->createView()
        ]);
    }




    /**
     * for delete a comment in administartion
     * @Route("/admin/comments/{id}/delete", name="admin_comment_delete")
     * @return response
     */
    public function delete(Comment $comment, EntityManagerInterface $man)
    {

        $man->remove($comment);
        $man->flush();

        $this->addFlash('success', "le Commentaire de <strong>{$comment->getAuthor()->getFullName()}</strong> à été supprimé avec succées ! ");
        return $this->redirectToRoute('admin_comment_index');

    }

}

