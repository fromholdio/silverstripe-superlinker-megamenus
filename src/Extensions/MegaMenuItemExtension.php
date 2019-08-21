<?php

namespace Fromholdio\SuperLinkerMegaMenus\Extensions;

use DNADesign\Elemental\Forms\ElementalAreaField;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class MegaMenuItemExtension extends DataExtension
{
    const SUBMENU_MEGA = 'mega';

    private static $has_one = [
        'SubmenuArea' => ElementalArea::class
    ];

    private static $owns = [
        'SubmenuArea'
    ];

    private static $cascade_deletes = [
        'SubmenuArea'
    ];

    public function updateMenuItemCMSFields(FieldList &$fields)
    {
        $types = $this->getOwner()->getElementalTypes('SubmenuArea');
        if (!$types || !is_array($types) || count($types) < 1) {
            return;
        }

        $submenuAreaField = ElementalAreaField::create(
            'SubmenuArea',
            $this->getOwner()->SubmenuArea(),
            $types
        );
        $submenuAreaWrapper = Wrapper::create($submenuAreaField);
        $submenuAreaWrapper->displayIf('SubmenuMode')->isEqualTo(self::SUBMENU_MEGA);

        $fields->addFieldToTab(
            'Root.Main.SubmenuTab',
            $submenuAreaWrapper
        );
    }
}
