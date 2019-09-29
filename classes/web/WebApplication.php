<?php


class WebApplication implements App\Application
{ 

    /**
     * Reveals access to the legacy application core.
     * Should be removed after the complete app is
     * rewritten in the new architectural style
     *
     * @var BaseFactory
     * @deprecated
     */
    private $legacyBaseFactory;

    /**
     * @var \App\Utils\Authenticator
     */
    private $appAuthenticator = null;

    /**
     * WebApplication constructor.
     * @param BaseFactory $legacyBaseFactory
     */
    public function __construct(BaseFactory $legacyBaseFactory)
    {
        $this->legacyBaseFactory = $legacyBaseFactory;
    }

    /**
     * @return \App\Utils\Authenticator
     */
    public function getAppAuthenticator() {
        if (null === $this->appAuthenticator) {
            $this->appAuthenticator = new AuthenticatorImpl($this->legacyBaseFactory->getAuthenticator());
        }
        return $this->appAuthenticator;
    }

    /**
     * @return \App\Exhibition\ExhibitionBoundary
     */
    public function getExhibitionBoundary()
    {
        $exhbitionRepository = new ExhibitionRepositoryImpl(
            $this->legacyBaseFactory->getDbConnection(),
            $this->legacyBaseFactory->getMandantManager()->getMandant()
        );
        return new \App\Exhibition\ExhibitionBoundary($this->getAppAuthenticator(), $exhbitionRepository);
    }

    public function getPictureBoundary()
    {
        $mandant = $this->legacyBaseFactory->getMandantManager()->getMandant();
        $pictureRepository = new PictureRepositoryImpl($this->legacyBaseFactory->getDbConnection(), $mandant);
        $dirName = "uploads/" . $mandant->getMandantId();

        $picUploader = new FileSystemPictureUploader($dirName);
        return new \App\Picture\PictureBoundary($this->getAppAuthenticator(), $pictureRepository, $picUploader);
    }
}