<?php

namespace AppBundle\Entity;

/**
 * Categoriasdoacoes
 */
class Categoriasdoacoes
{
    /**
     * @var integer
     */
    private $idcategoriasdoacoes;

    /**
     * @var string
     */
    private $nomecategoria;

    /**
     * @var string
     */
    private $nomesubcategoria;

    /**
     * @var string
     */
    private $outro;


    /**
     * Get idcategoriasdoacoes
     *
     * @return integer
     */
    public function getIdcategoriasdoacoes()
    {
        return $this->idcategoriasdoacoes;
    }

    /**
     * Set nomecategoria
     *
     * @param string $nomecategoria
     *
     * @return Categoriasdoacoes
     */
    public function setNomecategoria($nomecategoria)
    {
        $this->nomecategoria = $nomecategoria;

        return $this;
    }

    /**
     * Get nomecategoria
     *
     * @return string
     */
    public function getNomecategoria()
    {
        return $this->nomecategoria;
    }

    /**
     * Set nomesubcategoria
     *
     * @param string $nomesubcategoria
     *
     * @return Categoriasdoacoes
     */
    public function setNomesubcategoria($nomesubcategoria)
    {
        $this->nomesubcategoria = $nomesubcategoria;

        return $this;
    }

    /**
     * Get nomesubcategoria
     *
     * @return string
     */
    public function getNomesubcategoria()
    {
        return $this->nomesubcategoria;
    }

    /**
     * Set outro
     *
     * @param string $outro
     *
     * @return Categoriasdoacoes
     */
    public function setOutro($outro)
    {
        $this->outro = $outro;

        return $this;
    }

    /**
     * Get outro
     *
     * @return string
     */
    public function getOutro()
    {
        return $this->outro;
    }
}

