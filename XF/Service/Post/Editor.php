<?php
declare(strict_types=1);

/**
 * This file is part of "[HLModerators] Protect post for editing" Add-On for XenForo v2.2.x.
 * All rights reserved.
 *
 * Developed by HLModerators.
 */
namespace HLModerators\PostEditProtect\XF\Service\Post;


class Editor extends XFCP_Editor
{
    public function setPostIsProtected($isProtected = null)
    {
        $isProtected = ($isProtected == true || $isProtected === null);

        $this->post->hlm_is_protected = $isProtected;
    }
}
