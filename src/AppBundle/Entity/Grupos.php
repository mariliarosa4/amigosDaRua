<?php

namespace AppBundle\Entity;

/**
 * Grupos
 */
class Grupos
{
    /**
     * @var integer
     */
    private $idgrupos;

    /**
     * @var string
     */
    private $nomegrupo;

    /**
     * @var string
     */
    private $telefoneresponsavel;

    /**
     * @var integer
     */
    private $numerointegrantes;

    /**
     * @var \AppBundle\Entity\Usuarios
     */
    private $idusuario;


    /**
     * Get idgrupos
     *
     * @return integer
     */
    public function getIdgrupos()
    {
        return $this->idgrupos;
    }

    /**
     * Set nomegrupo
     *
     * @param string $nomegrupo
     *
     * @return Grupos
     */
    public function setNomegrupo($nomegrupo)
    {
        $this->nomegrupo = $nomegrupo;

        return $this;
    }

    /**
     * Get nomegrupo
     *
     * @return string
     */
    public function getNomegrupo()
    {
        return $this->nomegrupo;
    }

    /**
     * Set telefoneresponsavel
     *
     * @param string $telefoneresponsavel
     *
     * @return Grupos
     */
    public function setTelefoneresponsavel($telefoneresponsavel)
    {
        $this->telefoneresponsavel = $telefoneresponsavel;

        return $this;
    }

    /**
     * Get telefoneresponsavel
     *
     * @return string
     */
    public function getTelefoneresponsavel()
    {
        return $this->telefoneresponsavel;
    }

    /**
     * Set numerointegrantes
     *
     * @param integer $numerointegrantes
     *
     * @return Grupos
     */
    public function setNumerointegrantes($numerointegrantes)
    {
        $this->numerointegrantes = $numerointegrantes;

        return $this;
    }

    /**
     * Get numerointegrantes
     *
     * @return integer
     */
    public function getNumerointegrantes()
    {
        return $this->numerointegrantes;
    }

    /**
     * Set idusuario
     *
     * @param \AppBundle\Entity\Usuarios $idusuario
     *
     * @return Grupos
     */
    public function setIdusuario(\AppBundle\Entity\Usuarios $idusuario = null)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \AppBundle\Entity\Usuarios
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}

