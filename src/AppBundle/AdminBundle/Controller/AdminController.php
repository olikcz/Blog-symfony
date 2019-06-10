<?php
/**
 * Created by PhpStorm.
 * User: BOSS
 * Date: 01.06.2019
 * Time: 11:39
 */

namespace AppBundle\AdminBundle\Controller;

use AppBundle\PageBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function dashboardAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $pageRepo = $this->getDoctrine()->getRepository(Page::class);
        $pager = $request->query->get('page') ? $request->query->get('page') : 1;
        $limit = 8;
        $pages = $pageRepo->findPages($pager, $limit);
        $pager = [
            'pager' => $pager,
            'total' => $pageRepo->countPage(),
            'limit' => $limit
        ];
        return $this->render('@Admin/Page/dashboard.html.twig',
            [
                'pages' => $pages,
                'navigator' => $pager
            ]);
    }
}