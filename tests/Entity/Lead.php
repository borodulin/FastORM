<?php


namespace FastOrm\Tests\Entity;


class Lead
{
    private $id;

    private $communication_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCommunicationId()
    {
        return $this->communication_id;
    }

    /**
     * @param mixed $communication_id
     */
    public function setCommunicationId($communication_id): void
    {
        $this->communication_id = $communication_id;
    }
}
