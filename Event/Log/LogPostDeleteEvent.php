<?php

namespace Icap\BlogBundle\Event\Log;

use Claroline\CoreBundle\Entity\Resource\ResourceNode;
use Claroline\CoreBundle\Event\Log\AbstractLogResourceEvent;
use Icap\BlogBundle\Entity\Blog;
use Icap\BlogBundle\Entity\BlogOptions;
use Icap\BlogBundle\Entity\Post;

class LogPostDeleteEvent extends AbstractLogResourceEvent
{
    const ACTION = 'resource-icap_blog-post_delete';

    /**
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $details = array(
            'post' => array(
                'blog'   => $post->getBlog()->getId(),
                'title'  => $post->getTitle(),
                'slug'   => $post->getSlug(),
                'author' => $post->getAuthor()->getFirstName() . ' ' . $post->getAuthor()->getLastName()
            )
        );

        parent::__construct($post->getBlog()->getResourceNode(), $details);
    }

    /**
     * @return array
     */
    public static function getRestriction()
    {
        return array(self::DISPLAYED_WORKSPACE);
    }
}
