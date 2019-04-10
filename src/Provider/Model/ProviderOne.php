<?php


namespace App\Provider\Model;


use JMS\Serializer\Annotation as Serializer;

class ProviderOne
{
    /**
     * @Serializer\Type("string")
     */
    private $kod;

    /**
     * @Serializer\Type("float")
     */
    private $oran;

    /**
     * @return mixed
     */
    public function getKod()
    {
        return $this->kod;
    }

    /**
     * @param mixed $kod
     */
    public function setKod($kod): void
    {
        $this->kod = $kod;
    }

    /**
     * @return mixed
     */
    public function getOran()
    {
        return $this->oran;
    }

    /**
     * @param mixed $oran
     */
    public function setOran($oran): void
    {
        $this->oran = $oran;
    }


}