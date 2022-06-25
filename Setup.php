<?php
declare(strict_types=1);

/**
 * This file is part of "[HLModerators] Protect post for editing" Add-On for XenForo v2.2.x.
 * All rights reserved.
 *
 * Developed by HLModerators.
 */
namespace HLModerators\PostEditProtect;


use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function installStep1()
    {
        $this->applyContentPermission('forum', 'hlmProtectPost', 'forum',
            'editAnyPost');
        $this->applyGlobalPermission('forum', 'hlmProtectPost', 'forum',
            'editAnyPost');
    }

    public function installStep2()
    {
        $this->alterTable('xf_post', function (Alter $table)
        {
            $table->addColumn('hlm_is_protected', 'bool')
                ->setDefault(0);
        });
    }

    public function uninstallStep1()
    {
        $this->alterTable('xf_post', function (Alter $table)
        {
            $table->dropColumns(['hlm_is_protected']);
        });
    }
}
