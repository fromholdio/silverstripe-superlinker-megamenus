<?php

namespace Fromholdio\SuperLinkerMegaMenus\Extensions;

use Fromholdio\SuperLinkerMenus\Model\MenuItem;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;

class BaseElementCMSEditLinkExtension extends Extension
{
    public function updateCMSEditLink(&$link)
    {
        $owner = $this->getOwner();

        $relationName = $owner->getAreaRelationName();
        $page = $owner->getPage(true);

        if (!$page) {
            return;
        }

        if ($page instanceof MenuItem && $relationName === 'SubmenuArea') {
            $link = Controller::join_links(
                $page->CMSEditLink(),
                'ItemEditForm/field/SubmenuArea/item/',
                $owner->ID
            );
        }
    }
}
