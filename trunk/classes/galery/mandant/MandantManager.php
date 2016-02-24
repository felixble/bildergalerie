<?php

/**
 * Manager class for the mandant.
 * With the request and session information
 * the currently used mandant will be detected.
 * Otherwise the default mandant will be laoded.
 *
 * Created by PhpStorm.
 * User: Felix
 * Date: 13.02.2016
 * Time: 19:02
 */
class MandantManager
{
    const MANDANT_KEY = "mandant";

    /**
     * The mandant which is currently
     * used.
     *
     * @var Mandant
     */
    private $mandant;

    /**
     * @var SessionManager
     */
    private $sessManager;

    public function __construct(Request $request, \Simplon\Mysql\Mysql $dbConn, $sessManager)
    {
        $this->sessManager = $sessManager;

        $mandant = $this->getMandantFromRequest($request, $dbConn);

        if (null == $mandant) { // the request does not contain the mandant
            $mandant = $this->getMandantFromCookies();
        }

        if (null == $mandant) {
            // mandant is neither stored in the cookies nor given in the request
            // so we must check the domain and load the default mandant

            $domain = $_SERVER['HTTP_HOST'];
            $mandant = $this->getDefaultMandant($dbConn, $domain);
            if (null == $mandant) {
                throw new Exception("There is no default mandant given for the domain $domain.");
            }
        }

        $this->setMandant($mandant);
    }

    /**
     * Returns the mandant id from the request or
     * {@code null} if not given.
     *
     * @param Request $request
     * @param \Simplon\Mysql\Mysql $dbConn
     * @return null|string mandant id
     */
    private function getMandantFromRequest(Request $request, \Simplon\Mysql\Mysql $dbConn) {
        if (array_key_exists(self::MANDANT_KEY, $request->getGetParam())) {
            $id = $request->getGetParam()[self::MANDANT_KEY];
            $mandantDAO = new MandantDAO($dbConn);
            return $mandantDAO->queryMandantForId($id);
        }
        return null;
    }

    /**
     * Returns the mandant saved in the cookies or
     * {@code null} if not given.
     *
     * @return Mandant|null
     */
    private function getMandantFromCookies()
    {
        $segment = $this->sessManager->getMandantSegment();

        $mandantString = $segment->get(self::MANDANT_KEY);
        if ($mandantString != null) {
            return unserialize($mandantString);
        }
        return null;
    }

    /**
     * @return Mandant
     */
    public function getMandant()
    {
        return $this->mandant;
    }

    private function getDefaultMandant($dbConn, $domain)
    {
        $mandantDAO = new MandantDAO($dbConn);
        return $mandantDAO->queryDefaultMandantForDomain($domain);
    }

    /**
     * Set the mandant attribute and stores the
     * mandant in the session.
     *
     * @param Mandant $mandant
     */
    private function setMandant($mandant)
    {
        $segment = $this->sessManager->getMandantSegment();
        $segment->set(self::MANDANT_KEY, serialize($mandant));
        $this->mandant = $mandant;
    }


}