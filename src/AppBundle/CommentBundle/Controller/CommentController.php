<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 27.05.2019
 * Time: 18:11
 */

namespace AppBundle\CommentBundle\Controller;


use AppBundle\CommentBundle\Entity\Comment;
use AppBundle\CommentBundle\Forms\CommentDeleteForm;
use AppBundle\CommentBundle\Forms\CommentForm;
use AppBundle\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentController extends Controller
{
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Comment::class);
        $comment = $repo->find($id);
        if (!$comment) {
            $this->redirectToRoute('homepage');
        }
        $form = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $page = $comment->getPage();
            $comment->setCreated(new \DateTime());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('page_view', [
                'id' => $page->getId()
            ]);
        }
        return $this->render('@Comment/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function removeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Comment::class);
        $comment = $repo->find($id);
        if (!$comment) {
            return $this->redirectToRoute('page_list');
        }
        $form = $this->createForm(CommentDeleteForm::class, null, [
            'delete_id' => $comment->getId()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $page = $comment->getPage();
            /**
             *  delete comment with all his replies
             */
            if($id == $comment->getParentCommentId()) {
                $commentRepo = $this->getDoctrine()->getRepository(Comment::class);
                $comments = $commentRepo->findThread($id);
                foreach($comments as $_comment){
                    $_id = (int)$_comment['id'];
                    $comment = $commentRepo->findOneById($_id);
                    $comment->setIsDeleted(true);
                    $em->persist($comment);
                    $em->flush($comment);
                }
            } else {
                /**
                 *  delete comment withou replies or delete reply
                 */
                $comment->setIsDeleted(true);
            }


            $em->flush();
            return $this->redirectToRoute('page_view', [
                'id' => $page->getId()
            ]);
        }
        return $this->render('@Comment/delete.html.twig',[
            'form' => $form->createView()
        ]);
    }
    public function replyAction($id, Request $request, UserInterface $user = null){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Comment::class);
        $comment = $repo->find($id);
        $userRepo = $em->getRepository(User::class);
        $user_id = $userRepo->findOneByid($user->getId());
        if (!$comment) {
            return $this->redirectToRoute('page_list');
        }
        $commentForm = $this->createForm(CommentForm::class);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $page = $comment->getPage();
            $comment = $commentForm->getData();
            $comment->setPage($page);
            $comment->setUser($user_id);

            $comment->setIsDeleted(false);
            $comment->setParentCommentId($id);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('page_view', [
                'id' => $page->getId()
            ]);
        }
        return $this->render('@Comment/add.html.twig',[
            'form' => $commentForm->createView()
        ]);
    }

}