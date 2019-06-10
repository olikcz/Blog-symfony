<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 24.05.2019
 * Time: 16:45
 */

namespace AppBundle\PageBundle\Controller;

use AppBundle\CommentBundle\Entity\Comment;
use AppBundle\CommentBundle\Forms\CommentForm;
use AppBundle\PageBundle\Entity\Page;
use AppBundle\PageBundle\Forms\PageDeleteForm;
use AppBundle\PageBundle\Forms\PageForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;



class PageController extends Controller
{


    public function listAction(Request $request)
    {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $pager = $request->query->get('page') ? $request->query->get('page') : 1;
        $limit = 4;
        $termRepo = $this->getDoctrine()->getRepository('TermBundle:Term');
        $pages = $pageRepo->findPages($pager, $limit);
        $terms = $termRepo->findAll();
        $pager = [
            'pager' => $pager,
            'total' => $pageRepo->countPage(),
            'limit' => $limit
        ];
        return $this->render('@Page/Page/list.html.twig', [
            'pages' => $pages,
            'terms' => $terms,
            'navigator' => $pager
        ]);
    }

    public function addAction(Request $request, UserInterface $user = null)
    {
        $page = new Page();
        $form = $this->createForm(PageForm::class, $page);
        $form->handleRequest($request);
        $userRepo = $this->getDoctrine()->getRepository('UserBundle:User');
        $user_id = $userRepo->findOneByid($user->getId());
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $page->setUser($user_id);
            $em->flush();
            $this->addFlash('success', 'Post created successfully');
            return $this->redirectToRoute('admin_page');
        }
        return $this->render('@Page/Page/add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    public function viewAction($id, Request $request, UserInterface $user = null)
    {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        /** @var  Page $page */
        $page = $pageRepo->find($id);
        $userRepo = $this->getDoctrine()->getRepository('UserBundle:User');
        if ($user === null) {
            $user_id = 'Guest';
        } else {
            $user_id = $userRepo->findOneByid($user->getId());
        }
        if (!$page) {
            throw $this->createNotFoundException('The page doest not exist.');
        }
        $commentRepo = $this->getDoctrine()->getRepository(Comment::class);
        $comment_id = $commentRepo->findLast();

        $em = $this->getDoctrine()->getManager();
        $commentForm = $this->createForm(CommentForm::class);
        $commentForm->handleRequest($request);
        $user = $userRepo->findOneById($user_id);
        $ipAddress = $request->getClientIp();

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            /** @var Comment $comment */
            $comment = $commentForm->getData();
            $comment->setPage($page);
            $comment->setUser($user_id);
            $comment->setIsDeleted(false);
            $comment->setParentCommentId($comment_id[1]+1);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('page_view', [
                'id' => $page->getId()
            ]);
        }
        $commentRepo = $em->getRepository(Comment::class);
        $comments = $commentRepo->findLastComments($page, 20);

        return $this->render('@Page/Page/view.html.twig', [
                'page' => $page,
                'comment_form' => $commentForm->createView(),
                'page_comments' => $comments,
                'user' => $user,
                'ip' => $ipAddress
            ]
        );
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PageBundle:Page');
        $page = $repo->find($id);
        if (!$page) {
            return $this->redirectToRoute('page_list');
        }
        $form = $this->createForm(PageForm::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $page->setUpdatedAt(new \DateTime());
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute('admin_page', [
                'id' => $page->getId()
            ]);
        }
        return $this->render('@Page/Page/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function removeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PageBundle:Page');
        $page = $repo->find($id);
        if (!$page) {
            return $this->redirectToRoute('page_list');
        }
        $form = $this->createForm(PageDeleteForm::class, null, [
            'delete_id' => $page->getId()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($page);
            $em->flush();
            $this->addFlash('warning', 'Deleted Successfully!');
            return $this->redirectToRoute('admin_page');

        }
        return $this->render('@Page/Page/delete.html.twig', [
            'form' => $form->createView(),
            'page' => $page
        ]);
    }

    public function commentsAction($id, Request $request)
    {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        /** @var  Page $page */
        $page = $pageRepo->find($id);
        if (!$page) {
            throw $this->createNotFoundException('The page doest not exist.');
        }
        $pager = $request->query->get('pager') ? $request->query->get('pager') : 1;
        $limit = 6;
        $commentRepo = $this->getDoctrine()->getRepository('CommentBundle:Comment');
        $comments = $commentRepo->findComments($page, $pager, $limit);
        $pager = [
            'pager' => $pager,
            'total' => $commentRepo->countComments($page),
            'limit' => $limit
        ];
        return $this->render('@Page/Page/page_comments.html.twig', [
                'page' => $page,
                'comments' => $comments,
                'navigator' => $pager
            ]
        );
    }

    public function categoryAction($id)
    {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $pages = $pageRepo->findBycategory($id);
        return $this->render('@Page/Page/page_category.html.twig', [
            'pages' => $pages
        ]);
    }

    public function userAction($id)
    {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $pages = $pageRepo->findByuser($id);
        return $this->render('@Page/Page/page_category.html.twig', [
            'pages' => $pages
        ]);
    }


}