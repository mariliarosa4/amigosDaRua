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
     * @var string
     */
    private $tpusuario;

    /**
     * @var \DateTime
     */
    private $dtnascimento;

    /**
     * @var \DateTime
     */
    private $dtprimeiroacesso;

    /**
     * @var string
     */
    private $codigoprimeiroacesso;


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

    /**
     * Set tpusuario
     *
     * @param string $tpusuario
     *
     * @return Usuarios
     */
    public function setTpusuario($tpusuario)
    {
        $this->tpusuario = $tpusuario;

        return $this;
    }

    /**
     * Get tpusuario
     *
     * @return string
     */
    public function getTpusuario()
    {
        return $this->tpusuario;
    }

    /**
     * Set dtnascimento
     *
     * @param \DateTime $dtnascimento
     *
     * @return Usuarios
     */
    public function setDtnascimento($dtnascimento)
    {
        $this->dtnascimento = $dtnascimento;

        return $this;
    }

    /**
     * Get dtnascimento
     *
     * @return \DateTime
     */
    public function getDtnascimento()
    {
        return $this->dtnascimento;
    }

    /**
     * Set dtprimeiroacesso
     *
     * @param \DateTime $dtprimeiroacesso
     *
     * @return Usuarios
     */
    public function setDtprimeiroacesso($dtprimeiroacesso)
    {
        $this->dtprimeiroacesso = $dtprimeiroacesso;

        return $this;
    }

    /**
     * Get dtprimeiroacesso
     *
     * @return \DateTime
     */
    public function getDtprimeiroacesso()
    {
        return $this->dtprimeiroacesso;
    }

    /**
     * Set codigoprimeiroacesso
     *
     * @param string $codigoprimeiroacesso
     *
     * @return Usuarios
     */
    public function setCodigoprimeiroacesso($codigoprimeiroacesso)
    {
        $this->codigoprimeiroacesso = $codigoprimeiroacesso;

        return $this;
    }

    /**
     * Get codigoprimeiroacesso
     *
     * @return string
     */
    public function getCodigoprimeiroacesso()
    {
        return $this->codigoprimeiroacesso;
    }
}
