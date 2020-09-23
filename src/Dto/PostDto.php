<?php


namespace App\Dto;


use JMS\Serializer\Annotation as Serializer;

class PostDto
{

    private $id;
    /**
     * @var string| array
     *
     * @Serializer\Type("string|array")
     * @Serializer\SerializedName("orderStatus")
     */
    private $status;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

}