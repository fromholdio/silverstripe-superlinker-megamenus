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

        if (is_a($page, MenuItem::class) && $relationName === 'SubmenuArea') {
            $link = $page->CMSEditLink();
            $link = preg_replace('/\/item\/([\d]+)\/edit/', '/item/$1', $link);
            $link = Controller::join_links(
                $link,
                'ItemEditForm/field/SubmenuArea/item',
                $owner->ID,
                'edit'
            );
        }
    }
}
