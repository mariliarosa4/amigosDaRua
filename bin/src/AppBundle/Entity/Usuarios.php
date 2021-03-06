<?php

namespace AppBundle\Entity;

/**
 * Usuarios
 */
class Usuarios
{
    /**
     * @var integer
     */
    private $idusuario;

    /**
     * @var string
     */
    private $nmusuario;

    /**
     * @var string
     */
    private $emailusuario;

    /**
     * @var string
     */
    private $senhausuario;


    /**
     * Get idusuario
     *
     * @return integer
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set nmusuario
     *
     * @param string $nmusuario
     *
     * @return Usuarios
     */
    public function setNmusuario($nmusuario)
    {
        $this->nmusuario = $nmusuario;

        return $this;
    }

    /**
     * Get nmusuario
     *
     * @return string
     */
    public function getNmusuario()
    {
        return $this->nmusuario;
    }

    /**
     * Set emailusuario
     *
     * @param string $emailusuario
     *
     * @return Usuarios
     */
    public function setEmailusuario($emailusuario)
    {
        $this->emailusuario = $emailusuario;

        return $this;
    }

    /**
     * Get emailusuario
     *
     * @return string
     */
    public function getEmailusuario()
    {
        return $this->emailusuario;
    }

    /**
     * Set senhausuario
     *
     * @param string $senhausuario
     *
     * @return Usuarios
     */
    public function setSenhausuario($senhausuario)
    {
        $this->senhausuario = $senhausuario;

        return $this;
    }

    /**
     * Get senhausuario
     *
     * @return string
     */
    public function getSenhausuario()
    {
        return $this->senhausuario;
    }
}
