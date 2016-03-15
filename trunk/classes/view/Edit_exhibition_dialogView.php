<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 15.03.16
 * Time: 16:56
 */
class Edit_exhibition_dialogView extends View
{

    private $editMode;

    public function __construct($editMode = false)
    {
        parent::__construct(null);
        $this->editMode = $editMode;
    }

    public function getTitle()
    {
        return (true)
            ? "Neue Ausstellung hinzufügen"
            : "Ausstellung bearbeiten";
    }

    public function isEditMode()
    {
        return $this->editMode;
    }

}