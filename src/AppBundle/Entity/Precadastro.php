<?php

namespace AppBundle\Entity;

/**
 * Precadastro
 */
class Precadastro
{
    /**
     * @var integer
     */
    private $idprecadastro;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $codigovalidacao;

    /**
     * @var \DateTime
     */
    private $datavalidade;

    /**
     * @var string
     */
    private $flvalidado;

    /**
     * @var string
     */
    private $nomeresponsavel;

    /**
     * @var string
     */
    private $senha;

    /**
     * @var \AppBundle\Entity\Grupos
     */
    private $gruposgrupos;


    /**
     * Get idprecadastro
     *
     * @return integer
     */
    public function getIdprecadastro()
    {
        return $this->idprecadastro;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Precadastro
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set codigovalidacao
     *
     * @param string $codigovalidacao
     *
     * @return Precadastro
     */
    public function setCodigovalidacao($codigovalidacao)
    {
        $this->codigovalidacao = $codigovalidacao;

        return $this;
    }

    /**
     * Get codigovalidacao
     *
     * @return string
     */
    public function getCodigovalidacao()
    {
        return $this->codigovalidacao;
    }

    /**
     * Set datavalidade
     *
     * @param \DateTime $datavalidade
     *
     * @return Precadastro
     */
    public function setDatavalidade($datavalidade)
    {
        $this->datavalidade = $datavalidade;

        return $this;
    }

    /**
     * Get datavalidade
     *
     * @return \DateTime
     */
    public function getDatavalidade()
    {
        return $this->datavalidade;
    }

    /**
     * Set flvalidado
     *
     * @param string $flvalidado
     *
     * @return Precadastro
     */
    public function setFlvalidado($flvalidado)
    {
        $this->flvalidado = $flvalidado;

        return $this;
    }

    /**
     * Get flvalidado
     *
     * @return string
     */
    public function getFlvalidado()
    {
        return $this->flvalidado;
    }

    /**
     * Set nomeresponsavel
     *
     * @param string $nomeresponsavel
     *
     * @return Precadastro
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
     * Set senha
     *
     * @param string $senha
     *
     * @return Precadastro
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get senha
     *
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set gruposgrupos
     *
     * @param \AppBundle\Entity\Grupos $gruposgrupos
     *
     * @return Precadastro
     */
    public function setGruposgrupos(\AppBundle\Entity\Grupos $gruposgrupos = null)
    {
        $this->gruposgrupos = $gruposgrupos;

        return $this;
    }

    /**
     * Get gruposgrupos
     *
     * @return \AppBundle\Entity\Grupos
     */
    public function getGruposgrupos()
    {
        return $this->gruposgrupos;
    }
}

