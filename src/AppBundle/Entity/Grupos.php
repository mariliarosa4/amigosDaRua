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
    private $nomeresponsavel;

    /**
     * @var string
     */
    private $emailresponsavel;

    /**
     * @var string
     */
    private $telefoneresponsavel;

    /**
     * @var integer
     */
    private $numerointegrantes;


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
     * Set nomeresponsavel
     *
     * @param string $nomeresponsavel
     *
     * @return Grupos
     */
    public function setNomeresponsavel($nomeresponsavel)
    {
        $this->nomeresponsavel = $nomeresponsavel;

        return $this;
    }

    /**
     * Get nomeresponsavel
     *
     * @return string
     */
    public function getNomeresponsavel()
    {
        return $this->nomeresponsavel;
    }

    /**
     * Set emailresponsavel
     *
     * @param string $emailresponsavel
     *
     * @return Grupos
     */
    public function setEmailresponsavel($emailresponsavel)
    {
        $this->emailresponsavel = $emailresponsavel;

        return $this;
    }

    /**
     * Get emailresponsavel
     *
     * @return string
     */
    public function getEmailresponsavel()
    {
        return $this->emailresponsavel;
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
     * @var string
     */
    private $codigoprimeiroacesso;

    /**
     * @var \DateTime
     */
    private $dataprimeiroacesso;

    /**
     * @var \AppBundle\Entity\Usuarios
     */
    private $idusuario;


    /**
     * Set codigoprimeiroacesso
     *
     * @param string $codigoprimeiroacesso
     *
     * @return Grupos
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

    /**
     * Set dataprimeiroacesso
     *
     * @param \DateTime $dataprimeiroacesso
     *
     * @return Grupos
     */
    public function setDataprimeiroacesso($dataprimeiroacesso)
    {
        $this->dataprimeiroacesso = $dataprimeiroacesso;

        return $this;
    }

    /**
     * Get dataprimeiroacesso
     *
     * @return \DateTime
     */
    public function getDataprimeiroacesso()
    {
        return $this->dataprimeiroacesso;
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
