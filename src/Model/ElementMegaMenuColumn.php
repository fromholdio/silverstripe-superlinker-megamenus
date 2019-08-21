<?php

namespace Fromholdio\SuperLinkerMegaMenus\Model;

use Fromholdio\ElementalGroup\Model\ElementGroup;
use SilverStripe\Forms\DropdownField;

class ElementMegaMenuColumn extends ElementGroup
{
    private static $table_name = 'ElementMegaMenuColumn';
    private static $singular_name = 'Column';
    private static $plural_name = 'Columns';

    private static $max_width = 4;

    private static $db = [
        'Width' => 'Int'
    ];

    private static $field_labels = [
        'Width' => 'Column Width'
    ];

    private static $defaults = [
        'Width' => 1
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $widthOptions = [];
        $i = 1;
        while($i <= $this->getMaxWidth()) {
            $widthOptions[$i] = $i;
            $i++;
        }

        $widthField = DropdownField::create(
            'Width',
            $this->fieldLabel('Width'),
            $widthOptions
        );
        $widthField->setDescription('How many columns of the mega menu should this span?');
        $fields->insertBefore('Elements', $widthField);

        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();
        if ($this->Width < 1 || $this->Width > $this->getMaxWidth()) {
            $result->addFieldError('Width', 'Invalid width');
        }
        return $result;
    }

    public function getMaxWidth()
    {
        $max = $this->config()->get('max_width');
        $this->extend('updateMaxWidth', $max);
        return $max;
    }
}
