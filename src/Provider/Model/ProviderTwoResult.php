<?php

namespace App\Provider\Model;

use JMS\Serializer\Annotation as Serializer;

class ProviderTwoResult
{
    /**
     * @Serializer\Type("ArrayCollection<App\Provider\Model\ProviderTwo>")
     */
    private $result;

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }


}