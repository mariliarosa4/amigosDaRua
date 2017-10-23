<?php

namespace AppBundle\Entity;

/**
 * Locaisacoes
 */
class Locaisacoes
{
    /**
     * @var integer
     */
    private $idlocaisacoes;

    /**
     * @var string
     */
    private $endereco;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;

    /**
     * @var \AppBundle\Entity\Acoes
     */
    private $idacao;


    /**
     * Get idlocaisacoes
     *
     * @return integer
     */
    public function getIdlocaisacoes()
    {
        return $this->idlocaisacoes;
    }

    /**
     * Set endereco
     *
     * @param string $endereco
     *
     * @return Locaisacoes
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco
     *
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Locaisacoes
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Locaisacoes
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set idacao
     *
     * @param \AppBundle\Entity\Acoes $idacao
     *
     * @return Locaisacoes
     */
    public function setIdacao(\AppBundle\Entity\Acoes $idacao = null)
    {
        $this->idacao = $idacao;

        return $this;
    }

    /**
     * Get idacao
     *
     * @return \AppBundle\Entity\Acoes
     */
    public function getIdacao()
    {
        return $this->idacao;
    }
}

