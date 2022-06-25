<?php
declare(strict_types=1);

/**
 * This file is part of "[HLModerators] Protect post for editing" Add-On for XenForo v2.2.x.
 * All rights reserved.
 *
 * Developed by HLModerators.
 */
namespace HLModerators\PostEditProtect\XF\Entity;


use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property bool $hlm_is_protected
 */
class Post extends XFCP_Post
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);
        $structure->columns['hlm_is_protected'] = ['type' => self::BOOL, 'default' => false, 'api' => true];

        return $structure;
    }

    public function canEdit(&$error = null)
    {
        $hasPermission = parent::canEdit($error);
        return $this->hlmVerifyPostIsProtected($hasPermission, 'editAnyPost');
    }

    public function canDelete($type = 'soft', &$error = null)
    {
        $hasPermission = parent::canDelete($type, $error);
        $permissionId = ($type === 'hard' ? 'hardDeleteAnyPost' : 'deleteAnyPost');

        return $this->hlmVerifyPostIsProtected($hasPermission, $permissionId);
    }

    public function canProtect(&$error = null): bool
    {
        $visitor = \XF::visitor();
        return $visitor->hasNodePermission($this->Thread->node_id, 'hlmProtectPost');
    }

    /**
     * Performs the validation "is post protected".
     *
     * @param bool $currentPermissionValue
     * @param string $permissionId
     * @return bool
     */
    protected function hlmVerifyPostIsProtected(bool $currentPermissionValue, string $permissionId): bool
    {
        if (!$currentPermissionValue)
        {
            return false;
        }

        $visitor = \XF::visitor();
        $nodeId = $this->Thread->node_id;
        if ($visitor->hasNodePermission($nodeId, $permissionId))
        {
            return true;
        }

        // Invert protect value.
        return !$this->hlm_is_protected;
    }
}
