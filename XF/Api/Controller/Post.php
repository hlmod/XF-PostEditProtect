<?php
declare(strict_types=1);

/**
 * This file is part of "[HLModerators] Protect post for editing" Add-On for XenForo v2.2.x.
 * All rights reserved.
 *
 * Developed by HLModerators.
 */
namespace HLModerators\PostEditProtect\XF\Api\Controller;


use HLModerators\PostEditProtect\XF\Service\Post\Editor;

class Post extends XFCP_Post
{
    /**
     * @param \XF\Entity\Post|\HLModerators\PostEditProtect\XF\Entity\Post $post
     * @return \XF\Service\Post\Editor|Editor
     */
    protected function setupPostEdit(\XF\Entity\Post $post)
    {
        /** @var Editor $postEditor */
        $postEditor = parent::setupPostEdit($post);
        if (\XF::isApiBypassingPermissions() || $post->canProtect())
        {
            $postEditor->setPostIsProtected($this->filter('hlm_is_protected', 'bool'));
        }

        return $postEditor;
    }
}
