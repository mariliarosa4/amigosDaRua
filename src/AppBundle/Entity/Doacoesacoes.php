<?php

namespace AppBundle\Entity;

/**
 * Doacoesacoes
 */
class Doacoesacoes
{
    /**
     * @var integer
     */
    private $iddoacaoacao;

    /**
     * @var \AppBundle\Entity\Acoes
     */
    private $idacao;

    /**
     * @var \AppBundle\Entity\Categoriasdoacoes
     */
    private $idcategoriasdoacao;


    /**
     * Get iddoacaoacao
     *
     * @return integer
     */
    public function getIddoacaoacao()
    {
        return $this->iddoacaoacao;
    }

    /**
     * Set idacao
     *
     * @param \AppBundle\Entity\Acoes $idacao
     *
     * @return Doacoesacoes
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

    /**
     * Set idcategoriasdoacao
     *
     * @param \AppBundle\Entity\Categoriasdoacoes $idcategoriasdoacao
     *
     * @return Doacoesacoes
     */
    public function setIdcategoriasdoacao(\AppBundle\Entity\Categoriasdoacoes $idcategoriasdoacao = null)
    {
        $this->idcategoriasdoacao = $idcategoriasdoacao;

        return $this;
    }

    /**
     * Get idcategoriasdoacao
     *
     * @return \AppBundle\Entity\Categoriasdoacoes
     */
    public function getIdcategoriasdoacao()
    {
        return $this->idcategoriasdoacao;
    }
}
