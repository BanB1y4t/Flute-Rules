<?php

namespace Flute\Modules\Rules\database\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\HasOne;

/**
 * @Entity()
 */
class RulesItem
{
    /** @Column(type="primary") */
    public $id;

    /** @Column(type="string") */
    public string $question;

    /** @HasOne(target="RulesItemBlock") */
    public $blocks;

    /**
     * @Column(type="timestamp", default="CURRENT_TIMESTAMP")
     */
    public $created_at;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }
}
