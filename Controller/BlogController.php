<?php

namespace ICAP\BlogBundle\Controller;

use ICAP\BlogBundle\Entity\Blog;
use ICAP\BlogBundle\Entity\BlogOptions;
use ICAP\BlogBundle\Entity\Post;
use ICAP\BlogBundle\Form\PostType;
use ICAP\BlogBundle\Form\BlogOptionsType;
use Pagerfanta\Adapter\DoctrineCollectionAdapter;
use Pagerfanta\Pagerfanta;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route(
     *      "/{blogId}/{page}",
     *      name="icap_blog_view",
     *      requirements={"blogId" = "\d+", "page" = "\d+"}, defaults={"page" = 1}
     * )
     * @ParamConverter("blog", class="ICAPBlogBundle:Blog", options={"id" = "blogId"})
     * @Template()
     */
    public function viewAction(Blog $blog, $page)
    {
        $this->checkAccess("OPEN", $blog);

        $adapter = new DoctrineCollectionAdapter($blog->getPosts());
        $pager   = new Pagerfanta($adapter);

        return array(
            '_resource' => $blog,
            'pager'     => $pager
        );
    }

    /**
     * @Route(
     *      "/configure/{blogId}",
     *      name="icap_blog_configure",
     *      requirements={"blogId" = "\d+"}
     * )
     * @ParamConverter("blog", class="ICAPBlogBundle:Blog", options={"id" = "blogId"})
     * @Template()
     */
    public function configureAction(Request $request, Blog $blog)
    {
        $this->checkAccess("EDIT", $blog);

        $form = $this->createForm(new BlogOptionsType(), new BlogOptions());

        if("POST" === $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                return $this->redirect($this->generateUrl('icap_blog_configure', array('blogId' => $blog->getId())));
            }
        }

        return array(
            '_resource' => $blog,
            'form'      => $form->createView()
        );
    }
}
