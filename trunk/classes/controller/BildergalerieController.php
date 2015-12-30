<?php

/**
 * Base Controller for our Bildergalerie-Application.
 *
 * User: Felix
 * Date: 30.12.2015
 * Time: 12:15
 */
abstract class BildergalerieController extends Controller
{

    protected $baseFactory;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->baseFactory = new BaseFactory($request->getCookies());;
    }

}